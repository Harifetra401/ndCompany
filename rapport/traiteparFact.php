<?php
  require('../session.php');
  ?>
<?php

        require('../db.php');

       
        function get_name($id_to_get) {
            require('../db.php');
        $new_sql = "SELECT * FROM poisson WHERE id = $id_to_get";
        $new_st = $db->prepare($new_sql);
        $new_st->execute();
        $fetch_name = $new_st -> fetch();
        return $fetch_name["nomFilao"];
        }

        function return_type($num_to_get) {
            require('../db.php');
            $numeroFacture = $_GET["num"];
            $selection = $db -> prepare("SELECT * FROM detailfilaocontre WHERE NumFac=$numeroFacture AND id_poisson=$num_to_get");
            $selection -> execute();
            $fetchAll = $selection -> fetchAll();
            $nbr = count($fetchAll);
            if($nbr) {
              $qtt_f = $fetchAll[0]['qtt'];
        return $qtt_f;
            }
        return false;
        }
        // sortie
        function return_type_sortie($num_to_get){
            require('../db.php');
          $numeroFacture = $_GET["num"];
          $selection = $db -> prepare("SELECT * FROM detailavant WHERE NumFac=$numeroFacture AND id_poisson=$num_to_get");
          $selection -> execute();
          $fetchAll = $selection -> fetchAll();
          $nbr = count($fetchAll);
          if($nbr) {
            $st_f = $fetchAll[0]['sortie'];
          return $st_f;
    
              }
          return false;
        }

        // avant entrer dans la chambre froid
        function return_type_avant($num_to_get) {
          require('../db.php');
          $numeroFacture = $_GET["num"];
          $selection = $db -> prepare("SELECT * FROM detailavant WHERE NumFac=$numeroFacture AND id_poisson=$num_to_get");
          $selection -> execute();
          $fetchAll = $selection -> fetchAll();
          $nbr = count($fetchAll);
          if($nbr) {
            $qtt_f = $fetchAll[0]['qtt'];
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
  <script>
    function exporterTableauEnCSV(filename) {
        var csv = [];
        var rows = document.querySelectorAll("table tr");
        
        // Vérifiez qu'il y a des lignes à exporter
        if (rows.length === 0) {
            alert("Aucune donnée à exporter.");
            return;
        }
        
        for (var i = 0; i < rows.length; i++) {
            var row = [], cols = rows[i].querySelectorAll("td, th");
    
            for (var j = 0; j < cols.length; j++) {
                row.push('"' + cols[j].innerText.replace(/"/g, '""') + '"');
            }
    
            csv.push(row.join(";"));
        }
    
        // Créez un objet Blob pour le CSV
        var csvFile = new Blob([csv.join("\n")], { type: "text/csv" });
        
        // Créez un lien de téléchargement
        var downloadLink = document.createElement("a");
        downloadLink.download = filename;
        downloadLink.href = window.URL.createObjectURL(csvFile);
        
        // Cachez le lien et cliquez dessus pour déclencher le téléchargement
        downloadLink.style.display = "none";
        document.body.appendChild(downloadLink);
        downloadLink.click();
        document.body.removeChild(downloadLink);
    }
</script>
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
        <?php $title='Traitement'?>
        <?php require('../nav/header.php')?>
        <!-- / Navbar -->

        <!-- Content wrapper -->
        <div class="content-wrapper">
          <!-- Content -->
<button onclick="exporterTableauEnCSV('<?=$_GET["frnss"]?>__<?=$_GET["date"]?>.csv')">Exporter en Exel</button>
<div class="container-fluid flex-grow-1 container-p-y">
    <div class="card">
        <h5 class="card-header">Traitement Facture n° <?=$numeroFacture?> au nom de</h5>
         
        <div class="table-responsive text-nowrap">
            <table class="table  table-bordered table-striped table-hover">
                <thead>
                    <tr>
                        <th><?=$_GET["frnss"]?></th>
                        <th><?=$_GET["date"]?></th>
                    </tr>
                    <tr>
                        <th>Nom</th>
                        <th>Initial</th>
                        <th>Contre Pesage (kg)</th>
                        <th>Décication 01</th>
                        <th>Sortie en kg</th>
                        <th>Après Traitement en kg</th>
                        <th>Décication 02</th>
                        <th>Observation</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Sélection des factures d'aujourd'hui -->
                    <?php 
                    foreach ($all_produit as $get_fact) { ?>
                        <tr>
                            <form action="../contrepese/add_new.php" method="post">
                                <input type="hidden" name="num" value="<?=$numeroFacture?>">
                                <input type="hidden" name="id_poisson" value="<?=$get_fact['id_poisson']?>">
                                <td><?=get_name($get_fact['id_poisson'])?></td>
                                <td id="poid_init"><?=$get_fact['qtt']?> KG</td>
                                <!-- Vérification du type de poisson -->
                                <?php if(return_type($get_fact['id_poisson']) === false): $count +=1; ?>
                                    <td colspan="3">
                                        <?=$get_fact['qtt']?> KG
                                       
                                    </td>
                                    <td><span id="valeur_apres"></span></td>
                                <?php else: ?>
                                    <td>
                                       <?=return_type($get_fact['id_poisson'])?></td>
                                    <!-- Calcul de la décication 01 -->
                                    <?php
                                    $rest = $get_fact['qtt'] - return_type($get_fact['id_poisson']);
                                    $pourcentage = ((return_type($get_fact['id_poisson']) * 100) / $get_fact['qtt']);
                                    $decicationPourcentage = round(100 - $pourcentage, 2);
                                    ?>
                                    <td> <?= $decicationPourcentage ?> %</td>
                                <?php endif; ?>
                            </form>
                            
                            <?php if(return_type($get_fact['id_poisson'])): ?>
                                <form action="../contrepese/avant_chambre.php" method="post">
                                    <!-- Vérification si le traitement avant chambre est fait -->
                                    <?php if(return_type_avant($get_fact['id_poisson']) === false): $count +=1; $atraite = return_type($get_fact['id_poisson']); ?>
                                        <td>
                                          
                                        </td>
                                        <td>

                                            
                                            <?= $atraite - return_type_sortie($get_fact['id_poisson'])?>
                                           
                                        </td>
                                    <?php else: ?>
                                        <td>
                                            
                                            <?=return_type_sortie($get_fact['id_poisson'])?>
                                        </td>
                                        <td>
                                            <?=return_type_avant($get_fact['id_poisson'])?>
                                           
                                        </td>
                                    <?php endif; ?>
                                    
                                    <!-- Calcul de la décication 02 -->
                                    <?php
                                    if(return_type_avant($get_fact['id_poisson'])) {
                                        $rest = return_type($get_fact['id_poisson']) - return_type_sortie($get_fact['id_poisson']);
                                        $pourcentage = ((return_type_avant($get_fact['id_poisson']) * 100) / $rest);
                                        $decicationPourcentage = round(100 - $pourcentage, 2);
                                        echo "<td> $decicationPourcentage %</td>";
                                    } else {
                                        $rest = return_type($get_fact['id_poisson']) - return_type_sortie($get_fact['id_poisson']);
                                        $pourcentage = ((return_type_avant($get_fact['id_poisson']) * 100));
                                        $decicationPourcentage = round(100 - $pourcentage, 2);
                                        echo "<td> $decicationPourcentage %</td>";
                                    }
                                    ?>
                                </form>
                            <?php endif; ?>
                            <td><?php require('../contrepese/obs.php'); ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
    <!-- Commentaire pour cette facture -->
    <div class="container-fluid flex-grow-1 container-p-y">
        <div class="card">
            <h5 class="card-header">Commentaire pour cette facture</h5>
            <div class="card-body">
                <form id="formAuthentication" class="mb-3" action="add_coms.php" method="POST">
                    <input type="hidden" name="num_fact" value="<?=$_GET["num"]?>">
                    <?php require('coms.php')?>
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
    
    function maka_p(valeur,e,x) {
        if(valeur>=e.target.value) {
        let rest = valeur - e.target.value;
        let pourcentage = (( e.target.value * 100 ) / valeur);
        let decicationPourcentage = 100 - pourcentage;
        valeur_apres[x-1].innerText = `${decicationPourcentage.toFixed(2)} %`;
       
    }

    function maka_py(valeur,e,x) {
        if(valeur>=e.target.value) {
        let rest = valeur - e.target.value;
        let pourcentage = (( e.target.value * 100 ) / valeur);
        let decicationPourcentage = 100 - pourcentage;
        valeur_apres[x-1].innerText = `${decicationPourcentage.toFixed(2)} %`;
        
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