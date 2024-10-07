<?php
require('../db.php');

function get_name($id_to_get) {
    global $db;
    $new_sql = "SELECT * FROM poisson WHERE id = :id_to_get";
    $new_st = $db->prepare($new_sql);
    $new_st->bindParam(':id_to_get', $id_to_get, PDO::PARAM_INT);
    $new_st->execute();
    $fetch_name = $new_st->fetch();
    return $fetch_name["nomFilao"];
}

function return_type($num_to_get, $numeroFacture) {
    global $db;
    $selection = $db->prepare("SELECT * FROM detailfilaocontre WHERE NumFac = :num AND id_poisson = :id_poisson");
    $selection->bindParam(':num', $numeroFacture, PDO::PARAM_INT);
    $selection->bindParam(':id_poisson', $num_to_get, PDO::PARAM_INT);
    $selection->execute();
    $fetchAll = $selection->fetchAll();
    return $fetchAll ? $fetchAll[0]['qtt'] : false;
}

function return_type_sortie($id_sortie) {
    global $db;
    $selection_sortie = $db->prepare("SELECT * FROM sortie WHERE id_sortie = :id_sortie");
    $selection_sortie->bindParam(':id_sortie', $id_sortie, PDO::PARAM_INT);
    $selection_sortie->execute();
    $fetch_sortie = $selection_sortie->fetch();
    return $fetch_sortie["sortieqtt"];
}

function return_type_avant($num_to_get, $numeroFacture) {
    global $db;
    $selection = $db->prepare("SELECT * FROM detailavant WHERE NumFac = :num AND id_poisson = :id_poisson");
    $selection->bindParam(':num', $numeroFacture, PDO::PARAM_INT);
    $selection->bindParam(':id_poisson', $num_to_get, PDO::PARAM_INT);
    $selection->execute();
    $fetchAll = $selection->fetchAll();
    return $fetchAll ? $fetchAll[0]['qtt'] : false;
}

$numeroFacture = $_GET["num"];
$select_sql = "SELECT * FROM detailfilao WHERE NumFac = :num";
$stmt_contre = $db->prepare($select_sql);
$stmt_contre->bindParam(':num', $numeroFacture, PDO::PARAM_INT);
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
  <link rel="icon" type="image/x-icon" href="../assets/img/favicon/favicon.ico" />
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="../assets/vendor/fonts/boxicons.css" />
  <link rel="stylesheet" href="../assets/vendor/css/core.css" class="template-customizer-core-css" />
  <link rel="stylesheet" href="../assets/vendor/css/theme-default.css" class="template-customizer-theme-css" />
  <link rel="stylesheet" href="../assets/css/demo.css" />
  <link rel="stylesheet" href="../assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />
  <link rel="stylesheet" href="../assets/vendor/libs/apex-charts/apex-charts.css" />
  <script src="../assets/vendor/js/helpers.js"></script>
  <script src="../assets/js/config.js"></script>
