<?php
  require('../session.php');
?>
<!DOCTYPE html>
<html lang="en" class="light-style layout-menu-fixed" dir="ltr" data-theme="theme-default" data-assets-path="../assets/"
  data-template="vertical-menu-template-free">

<head>
  <meta charset="utf-8" />
  <meta name="viewport"
    content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

  <title>Logiciel de Gestion</title>

  <meta name="description" content="" />

  <!-- Favicon -->
  <link rel="icon" type="image/x-icon" href="../assets/img/favicon/favicon.ico" />

  <!-- Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link
    href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
    rel="stylesheet" />

  <!-- Icons. Uncomment required icon fonts -->
  <link rel="stylesheet" href="../assets/vendor/fonts/boxicons.css" />

  <!-- Core CSS -->
  <link rel="stylesheet" href="../assets/vendor/css/core.css" class="template-customizer-core-css" />
  <link rel="stylesheet" href="../assets/vendor/css/theme-default.css" class="template-customizer-theme-css" />
  <link rel="stylesheet" href="../assets/css/demo.css" />

  <!-- Vendors CSS -->
  <link rel="stylesheet" href="../assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />

  <!-- Page CSS -->
  <script src="../dashboardata/chart.js"></script>
  <!-- Helpers -->
  <script src="../assets/vendor/js/helpers.js"></script>
  <script src="../assets/js/config.js"></script>
</head>

