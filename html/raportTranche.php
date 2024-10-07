<?php
// Inclure la connexion à la base de données
require('../db.php');

// Requête SQL pour grouper les enregistrements par date et calculer les sommes
$sql = "SELECT date, SUM(enterTranche) AS totalEnterTranche, 
               SUM(Tranchecolis) AS totalTranchecolis, 
               SUM(emballage) AS totalEmballage, 
               SUM(TeteTranche) AS totalTeteTranche
        FROM tranche
        GROUP BY date
        ORDER BY date";
$stmt = $db->prepare($sql);
$stmt->execute();
$tranches = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>


<!DOCTYPE html>
<html lang="en">

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
     <div class="layout-wrapper layout-content-navbar">
    <div class="layout-container">
      <!-- Menu -->
      <?php require ('../nav/menu.php'); ?>
      <!-- / Menu -->

      <!-- Layout container -->
      <div class="layout-page">

        <!-- Navbar -->

        <?php require ('../nav/header.php'); ?>
        
        <br><br>
        <div class="content-wrapper">
            <div class="container">
                <div class='card'><br>
                    <center><h2>Liste des Tranches par Date</h2></center>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Total Enter Tranche</th>
                            <th>Total Tranche Colis</th>
                            <th>Total Emballage</th>
                            <th>Total Tête Tranche</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($tranches as $tranche): ?>
                        <tr>
                            <td><?= htmlspecialchars($tranche['date']) ?></td>
                            <td><?= htmlspecialchars($tranche['totalEnterTranche']) ?></td>
                            <td><?= htmlspecialchars($tranche['totalTranchecolis']) ?></td>
                            <td><?= htmlspecialchars($tranche['totalEmballage']) ?></td>
                            <td><?= htmlspecialchars($tranche['totalTeteTranche']) ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                </div>
            </div>
        </div>
    </div>
    </div>
    </div>
    
      <!-- Core JS -->
  <!-- build:js assets/vendor/js/core.js -->
  <script src="../assets/vendor/libs/jquery/jquery.js"></script>
  <script src="../assets/vendor/libs/popper/popper.js"></script>
  <script src="../assets/vendor/js/bootstrap.js"></script>
  <script src="../assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>
  <script src="../assets/vendor/js/menu.js"></script>
  <script src="../assets/js/main.js"></script>
  <script async defer src="https://buttons.github.io/buttons.js"></script>
</body>

</html>

