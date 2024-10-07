<?php

require('../db.php');

$date= $_GET['date'];
// Fonction pour récupérer le nom du poisson
function get_name($id_to_get) {
    require('../db.php');
    $new_sql = "SELECT * FROM poisson WHERE id = :id_to_get";
    $new_st = $db->prepare($new_sql);
    $new_st->bindParam(':id_to_get', $id_to_get);
    $new_st->execute();
    $fetch_name = $new_st->fetch();
    return $fetch_name["nomfilao"];
}

$date = $_GET['date']; // Date au format YYYY-MM-DD
$date_parts = explode('-', $date); // Sépare l'année, le mois, et le jour

// Vérifiez que $date contient bien une date valide au format attendu
if (count($date_parts) == 3) {
    $year = $date_parts[0];
    $month = $date_parts[1];
    $day = $date_parts[2];
    
    // Modifiez la requête pour grouper par id_poisson et additionner les quantités
    $select_sql = "SELECT id_poisson, SUM(qtt) AS total_qtt FROM detailfilao 
                   WHERE YEAR(date) = :year AND MONTH(date) = :month AND DAY(date) = :day
                   GROUP BY id_poisson";
    
    $stmt_contre = $db->prepare($select_sql);
    $stmt_contre->bindParam(':year', $year, PDO::PARAM_INT);
    $stmt_contre->bindParam(':month', $month, PDO::PARAM_INT);
    $stmt_contre->bindParam(':day', $day, PDO::PARAM_INT);
    $stmt_contre->execute();

    $all_produit = $stmt_contre->fetchAll(PDO::FETCH_ASSOC);
} else {
    die("Format de date incorrect.");
}


?>
<!DOCTYPE html>
<html lang="en" class="light-style layout-menu-fixed" dir="ltr" data-theme="theme-default" data-assets-path="../assets/"
  data-template="vertical-menu-template-free">

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
      <?php require('../nav/menu.php')?>
      <!-- / Menu -->

      <!-- Layout container -->
      <div class="layout-page">
        <!-- Navbar -->
        <?php $title = 'Traitement'?>
        <?php require('../nav/header.php')?>
        <!-- / Navbar -->

        <!-- Content wrapper -->
        <div class="content-wrapper">
          <!-- Content -->

          <div class="container-fluid flex-grow-1 container-p-y">
            <div class="card">
              <h5 class="card-header">Traitement</h5>
              <div class="table-responsive text-nowrap"  style="max-height: 300px; overflow-y: auto;">
                <table class="table table-bordered table-striped">
                  <thead class="thead-light">
                    <tr>
                      <th>Nom</th>
                      <th>Initial</th>
                      <th>Contre Pesage (kg)</th>
                      <th>Sortie</th>
                      <th>SsGl. Cite</th>
                      <th>SsGl. Tana</th>
                      <th>R.Traiter</th>
                    </tr>
                  </thead>
                  <tbody>
                      <?php foreach ($all_produit as $get_fact) { 
                        // Vérifiez si le produit existe déjà dans bdAchat
                        $check_sql = "SELECT * FROM bdAchat WHERE date = :numFact AND article = :id_poisson";
                        $check_stmt = $db->prepare($check_sql);
                        $check_stmt->bindParam(':numFact', $date);
                        $check_stmt->bindParam(':id_poisson', $get_fact['id_poisson']);
                        $check_stmt->execute();
                        $existing_product = $check_stmt->fetch(PDO::FETCH_ASSOC);
                        
                        $rest =  $existing_product ? $existing_product['poids'] : 0;
                        $contre_Pese_value = $existing_product ? $existing_product['contrePese'] : 0;
                        $sortie_value = $existing_product ? $existing_product['SortieLocal'] : 0;
                        $sgcite_value = $existing_product ? $existing_product['sous_glaceLocal'] : 0;
                        $sgTana_value = $existing_product ? $existing_product['sous_glaceTana'] : 0;
                        $obs_value = $existing_product ? $contre_Pese_value - $sortie_value -$sgcite_value -$sgTana_value: 0;
                        $total += $get_fact['total_qtt'];
                        $totalContre += $contre_Pese_value;
                        $totalsortie += $sortie_value;
                        $totalSglMg += $sgcite_value;
                        $totalSgTana += $sgTana_value;
                        $totalTraite += $obs_value;
                        
                      ?>
                        <tr>
                          <form method="POST" action="add_new.php">
                            <input type="hidden" name="num" value="<?= $date ?>">
                            <input type="hidden" name="id_poisson" value="<?= $get_fact['id_poisson'] ?>">
                            
                            <td><?= get_name($get_fact['id_poisson']) ?></td>
                            <td id="poid_init"><?= $get_fact['total_qtt'] ?> KG<input type="hidden" name="poid" value="<?= $get_fact['total_qtt'] ?>"></td>
                            <td><input class="form-control" type="text" name="contre_Pese" value="<?= $contre_Pese_value ?>" placeholder="Contre Pesage"></td>
                            <td><input class="form-control" type="text" name="sortie" value="<?= $sortie_value ?>" placeholder="Sortie"></td>
                            <td><input class="form-control" type="text" name="sgcite" value="<?= $sgcite_value ?>" placeholder="Sous Glace Cite"></td>
                            <td><input class="form-control" type="hidden" name="datedate" value="<?= $date ?>" placeholder="Sous Glace Tana">
                            <input class="form-control" type="text" name="sgTana" value="<?= $sgTana_value ?>" placeholder="Sous Glace Tana">
                            <input type='submit' class = 'd-none'>
                            </td>
                            <td><?= $obs_value ?></td>
                            <td><input class="form-control" type="text" name="obs" placeholder="Observation"></td>
                          </form>
                        </tr>
                      <?php } ?>
                    <tr>
                        <td>TOTAL</td>
                        <td><?= $total ?></td>
                        <td><?= $totalContre ?></td>
                        <td><?= $totalsortie ?></td>
                        <td><?= $totalSglMg ?></td>
                        <td><?= $totalSgTana ?></td>
                        <td><?= $totalTraite ?></td>
                      </tr>
                    </tbody>

                </table>
              </div>
              <table>
                  

              </table>

            </div>

            <!-- Commentaire pour cette facture -->
            <div class="container-fluid flex-grow-1 container-p-y">
              <div class="card">
                <h5 class="card-header">Commentaire pour cette facture</h5>
                <div class="card-body">
                  <form id="formAuthentication" class="mb-3" action="add_coms.php" method="POST">
                    <input type="hidden" name="num_fact" value="<?= $_GET['date'] ?>">
                    <?php require('coms.php')?>
                    <button class="btn btn-primary m-1" type="submit">Ajouter</button>
                  </form>
                </div>
              </div>
            </div>
          </div>


  <!-- Button trigger modal -->
  <button type="button" class="btn btn-primary m-3" data-bs-toggle="modal" data-bs-target="#commentModal">
    Bon d' Achat
  </button>
