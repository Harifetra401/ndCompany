<?php
require ('../session.php');
?>
<?php

require ('../db.php');

function get_name($id_to_get)
{
  require ('../db.php');
  $new_sql = "SELECT * FROM poisson WHERE id = $id_to_get";
  $new_st = $db->prepare($new_sql);
  $new_st->execute();
  $fetch_name = $new_st->fetch();
  return $fetch_name["nomFilao"];
}

// function get_cat($id_to_get)
// {
//   require ('../db.php');
//   $new_sql = "SELECT * FROM poisson WHERE id = $id_to_get";
//   $new_st = $db->prepare($new_sql);
//   $new_st->execute();
//   $fetch_name = $new_st->fetch();
//   return $fetch_name["nomFilao"];
// }

function return_type($num_to_get)
{
  require ('../db.php');
  $numeroFacture = $_GET["num"];
  $selection = $db->prepare("SELECT * FROM detailfilaocontre WHERE NumFac=$numeroFacture AND id_poisson=$num_to_get");
  $selection->execute();
  $fetchAll = $selection->fetchAll();
  $nbr = count($fetchAll);
  if ($nbr) {
    $qtt_f = $fetchAll[0]['qtt'];
    return $qtt_f;
  }
  return false;
}
// sortie
function return_type_sortie($num_to_get)
{
  require ('../db.php');
  $id_sortie = $_GET["num"];
  $num = $_GET['num'];
  $selection_sortie = $db->prepare("SELECT * FROM sortie WHERE id_sortie=$id_sortie");
  $selection_sortie->execute();
  $fetch_sortie = $selection_sortie->fetch();
  return $fetch_sortie["sortieqtt"];
}

// avant entrer dans la chambre froid
function return_type_avant($num_to_get)
{
  require ('../db.php');
  $numeroFacture = $_GET["num"];
  $selection = $db->prepare("SELECT SUM(qtt) AS Tqtt FROM detailavant WHERE NumFac=$numeroFacture AND id_poisson=$num_to_get");
  $selection->execute();
  $fetchAll = $selection->fetchAll();
  $nbr = count($fetchAll);
  if ($nbr) {
    $qtt_f = $fetchAll[0]['Tqtt'];
    return $qtt_f;
  }
  return false;
}

$numeroFacture = $_GET["num"];
$select_sql = "SELECT * FROM detailfilao WHERE NumFac=$numeroFacture";
$stmt_contre = $db->prepare($select_sql);
$stmt_contre->execute();

