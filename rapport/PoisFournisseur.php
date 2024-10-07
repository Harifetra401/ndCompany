<?php
require('../db.php');
require('../facture/prix_one_facture.php');

// Function to get the supplier's name based on id_fou
function get_name($id_fou)
{
    require('../db.php');
    $new_sql = "SELECT nomfournisseur FROM fournisseur WHERE id = :id_fou";
    $new_st = $db->prepare($new_sql);
    $new_st->bindParam(':id_fou', $id_fou, PDO::PARAM_INT);
    $new_st->execute();
    $fetch_name = $new_st->fetch();
    return $fetch_name ? $fetch_name["nomfournisseur"] : '';
}

function poid_total($num_fact) {
    require('../db.php');
    $total = 0;
    $selection = $db->prepare("SELECT qtt FROM detailfilao WHERE NumFac=:num_fact");
    $selection->bindParam(':num_fact', $num_fact, PDO::PARAM_INT);
    $selection->execute();
    $fetchAll = $selection->fetchAll();

    foreach($fetchAll as $fetch){
        $qtt_poisson = $fetch['qtt'];
        $total += ($qtt_poisson);
    }
    return $total;
}

// Get the months from the form submission and sanitize them
$start_month = isset($_GET['start_month']) ? htmlspecialchars($_GET['start_month']) : date('Y-m');
$end_month = isset($_GET['end_month']) ? htmlspecialchars($_GET['end_month']) : date('Y-m');

// Adjust the query based on the selected months
$sql = "SELECT * FROM facture WHERE DATE_FORMAT(date, '%Y-%m') BETWEEN :start_month AND :end_month ORDER BY id DESC";
$stmt = $db->prepare($sql);
$stmt->bindParam(':start_month', $start_month, PDO::PARAM_STR);
$stmt->bindParam(':end_month', $end_month, PDO::PARAM_STR);
$stmt->execute();
$all_facture = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Group the data by supplier
$grouped_data = [];

foreach ($all_facture as $facture) {
    $fournisseur_name = get_name($facture['id_fou']);
    $poids = poid_total($facture['id']);

    if (!isset($grouped_data[$fournisseur_name])) {
        $grouped_data[$fournisseur_name] = 0;
    }

    $grouped_data[$fournisseur_name] += $poids;
}
?>
<!DOCTYPE html>
<html lang="en" class="light-style layout-menu-fixed" dir="ltr" data-theme="theme-default" data-assets-path="../assets/" data-template="vertical-menu-template-free">
<head>
  <meta charset="utf-8" />
  <meta name="viewport"
    content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

  <title>Collect</title>

  <meta name="description" content="" />

  <!-- Favicon -->
  <link rel="icon" type="image/x-icon" href="../assets/img/favicon/favicon.ico" />
  <!-- Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link
    href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700&display=swap"
    rel="stylesheet" />

  <!-- Icons. Uncomment required icon fonts -->
  <link rel="stylesheet" href="../assets/vendor/fonts/boxicons.css" />

  <!-- Core CSS -->
  <link rel="stylesheet" href="../assets/vendor/css/core.css" class="template-customizer-core-css" />
  <link rel="stylesheet" href="../assets/vendor/css/theme-default.css" class="template-customizer-theme-css" />
  <link rel="stylesheet" href="../assets/css/demo.css" />

  <!-- Vendors CSS -->
  <link rel="stylesheet" href="../assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />

  <!-- <link rel="stylesheet" href="../assets/vendor/libs/apex-charts/apex-charts.css" /> -->

  <!-- Page CSS -->
  <script src="../dashboardata/chart.js"></script>
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
      <?php require ('../nav/menu.php'); ?>
      <!-- / Menu -->

      <!-- Layout container -->
      <div class="layout-page">

        <!-- Navbar -->

        <?php
        require ('../nav/header.php')
          ?> 
        <div class="content-wrapper">
         
          <div class="container-xxl flex-grow-1 container-p-y">
              
<!-- Ajouter le style CSS pour le tableau -->
            <!-- Ajouter le style CSS pour le tableau -->
<style>
    .table-hover tbody tr:hover {
        background-color: #f9f9f9;
    }

    .table th, .table td {
        vertical-align: middle;
        text-align: center;
    }

    .table thead th {
        background-color: #343a40;
        color: #fff;
        border-bottom: 2px solid #dee2e6;
    }

    .text-danger {
        color: #dc3545 !important;
    }

    .custom-select {
        width: 200px;
        display: inline-block;
    }

    .btn-filter {
        background-color: #007bff;
        color: white;
        border: none;
        padding: 5px 10px;
        cursor: pointer;
        border-radius: 4px;
    }

    .btn-filter:hover {
        background-color: #0056b3;
    }

    .total-row {
        font-weight: bold;
        background-color: #e9ecef;
    }
</style>
<div class="container mt-5">
    <div class="card">
        <br><br>
    <center>
        <h2 class="mb-4 mr-100">Achat Par Fournisseur</h2>
    </center>
<br>
    <table>
        <tr>
            <td>
                
            </td>
            <td>
                    <form method="GET" action="">
                        <div class="form-group w-50">
                            <h4 for="start_month">Sélectionner le mois de début :</h4>
                            <input type="month" id="start_month" name="start_month" class="form-control" value="<?= isset($_GET['start_month']) ? htmlspecialchars($_GET['start_month']) : date('Y-m') ?>">
                        </div>
            </td>
            <td>
                
            </td>
            <td>
                        <div class="form-group w-50">
                            <h4 for="end_month">Sélectionner le mois de fin :</h4>
                            <input type="month" id="end_month" name="end_month" class="form-control" value="<?= isset($_GET['end_month']) ? htmlspecialchars($_GET['end_month']) : date('Y-m') ?>">
                        </div>
            </td>
            <td>
                
            </td>
        </tr>
        <tr>
            <td>
                
            </td>
            <td>
                <br>
                        <button type="submit" class="btn btn-primary w-50">Filtrer</button>
                    </form>
            </td>
            <td>
                
            </td>
            <td>
                <br>
                <button class="btn btn-success w-50" onclick="exporterTableauEnCSV('tableau.csv')">Exporter en CSV</button>
            </td>
            <td>
                
            </td>
        </tr>
    </table>
    <br>
    <!-- Filter Form -->



    
    <!-- Table -->
    <table class="table table-bordered">
        <thead class="thead-dark">
            <tr>
                <th scope="col">Nom Fournisseur</th>
                <th scope="col">Poids Total</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($grouped_data as $fournisseur => $poids_total): ?>
                <?php
                $poidsjiab += $poids_total;
                if ($poids_total > 0): ?>
                    <tr>
                        <td><?= htmlspecialchars($fournisseur) ?></td>
                        <td><?= htmlspecialchars(number_format($poids_total, 2, ',', ' ')) ?></td>
                    </tr>
                <?php endif; ?>
            <?php endforeach; ?>
            <tr>
                <td></td>
                <td></td>
            </tr>
        </tbody>
        <thead class="thead-dark">
            <tr>
                <th scope="col">TOTAL</th>
                <th scope="col"><?=$poidsjiab?></th>
            </tr>
        </thead>
    </table>
</div>
     
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
  <script src="../assets/js/main.js"></script>
  <script src="export.js"></script>
  <script async defer src="https://buttons.github.io/buttons.js"></script>
</body>
</html>