</head>
<body>
  <div class="layout-wrapper layout-content-navbar">
    <div class="layout-container">
      <?php require('../nav/menu.php')?>
      <div class="layout-page">
        <?php $title='Traitement'?>
        <?php require('../nav/header.php')?>
        <div class="content-wrapper">
          <div class="container-fluid flex-grow-1 container-p-y">
            <div class="card">
              <h5 class="card-header">Traitement Facture n° <?=$numeroFacture?></h5>
              <div class="table-responsive text-nowrap">
                <table class="table">
                  <thead>
                    <tr>
                      <td>Nom</td>
                      <td>Initial</td>
                      <td>Contre Pesage</td>
                      <td>Décication 01</td>
                      <td>Sortie</td>
                      <td>Apres Traitement</td>
                      <td>Décication 02</td>
                      <td>Observation</td>
                    </tr>
                  </thead>
                  <tbody>
                    <?php 
                      foreach ($all_produit as $get_fact) {
                        $id_poisson = $get_fact['id_poisson'];
                        $initial_qtt = $get_fact['qtt'];
                        $contre_pesage_qtt = return_type($id_poisson, $numeroFacture);
                    ?>
                    <tr>
                      <form action="../contrepese/add_new.php" method="post">
                        <input type="hidden" name="num" value="<?=$numeroFacture?>">
                        <input type="hidden" name="id_poisson" value="<?=$id_poisson?>">
                        <td><?=get_name($id_poisson)?></td>
                        <td id="poid_init"><?=$initial_qtt?> KG</td>
                        <?php if(!$contre_pesage_qtt) {$count += 1;?>
                          <td colspan="3">
                            <input type="text" name="qtt" value="<?=$initial_qtt?>" id="input_qtt" onkeyup="maka_p(<?=$initial_qtt?>,event,<?=$count?>)"> KG
                            <button class="btn btn-primary" type="submit">ok</button>
                          </td>
                          <td><span id="valeur_apres"></span></td>
                        <?php } else { ?>
                          <td><?=$contre_pesage_qtt?> KG</td>
                          <?php
                            $rest = $initial_qtt - $contre_pesage_qtt;
                            $pourcentage = (($contre_pesage_qtt * 100) / $initial_qtt);
                            $decicationPourcentage = round(100 - $pourcentage, 2);
                            echo "<td>$decicationPourcentage %</td>";
                          } ?>
                      </form>
                      <?php require('sortieshow.php')?>
                      <?php if($contre_pesage_qtt) { ?>
                        <td>
                          <form action="../contrepese/avant_chambre.php" method="post">
                            <input type="hidden" name="num" value="<?=$numeroFacture?>">
                            <input type="hidden" name="id_poisson" value="<?=$id_poisson?>">
                            <?php 
                              $avant_qtt = return_type_avant($id_poisson, $numeroFacture);
                              if(!$avant_qtt) {$count += 1; $atraite = $contre_pesage_qtt;?>
                                <input type="text" name="qtt" value="<?= $atraite - $sortie?>" id="input_qtt_y" onkeyup="maka_py(<?=$atraite?>,event,<?=$count?>)"> KG
                                <button class="btn btn-primary" type="submit">ok</button>
                              </td>
                              <td><span id="valeur_apres"></span>
                              <?php } else { ?>
                                <?=$avant_qtt?> KG
                                <?php
                                  $rest = $contre_pesage_qtt - $sortie;
                                  $pourcentage = round((($avant_qtt * 100) / $rest), 2);
                                  echo "<td>$pourcentage %</td>";
                              }
                            ?>
                          </form>
                        </td>
                        <?php require('obs.php')?>
                      </tr>
                    <?php } ?>
                  </tbody>
                </table>
              </div>
            </div>
            <div class="container-fluid flex-grow-1 container-p-y">
              <div class="card">
                <h5 class="card-header">Commentaire pour cette facture</h5>
                <div class="card-body">
                  <form id="formAuthentication" class="mb-3" action="add_coms.php" method="POST">
                    <input type="hidden" name="num_fact" value="<?=$numeroFacture?>">
                    <?php require('coms.php')?>
                    <button class="btn btn-primary m-1" type="submit">Ajouter</button>
                  </form>
                </div>
              </div>
            </div>
          </div>
          <div class="content-backdrop fade"></div>
        </div>
      </div>
    </div>
    <div class="layout-overlay layout-menu-toggle"></div>
  </div>
  <script src="../assets/vendor/libs/jquery/jquery.js"></script>
  <script src="../assets/vendor/libs/popper/popper.js"></script>
  <script src="../assets/vendor/js/bootstrap.js"></script>
  <script src="../assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>
  <script src="../assets/vendor/js/menu.js"></script>
  <script src="../assets/vendor/libs/apex-charts/apexcharts.js"></script>
  <script src="../assets/js/main.js"></script>
  <script src="../assets/js/dashboards-analytics.js"></script>
  <script async defer src="https://buttons.github.io/buttons.js"></script>
  <script>
    function maka_p(valeur, e, x) {
      let input_qtt = document.getElementById('input_qtt');
      if (valeur >= e.target.value) {
        let pourcentage = ((e.target.value * 100) / valeur);
        let decicationPourcentage = (100 - pourcentage).toFixed(2);
        document.querySelectorAll('#valeur_apres')[x - 1].innerText = `${decicationPourcentage} %`;
      } else {
        alert("La valeur doit être inférieure ou égale à l'initiale");
        input_qtt.value = "";
      }
    }
    function maka_py(valeur, e, x) {
      let input_qtt_y = document.getElementById('input_qtt_y');
      if (valeur >= e.target.value) {
        let pourcentage = ((e.target.value * 100) / valeur);
        let decicationPourcentage = (100 - pourcentage).toFixed(2);
        document.querySelectorAll('#valeur_apres')[x - 1].innerText = `${decicationPourcentage} %`;
      } else {
        alert("La valeur doit être inférieure ou égale à l'initiale");
        input_qtt_y.value = "";
      }
    }
  </script>
</body>
</html>