<body>
  <!-- Layout wrapper -->
  <div class="layout-wrapper layout-content-navbar">
    <div class="layout-container">
      <!-- Menu -->
      <?php require('../nav/menu.php')?>
      <!-- / Menu -->

      <!-- Layout container -->
      <div class="layout-page">
        <!-- Navbar -->
        <?php $title='Facture Numero: '.$_GET['num']?>
        <?php require('../nav/header.php')?>
        <!-- / Navbar -->

        <!-- Content wrapper -->
        <div class="content-wrapper">
          <!-- Content -->
          <div class="card-body">
            <!-- Social Accounts -->
            <div class="card" id="content">
              <div class="col-md">
                <div class="container mt-4">
                  <div class="text-center mb-3">
                    <h1 class="h4">Total sortie Tranche</h1>
                    <p class="small">Date : <?=$date?></p>
                  </div>

                  <!-- Form for filtering -->
                  <form method="GET" action="">
                    <div class="row mb-3">
                      <div class="col">
                        <label for="dayFilter">Filtrer par jour :</label>
                        <input type="date" name="dayFilter" id="dayFilter" class="form-control" value="<?= isset($_GET['dayFilter']) ? $_GET['dayFilter'] : '' ?>">
                      </div>
                      <div class="col">
                        <label for="monthFilter">Filtrer par mois :</label>
                        <input type="month" name="monthFilter" id="monthFilter" class="form-control" value="<?= isset($_GET['monthFilter']) ? $_GET['monthFilter'] : '' ?>">
                      </div>
                      <div class="col mt-4">
                        <button type="submit" class="btn btn-primary">Appliquer le filtre</button>
                      </div>
                    </div>
                  </form>

                  <!-- Table displaying results -->
                  <table class="table table-bordered mb-3">
                    <thead class="table-light">
                      <tr>
                        <th>Article</th>
                        <th>Nombre de Colis</th>
                        <th>Quantité</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                        require('../db.php');

                        // Base query
                        $query = "SELECT * FROM detailfilaosortie WHERE qttTranche != 0";

                        // Check if day filter is applied
                        if (isset($_GET['dayFilter']) && !empty($_GET['dayFilter'])) {
                          $dayFilter = $_GET['dayFilter'];
                          $query .= " AND DATE(dateTranche) = :dayFilter";
                        }

                        // Check if month filter is applied
                        if (isset($_GET['monthFilter']) && !empty($_GET['monthFilter'])) {
                          $monthFilter = $_GET['monthFilter'];
                          $query .= " AND DATE_FORMAT(dateTranche, '%Y-%m') = :monthFilter";
                        }

                        $selection = $db->prepare($query);

                        // Bind parameters if filters are set
                        if (isset($dayFilter)) {
                          $selection->bindParam(':dayFilter', $dayFilter);
                        }

                        if (isset($monthFilter)) {
                          $selection->bindParam(':monthFilter', $monthFilter);
                        }

                        $selection->execute();
                        $fetchAll = $selection->fetchAll();

                        // Function to get the name of the fish
                        function getNomPoisson($id_selector) {
                          require('../db.php');
                          $getBy = $db->prepare("SELECT nomFilao FROM poisson WHERE id = :id_selector");
                          $getBy->execute(['id_selector' => $id_selector]);
                          $fetchBy = $getBy->fetch();

                          return $fetchBy ? $fetchBy["nomFilao"] : "Unknown";
                        }

                        $total = 0;
                        $totalColis = 0;
                        foreach ($fetchAll as $fetch) {
                          $id_poisson = $fetch['id_poisson'];
                          $qtt_poisson = $fetch['qttTranche'];
                          $sac_poisson = $fetch['sac'];
                          $typ = $fetch['typ'];  // assuming there's a 'typ' column
                          $total += $qtt_poisson;
                          $totalSac += ($typ == 1) ? $sac_poisson : 0;
                          $totalCarton += ($typ == 2) ? $sac_poisson : 0;
                          $totalbac += ($typ == 3) ? $sac_poisson : 0;

                          // Conditionally display sac_poisson or carton_poisson
                          $displayValue = ($typ == 1) ? $sac_poisson."&nbsp;&nbsp;&nbsp;(Sac)" :
                                          (($typ == 2) ? $sac_poisson."&nbsp;&nbsp;&nbsp;(Carton)" : 
                                          $sac_poisson."&nbsp;&nbsp;&nbsp;(Bac)");
                      ?>
                        <tr>
                          <td><i class="fab fa-angular fa-lg text-danger me-3"></i> <strong><?= $id_poisson ?></strong></td>
                          <td><?= $displayValue ?></td>
                          <td><?= $qtt_poisson ?></td>
                        </tr>
                      <?php
                        }
                      ?>
                    </tbody>
                  </table>

                  <br><br>
                  <div class="mb-3"></div>

                  <div>
                    <table class="table table-bordered">
                      <thead class="table-light">
                        <tr>
                          <th>Colis</th>
                          <th>Poids</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr><td>Carton : <?=$totalCarton?></td><td> <?=$total?></td></tr>
                        <tr><td>Sac : <?=$totalSac?></td><td></td></tr>
                        <tr><td>Bac : <?=$totalbac?></td><td></td></tr>
                      </tbody>
                    </table>
                  </div>

                  <div class="mt-3">
                    <p></p>
                  </div>
                </div>
              </div>
              <button class="btn btn-primary" onclick="imprimerContenu()">Imprimer</button>
            </div>
          </div>

          <div class="content-backdrop fade"></div>
        </div>
      </div>
    </div>

    <div class="layout-overlay layout-menu-toggle"></div>
  </div>

  <script>
    function imprimerContenu() {
      var contenuDiv = document.getElementById('content').innerHTML;
      var fenetreImpression = window.open('', '_blank');
      fenetreImpression.document.write('<html><head><link rel="stylesheet" href="../assets/vendor/css/core.css" class="template-customizer-core-css"/><link rel="stylesheet" href="../assets/vendor/css/theme-default.css" class="template-customizer-theme-css" /><link rel="stylesheet" href="../assets/css/demo.css" /><title>Impression</title></head><body>');
      fenetreImpression.document.write(contenuDiv);
      fenetreImpression.document.write('</body></html>');
      fenetreImpression.document.close();
      fenetreImpression.print();
    }
  </script>
</body>
</html>
