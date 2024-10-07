<?php

require('../db.php');

// Fonction pour récupérer le nom du poisson
function get_name($id_to_get) {
    require('../db.php');
    $new_sql = "SELECT * FROM poisson WHERE id = :id_to_get";
    $new_st = $db->prepare($new_sql);
    $new_st->bindParam(':id_to_get', $id_to_get, PDO::PARAM_INT); // sécurisation du paramètre
    $new_st->execute();
    $fetch_name = $new_st->fetch();
    return $fetch_name ? $fetch_name["nomfilao"] : 'Nom indisponible';
}

// Récupération de la date depuis la requête GET
$date = isset($_GET['date']) ? $_GET['date'] : null;

// Vérification du format de la date et de sa présence
if (!$date) {
    die("Date invalide ou manquante.");
}

$select_sql = "SELECT * FROM bdAchat WHERE RestAtraiter	!= 0 AND date = :date";
$stmt_contre = $db->prepare($select_sql);
$stmt_contre->bindParam(':date', $date, PDO::PARAM_STR); // sécurisation de la date
$stmt_contre->execute();

$all_produit = $stmt_contre->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="en" class="light-style layout-menu-fixed" dir="ltr" data-theme="theme-default" data-assets-path="../assets/"
  data-template="vertical-menu-template-free">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
  <title>Logiciel de Gestion</title>

  <!-- Favicon -->
  <link rel="icon" type="image/x-icon" href="../assets/img/favicon/favicon.ico" />

  <!-- Fonts and Styles -->
  <link rel="stylesheet" href="../assets/vendor/fonts/boxicons.css" />
  <link rel="stylesheet" href="../assets/vendor/css/core.css" class="template-customizer-core-css" />
  <link rel="stylesheet" href="../assets/vendor/css/theme-default.css" class="template-customizer-theme-css" />
  <link rel="stylesheet" href="../assets/css/demo.css" />
  <link rel="stylesheet" href="../assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />
  <link rel="stylesheet" href="../assets/vendor/libs/apex-charts/apex-charts.css" />

  <!-- Scripts -->
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
        <?php $title = 'Traitement'?>
        <?php require('../nav/header.php')?>
        <!-- / Navbar -->

        <!-- Content wrapper -->
        <div class="content-wrapper">
          <div class="container-fluid flex-grow-1 container-p-y">
            <div class="card">
              <h5 class="card-header"></h5>
              <div class="table-responsive text-nowrap"  style="max-height: 400px; overflow-y: auto;">
                <table class="table table-bordered table-striped">
                  <thead class="thead-light">
                    <tr>
                      <th>Nom</th>
                      <th>R.Traiter</th>
                      <th>Fillet</th>
                      <th>TT.sqlt</th>
                      <th>S.AE</th>
                      <th>Autre</th>
                      <th>Nom Entrer</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php foreach ($all_produit as $get_fact) { 
                      $check_sql = "SELECT * FROM traitement WHERE  id_poisson = :id_poisson AND  date = :numFact";
                      $check_stmt = $db->prepare($check_sql);
                      $check_stmt->bindParam(':numFact', $date, PDO::PARAM_STR);
                      $check_stmt->bindParam(':id_poisson', $get_fact['article'], PDO::PARAM_INT);
                      $check_stmt->execute();
                      $existing_product = $check_stmt->fetch(PDO::FETCH_ASSOC);

                      // Pré-remplir les valeurs si elles existent dans la table traitement
                      $entrerFillet = $existing_product ? $existing_product['EntrerFillet'] : 0;
                      $entrerTTSqlt = $existing_product ? $existing_product['EntrerTTSqlt'] : 0;
                      $EntrerSae = $existing_product ? $existing_product['EntrerSae'] : 0;
                      $EntrerAutre = $existing_product ? $existing_product['EntrerAutre'] : 0;
                      $Pdecise = $existing_product ? $existing_product['Pdecise'] : '';
                      $total += $get_fact['RestAtraiter'];
                      $Rest = $get_fact['RestAtraiter'];
                      $decic = 100 - ((($entrerFillet + $entrerTTSqlt + $EntrerSae + $EntrerAutre)* 100)/$Rest);
                      $TotalFillet += $entrerFillet;
                      $TotalSqlt += $entrerTTSqlt;
                      $TotalSae += $EntrerSae;
                      $TotalAutre += $EntrerAutre; 
                      
                      ?>
                    
                      <tr>
                        <form method="POST" action="addtraitement.php">
                          <input type="hidden" name="id_poisson" value="<?= $get_fact['article'] ?>">
                          <td><?= get_name($get_fact['article']) ?></td>
                          <td>
                              <input type="hidden" name="poidTraite" value="<?= $get_fact['RestAtraiter'] ?>">
                              <?= $get_fact['RestAtraiter'] ?>
                          </td>
                          <td>
                              <input class="form-control" type="text" name="EntrerFillet" value="<?= $entrerFillet ?>" placeholder="Entrer Fillet">
                          </td>
                          <td>
                              <input class="form-control" type="text" name="EntrerTTSqlt" value="<?= $entrerTTSqlt ?>" placeholder="Entrer TT.sqlt">
                          </td>
                          <td>
                              <input class="form-control" type="text" name="EntrerSae" value="<?= $EntrerSae ?>" placeholder="Entrer S.AE">
                          </td>
                          <td>
                              <input class="form-control" type="text" name="EntrerAutre" value="<?= $EntrerAutre ?>" placeholder="Entrer Autre">
                          </td>
                          <td>
                              <select id="defaultSelect" name="Pdecise" class="form-select">
                                  <option></option>
                                  <?php require('../poisson/liste.php') ?>
                              </select>
                               <input type='text' class='d-none' value="<?= $date ?>" name='date'>
                          </td>
                         <td>
                             <?= $decic?>
                         </td>
                          <td>
                              <input class="form-control d-none" type="submit">
                              <button type="button" class="col-4 col-sm-2 d-none  btn btn-icon btn-primary" data-bs-toggle="modal" data-bs-target="#basicModal">
                                  <i class="">+</i>
                              </button>
                          </td>
                        </form>
                      </tr>
                    <?php } ?>
                    <tr>
                        <td>Total</td>
                         <td><?= $total?></td>
                          <td><?= $TotalFillet?></td>
                           <td><?= $TotalSqlt?></td>
                            <td><?= $TotalSae?></td>
                             <td><?= $TotalAutre?></td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>

            <!-- Modal pour ajouter un poisson -->
            <div class="modal fade" id="basicModal" tabindex="-1" aria-hidden="true">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title">Ajout Poisson</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <form action="../poisson/add_new.php" method="POST">
                    <div class="modal-body">
                      <div class="row">
                        <div class="col mb-3">
                          <label for="nameBasic" class="form-label">Nom</label>
                          <input type="text" id="nameBasic" class="form-control" placeholder="Nom de Poisson" name="nom" />
                        </div>
                      </div>
                    </div>
                    <div class="modal-footer">
                      <button type="submit" class="btn btn-primary">Enregistrer</button>
                    </div>
                  </form>
                </div>
              </div>
            </div>

            <!-- Styles et Scripts supplémentaires -->
            <style>
                .custom-modal-dialog {
                    min-width: 800px;
                }
            </style>

          </div>
          <div class="content-backdrop fade"></div>
        </div>
      </div>
    </div>
    <div class="layout-overlay layout-menu-toggle"></div>
  </div>

  <!-- Core JS and other scripts -->
  <script src="../assets/vendor/libs/jquery/jquery.js"></script>
  <script src="../assets/vendor/libs/popper/popper.js"></script>
  <script src="../assets/vendor/js/bootstrap.js"></script>
  <script src="../assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>
  <script src="../assets/vendor/js/menu.js"></script>
  <script src="../assets/vendor/libs/apex-charts/apexcharts.js"></script>
  <script src="../assets/js/main.js"></script>
  <script src="../assets/js/dashboards-analytics.js"></script>
</body>
</html>