<style>
    .custom-modal-dialog {
    min-width: 800px;
}

</style>
  <!-- Modal -->
 <div class="modal fade" id="commentModal" tabindex="-1" aria-labelledby="commentModalLabel" aria-hidden="true">
    <div class="modal-dialog custom-modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="commentModalLabel">Commentaire pour cette facture</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="card">
            <h5 class="card-header">Traitement</h5>
            <div class="table-responsive text-nowrap">
              <table class="table">
                <thead>
                  <tr>
                    <th>Nom</th>
                    <th>Initial</th>
                    <th>C. Pes</th>
                    <th>Sortie</th>
                    <th>SsGl. Cite</th>
                    <th>SsGl. Tana</th>
                    <th>R.Traiter</th>
                   
                  </tr>
                </thead>
                <tbody>
                  <?php foreach ($all_produit as $get_fact) { 
                    // Vérifier si le produit existe déjà dans bdAchat
                    $check_sql = "SELECT * FROM bdAchat WHERE numFact = :numFact AND article = :id_poisson";
                    $check_stmt = $db->prepare($check_sql);
                    $check_stmt->bindParam(':numFact', $date);
                    $check_stmt->bindParam(':id_poisson', $get_fact['id_poisson']);
                    $check_stmt->execute();
                    $existing_product = $check_stmt->fetch(PDO::FETCH_ASSOC);
        
                    $contre_Pese_value = $existing_product ? $existing_product['contrePese'] : '';
                    $sortie_value = $existing_product ? $existing_product['SortieLocal'] : '';
                    $sgcite_value = $existing_product ? $existing_product['sous_glaceLocal'] : '';
                    $sgTana_value = $existing_product ? $existing_product['sous_glaceTana'] : '';
                    $obs_value = $existing_product ? $existing_product['RestAtraiter'] : '';
                    $total += $get_fact['qtt'];
                  ?>
                  <tr>
                    <td><?= get_name($get_fact['id_poisson']) ?></td>
                    <td><?= $get_fact['qtt'] ?> KG</td>
                    <td><?= $contre_Pese_value ?></td>
                    <td><?= $sortie_value ?></td>
                    <td><?= $sgcite_value ?></td>
                    <td><?= $sgTana_value ?></td>
                    <td><?= $obs_value ?></td>
                    <td></td>
                  </tr>
                  <?php } ?>
                  
                </tbody>
              </table>
            
          </div>
          
            <button class="btn btn-primary m-1" type="submit">Imprimer</button>
          
        </div>
      </div>
    </div>
  </div>
</div>



          <!-- / Content -->
          <div class="content-backdrop fade"></div>
        </div>
        <!-- Content wrapper -->
      </div>
      <!-- / Layout page -->
    </div>
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
  <!-- Core JS and other scripts -->
</body>
</html>