$all_produit = $stmt_contre->fetchAll(PDO::FETCH_ASSOC);
$count = 0;
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
      <?php require ('../nav/menu.php') ?>
      <!-- / Menu -->

      <!-- Layout container -->
      <div class="layout-page">

        <!-- Navbar -->
        <?php $title = 'Traitement' ?>
        <?php require ('../nav/header.php') ?>
        <!-- / Navbar -->

        <!-- Content wrapper -->
        <div class="content-wrapper">
          <!-- Content -->

          <div class="container-fluid flex-grow-1 container-p-y">
            <div class="card">
              <h5 class="card-header"> Traitement Facture n° <?= $numeroFacture ?></h5>
              <div class="table-responsive text-nowrap">
                <table class="table">
                  <thead>
                    <td>Nom</td>
                    <td>Initial</td>
                    <td>Contre Pesage</td>
                    <td>Décication 01</td>
                    <td>Sortie</td>
                    <td> Traitement</td>
                    <td>Entrer</td>
                    <td>Décication 02</td>

                  </thead>
                  <tbody>
                    <!-- selection des facture aujourd'hui -->
                    <?php
                    foreach ($all_produit as $get_fact) {

                      ?>
                      <tr>
                        <form action="../contrepese/add_new.php" method="post">
                          <input type="hidden" name="num" value="<?= $numeroFacture ?>">
                          <input type="hidden" name="id_poisson" value="<?= $get_fact['id_poisson'] ?>">
                          <td><?= get_name($get_fact['id_poisson']) ?></td>
                          <td id="poid_init"><?= $get_fact['qtt'] ?> KG</td>
                          <?php if (!return_type($get_fact['id_poisson'])) {
                            $count += 1; ?>
                            <td colspan="3"><input type="text" name="qtt" value="<?= $get_fact['qtt'] ?>" id="input_qtt"
                                onkeyup="maka_p(<?= $get_fact['qtt'] ?>,event,<?= $count ?>)"> KG
                              <button class="btn btn-primary" type="submit">ok</button>
                            </td>
                            <td><span id="valeur_apres"></span></td>
                          <?php } else { ?>
                            <td><?= return_type($get_fact['id_poisson']) ?> KG
                            </td>
                            <?php
                            if (return_type($get_fact['id_poisson'])) {
                              $rest = $get_fact['qtt'] - return_type($get_fact['id_poisson']);
                              $pourcentage = ((return_type($get_fact['id_poisson']) * 100) / $get_fact['qtt']);
                              $decicationPourcentage = 100 - $pourcentage;
                              $decicationPourcentage = round($decicationPourcentage, 2);
                              echo "<td> $decicationPourcentage %</td>";
                            } else {
                              echo "<td>la valeur ne doit pas etre null</td>";
                            }
                          }
                          ?>
                        </form>

                        <?php
                        require ('sortieshow.php');
                        if (return_type($get_fact['id_poisson'])) {
                          ?>
                          <td>
                            <!-- apres traitement -->
                            <form action="../contrepese/avant_chambre.php" method="post">
                              <input type="hidden" name="num" value="<?= $numeroFacture ?>">
                              <input type="hidden" name="id_poisson" value="<?= $get_fact['id_poisson'] ?>">
                              <input type="hidden" name="pdetail" value="0" id="">
                              <select name="classpss" id="">
                                <option value="8"></option>
                                <option value="1">Avec.E SV</option>
                                <option value="2">Avec.E AV</option>
                                <option value="3">Sans.E SV</option>
                                <option value="4">Sans.E AV</option>

                                <option value="5">Filet TT</option>
                                <option value="6">Filet SQLT</option>
                                <option value="7">Filet Chaire</option>
                                <option value="10">Filet AP</option>
                                <option value="8">Sans.E SB</option>
                                <option value="9">Sans.E AB</option>

                              </select>

                              <?php

                              if (!return_type_avant($get_fact['id_poisson'])) {
                                $count += 1;
                                $atraite = return_type($get_fact['id_poisson']) ?>



                            </td>

                            <td>
                              <input type="text" class="form"autocomplete="off" name="qtt" value="<?= $atraite - $sortie ?>" id="input_qtt_y">
                              KG
                              <button class="btn btn-primary" type="submit">ok</button>
                            </td>
                            <td>
                              <span id="valeur_apres"></span>
                            <?php } else { ?>

                              <!-- // return_type_avant($get_fact['id_poisson'])  -->


                              <?php
                              $count += 1;
                              $atraite = return_type($get_fact['id_poisson']) ?>


                              <input type="number" class="form" name="qtt" value="<?= $atraite - $sortie ?>" id="input_qtt_y">
                              KG
                              <button class="btn btn-primary" type="submit">ok</button>

                              <?php
                              if (return_type_avant($get_fact['id_poisson'])) {
                                $rest = return_type($get_fact['id_poisson']) - $sortie;
                                $pourcentage = ((return_type_avant($get_fact['id_poisson']) * 100) / $rest);
                                $decicationPourcentage = 100 - $pourcentage;
                                $decicationPourcentage = round($decicationPourcentage, 2);
                                echo "<td> $decicationPourcentage  %</td>";
                              } else {
                                echo "<td>la valeur ne doit pas etre null</td>";
                              }
                              }
                        }
                        ?>
                          </form>
                        </td>


                      </tr>
                    <?php } ?>


                  </tbody>
                </table>
              </div>
            </div>
            <!--/ Layout Demo -->
            <div class="container-fluid flex-grow-1 container-p-y">
              <div class="card">
                <h5 class="card-header">Commentaire pour cette facture</h5>
                <div class="card-body">
                  <form id="formAuthentication" class="mb-3" action="add_coms.php" method="POST">
                    <input type="hidden" name="num_fact" value="<?= $_GET["num"] ?>">
                    <?php require ('coms.php') ?>

                    <button class="btn btn-primary m-1" type="submit">Ajouter</button>
                  </form>
                </div>
              </div>
            </div>
          </div>
          <!-- / Content -->

          <!-- Footer -->


          <div class="content-backdrop fade"></div>
        </div>

        <script>
          let poid_init = document.querySelector('#poid_init');
          let input_qtt = document.querySelector('#input_qtt');
          let input_qtt_y = document.querySelector('#input_qtt_y');
          var valeur_apres = document.querySelectorAll('#valeur_apres');
          let poisson = document.querySelector('#poisson');

          function maka_p(valeur, e, x) {
            if (valeur >= e.target.value) {
              let rest = valeur - e.target.value;
              let pourcentage = ((e.target.value * 100) / valeur);
              let decicationPourcentage = 100 - pourcentage;
              valeur_apres[x - 1].innerText = `${decicationPourcentage.toFixed(2)} %`;
            } else {
              valeur_apres[x - 1].innerText = `${decicationPourcentage.toFixed(2)} %`;
              // valeur_apres[x-1].innerText = "la valeur doit etre inferieur au initiale";
              // alert("la valeur doit etre inferieur ou egale au initiale");
              // input_qtt.value = "";
            }
          }

          function maka_py(valeur, e, x) {
            if (valeur >= e.target.value) {
              let rest = valeur - e.target.value;
              let pourcentage = ((e.target.value * 100) / valeur);
              let decicationPourcentage = 100 - pourcentage;
              valeur_apres[x - 1].innerText = `${decicationPourcentage.toFixed(2)} %`;
            } else {
              valeur_apres[x - 1].innerText = `${decicationPourcentage.toFixed(2)} %`;
              // valeur_apres[x-1].innerText = "la valeur doit etre inferieur au initiale";
              // alert("la valeur doit etre inferieur ou egale au initiale");
              // input_qtt_y.value = "";
            }
          }
        </script>
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