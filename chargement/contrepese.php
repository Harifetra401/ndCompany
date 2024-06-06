<?php
require('../session.php');
?>
<?php

require('../db.php');

function get_name($id_to_get)
{
  require('../db.php');
  $new_sql = "SELECT * FROM poisson WHERE id = $id_to_get";
  $new_st = $db->prepare($new_sql);
  $new_st->execute();
  $fetch_name = $new_st->fetch();
  return $fetch_name["nomFilao"];
}


// retourne le poid apres la contrepesage du chargement
function return_poid($id_poisson)
{
  require('../db.php');
  $numeroFacture = $_GET["num"];
  $selection = $db->prepare("SELECT * FROM apres_charge WHERE num=$numeroFacture AND id_poisson=$id_poisson");
  $selection->execute();
  $fetchAll = $selection->fetchAll();
  $nbr = count($fetchAll);
  if ($nbr) {
    $qtt_f = $fetchAll[0]['qtt'];
    return $qtt_f;
  }
  return false;
}

$numeroFacture = $_GET["num"];
$select_sql = "SELECT id_poisson, SUM(sac) AS total_sac, SUM(qtt) AS total_qtt FROM detailfilaosortie WHERE id_sortie=$numeroFacture GROUP BY id_poisson ORDER BY id_poisson DESC";
$stmt_contre = $db->prepare($select_sql);
$stmt_contre->execute();

$all_produit = $stmt_contre->fetchAll(PDO::FETCH_ASSOC);
$count = 0;
?>
<!DOCTYPE html>

<html lang="en" class="light-style layout-menu-fixed" dir="ltr" data-theme="theme-default" data-assets-path="../assets/" data-template="vertical-menu-template-free">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

  <title>Logiciel de Gestion</title>

  <meta name="description" content="" />

  <!-- Favicon -->
  <link rel="icon" type="image/x-icon" href="../assets/img/favicon/favicon.ico" />

  <!-- Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap" rel="stylesheet" />

  <!-- Icons. Uncomment required icon fonts -->
  <link rel="stylesheet" href="../assets/vendor/fonts/boxicons.css" />

  <!-- Core CSS -->
  <link rel="stylesheet" href="../assets/vendor/css/core.css" class="template-customizer-core-css" />
  <link rel="stylesheet" href="../assets/vendor/css/theme-default.css" class="template-customizer-theme-css" />
  <link rel="stylesheet" href="../assets/css/demo.css" />

  <!-- Vendors CSS -->
  <link rel="stylesheet" href="../assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />

  <link rel="stylesheet" href="../assets/vendor/libs/apex-charts/apex-charts.css" />

  <!-- Page CSS -->

  <!-- Helpers -->
  <script src="../assets/vendor/js/helpers.js"></script>

  <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
  <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
  <script src="../assets/js/config.js"></script>
</head>

<body>
  <!-- Layout wrapper -->
  <div class="layout-wrapper layout-content-navbar">
    <div class="layout-container">

      <!-- Menu -->
      <?php require('../nav/menu.php') ?>
      <!-- / Menu -->

      <!-- Layout container -->
      <div class="layout-page">

        <!-- Navbar -->
        <?php $title = 'Traitement' ?>
        <?php require('../nav/header.php') ?>
        <!-- / Navbar -->

        <!-- Content wrapper -->
        <div class="content-wrapper">
          <!-- Content -->

          <div class="container-fluid flex-grow-1 container-p-y">
            <div class="card">
              <h5 class="card-header"> Traitement du chargement n° <?= $numeroFacture ?></h5>
              <div class="table-responsive text-nowrap">
                <table class="table">
                  <thead>
                    <td>Nom</td>
                    <td>Nombre de sac</td>
                    <td>Initial</td>
                    <td>Contre Pesage</td>
                    <td>Décication</td>
                  </thead>
                  <tbody>
                    <!-- selection des facture aujourd'hui -->
                    <?php
                    foreach ($all_produit as $get_fact) {

                    ?>
                      <tr>

                        <td><?= get_name($get_fact['id_poisson']) ?></td>
                        <td><?= $get_fact['total_sac'] ?></td>
                        <td><?= $get_fact['total_qtt'] ?> KG</td>
                        <?php
                        if (return_poid($get_fact['id_poisson'])) {
                        ?>
                          <td><?= return_poid($get_fact['id_poisson']) ?> KG</td>
                          <td><?= round(100 - (return_poid($get_fact['id_poisson']) * 100 / $get_fact['total_qtt']), 2) ?> %</td>
                        <?php
                        } else {
                        ?>
                          <td>
                            <form action="ajout_contre.php" method="post">
                              <input type="hidden" name="num" value="<?= $numeroFacture ?>">
                              <input type="hidden" name="id_poisson" value="<?= $get_fact['id_poisson'] ?>">
                              <input type="number" name="qtt" required />
                              <input type="submit" class='btn btn-success' value="valider" />
                            </form>
                          </td>
                        <?php
                        }
                        ?>
                      </tr>
                    <?php  } ?>


                  </tbody>
                </table>
              </div>
            </div>
            <!--/ Layout Demo -->
          </div>
          <!-- / Content -->

          <!-- Footer -->


          <div class="content-backdrop fade"></div>
        </div>


        <!-- Content wrapper -->
      </div>
      <!-- / Layout page -->
    </div>

    <!-- Overlay -->
    <div class="layout-overlay layout-menu-toggle"></div>
  </div>
  <!-- / Layout wrapper -->

  <!-- Core JS -->
  <!-- build:js assets/vendor/js/core.js -->
  <script src="../assets/vendor/libs/jquery/jquery.js"></script>
  <script src="../assets/vendor/libs/popper/popper.js"></script>
  <script src="../assets/vendor/js/bootstrap.js"></script>
  <script src="../assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>

  <script src="../assets/vendor/js/menu.js"></script>
  <!-- endbuild -->

  <!-- Vendors JS -->
  <script src="../assets/vendor/libs/apex-charts/apexcharts.js"></script>

  <!-- Main JS -->
  <script src="../assets/js/main.js"></script>

  <!-- Page JS -->
  <script src="../assets/js/dashboards-analytics.js"></script>

  <!-- Place this tag in your head or just before your close body tag. -->
  <script async defer src="https://buttons.github.io/buttons.js"></script>
</body>

</html>