<?php
require('../session.php');
require('../db.php');

// Fonction pour obtenir le nom du poisson
function get_name($id_to_get) {
    require('../db.php');
    $new_sql = "SELECT * FROM poisson WHERE id = :id";
    $new_st = $db->prepare($new_sql);
    $new_st->execute(['id' => $id_to_get]);
    $fetch_name = $new_st->fetch();
    return $fetch_name["nomFilao"];
}

// Fonction pour obtenir le type après le traitement
function return_type($num_to_get) {
    require('../db.php');
    $numeroFacture = $_GET["num"];
    $selection = $db->prepare("SELECT * FROM detailfilaocontre WHERE NumFac = :numFac AND id_poisson = :id_poisson");
    $selection->execute(['numFac' => $numeroFacture, 'id_poisson' => $num_to_get]);
    $fetchAll = $selection->fetchAll();
    if (count($fetchAll)) {
        return $fetchAll[0]['qtt'];
    }
    return false;
}

// Fonction pour obtenir le type avant le traitement
function return_type_avant($num_to_get) {
    require('../db.php');
    $numeroFacture = $_GET["num"];
    $selection = $db->prepare("SELECT * FROM detailavant WHERE NumFac = :numFac AND id_poisson = :id_poisson");
    $selection->execute(['numFac' => $numeroFacture, 'id_poisson' => $num_to_get]);
    $fetchAll = $selection->fetchAll();
    if (count($fetchAll)) {
        return $fetchAll[0]['qtt'];
    }
    return false;
}

// Fonction pour vérifier l'existence dans la table chbr
function check_existence($numeroFacture, $id_poisson) {
    require('../db.php');
    $sql = "SELECT * FROM chbr WHERE numeroFacture = :numeroFacture AND idPoisson = :id_poisson";
    $stmt = $db->prepare($sql);
    $stmt->execute(['numeroFacture' => $numeroFacture, 'id_poisson' => $id_poisson]);
    return $stmt->fetch() ? true : false;
}

$dateenter = $_GET['date'];
$numeroFacture = $_GET["num"];
$select_sql = "SELECT * FROM detailfilao WHERE NumFac = :numFac";
$stmt_contre = $db->prepare($select_sql);
$stmt_contre->execute(['numFac' => $numeroFacture]);
$all_produit = $stmt_contre->fetchAll(PDO::FETCH_ASSOC);
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
    <!-- Template customizer & Theme config files -->
    <script src="../assets/js/config.js"></script>
    <style>
        .tblpart {
            display: none;
        }
        .btnazy {
            display: none;
        }
        .table-danger {
            background-color: red;
        }
    </style>
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
                <?php $title=''?>
                <?php require('../nav/header.php')?>
                <!-- / Navbar -->

                <!-- Content wrapper -->
                <div class="content-wrapper">
                    <!-- Content -->
                    <div class="container-fluid flex-grow-1 container-p-y">
                        <div class="card">
                            <h5 class="card-header">Traitement Facture n: <?= $numeroFacture ?></h5>
                            <table id="tblpart" class="table tblpart">
                                <thead>
                                    <tr>
                                        <td>Nom</td>
                                        <td>Poids</td>
                                        <td>Date</td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <form action="Addcbr.php" method="post">
                                            <input type="hidden" name="num" value="<?= $numeroFacture ?>">
                                            <input type="hidden" name="id_poisson" value="">
                                            <input type="hidden" name="pp" value="">
                                            <td>
                                                <select name="poisson_type" class="form-control">
                                                    <?php require('../poisson/liste.php'); ?>
                                                </select>
                                            </td>
                                            <td>
                                                <input type="text" class="form-control" name="poids" value="">
                                            </td>
                                            <td>
                                                <input class="form-control" name="daty" type="text" value="<?= $dateenter ?>">
                                            </td>
                                            <td>
                                                <input class="form-control btn-primary" type="submit" name="submit" value="Ajouter">
                                            </td>
                                        </form>
                                    </tr>
                                </tbody>
                            </table>
                            <br><br>
                            <div class="table-responsive text-nowrap">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <td>Nom</td>
                                            <td>Contre Pe</td>
                                            <td>Apres Traitement</td>
                                            <td></td>
                                            <td><a href="listechrfr.php" class="btn btn-success">Liste Stock</a></td>
                                            <td>
                                                <p class="btn btn-danger" id="btko">+</p>
                                                <p class="btnazy btn btn-success" id="cache">+</p>
                                            </td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <!-- Sélection des produits -->
                                        <?php foreach ($all_produit as $get_fact) {
                                            $row_class = check_existence($numeroFacture, $get_fact['id_poisson']) ? 'table-primary' : '';
                                            ?>
                                            <tr class="<?= $row_class ?>">
                                                <form action="Addcbr.php" method="post">
                                                    <input type="hidden" name="num" value="<?= $numeroFacture ?>">
                                                    <input type="hidden" name="id_poisson" value="<?= $get_fact['id_poisson'] ?>">
                                                    <td><?= get_name($get_fact['id_poisson']) ?></td>
                                                    <td><?= return_type($get_fact['id_poisson']) ?> KG</td>
                                                    <?php if (return_type($get_fact['id_poisson'])) { ?>
                                                        <td>
                                                            <input type="hidden" name="num" value="<?= $numeroFacture ?>">
                                                            <input type="hidden" name="id_poisson" value="<?= $get_fact['id_poisson'] ?>">
                                                            <input type="text" name="poids" value="<?= return_type_avant($get_fact['id_poisson']) ?>">
                                                        </td>
                                                        <td>
                                                            <select name="poisson_type" class="form-control">
                                                                <option value="<?= $get_fact['id_poisson'] ?>">
                                                                    <?= get_name($get_fact['id_poisson']) ?>
                                                                </option>
                                                                <?php require('../poisson/liste.php'); ?>
                                                            </select>
                                                        </td>
                                                        <td>
                                                            <input class="form-control" name="daty" type="text" value="<?= $dateenter ?>">
                                                        </td>
                                                        <td>
                                                            <input class="form-control btn-primary" type="submit" name="submit" value="Ajouter">
                                                        </td>
                                                    <?php } else { ?>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                    <?php } ?>
                                                </form>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                           

                                    </table>
                                    <br>
                                    
                                    <br>
                                </div>
                            </div>
                            <!--/ Layout Demo -->
                            
                        </div>
                        <!-- / Content -->

                        <!-- Footer -->
                        <div class="content-backdrop fade"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>

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
    }

    function maka_py(valeur,e,x) {
        if(valeur>=e.target.value) {
        let rest = valeur - e.target.value;
        let pourcentage = (( e.target.value * 100 ) / valeur);
        let decicationPourcentage = 100 - pourcentage;
        valeur_apres[x-1].innerText = `${decicationPourcentage.toFixed(2)} %`;
        
        }
    }
    document.getElementById("btko").onclick = displaytbpart;
    function displaytbpart() {
    document.getElementById("tblpart").style.display = "inline";
    document.getElementById("btko").style.display = "none";
    document.getElementById("cache").style.display = "inline"
  
    }
    document.getElementById("cache").onclick = Cachetbpart;
    function Cachetbpart() {
    document.getElementById("tblpart").style.display = "none";
    document.getElementById("btko").style.display = "inline";
    document.getElementById("cache").style.display = "none"
  
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