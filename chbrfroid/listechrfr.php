<?php
require('../db.php');

// Fetching date filter inputs
$startDate = isset($_GET['start_date']) ? $_GET['start_date'] : null;
$endDate = isset($_GET['end_date']) ? $_GET['end_date'] : null;

// Base SQL query
$sql = "SELECT * FROM chbr WHERE qtt > 0";

// Adding date filter conditions if set
if ($startDate && $endDate) {
    $sql .= " AND created_at BETWEEN :start_date AND :end_date";
}

$selection = $db->prepare($sql);

// Binding parameters for date filter if set
if ($startDate && $endDate) {
    $selection->bindParam(':start_date', $startDate);
    $selection->bindParam(':end_date', $endDate);
}

$selection->execute();
$fetchAll = $selection->fetchAll();

$total_poid = 0;
$poids_par_date = [];

// Process the fetched records
foreach ($fetchAll as $fetch) {
    $date = date('y/m/d', strtotime($fetch['created_at']));
    $qtt_poisson = $fetch['qtt'];

    // Sum the weights by date
    if (!isset($poids_par_date[$date])) {
        $poids_par_date[$date] = 0;
    }

    $poids_par_date[$date] += $qtt_poisson;
    $total_poid += $qtt_poisson;
}
?>

<!DOCTYPE html>
<html lang="en" class="light-style layout-menu-fixed" dir="ltr" data-theme="theme-default" data-assets-path="../assets/" data-template="vertical-menu-template-free">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum=1.0" />
    <title>Logiciel de Gestion</title>
    <meta name="description" content="" />
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="../assets/img/favicon/favicon.ico" />
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700&display=swap" rel="stylesheet" />
    <!-- Icons -->
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
    <!-- Config -->
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
                <?php $title='Traitement'?>
                <?php require('../nav/header.php')?>
                <!-- / Navbar -->

                <!-- Content wrapper -->
                <div class="content-wrapper">
                    <!-- Content -->
                    <div class="container-fluid flex-grow-1 container-p-y">
                        <!-- Date Filter Form -->
                        <div class="card mb-4">
                            <div class="card-header">Filtrer par Date</div>
                            <div class="card-body">
                                <form method="GET" action="">
                                    <div class="row">
                                        <div class="col-md-5">
                                            <input type="date" class="form-control" id="start_date" name="start_date" value="<?= htmlspecialchars($startDate) ?>">
                                        </div>
                                        <div class="col-md-5">
                                            <input type="date" class="form-control" id="end_date" name="end_date" value="<?= htmlspecialchars($endDate) ?>">
                                        </div>
                                        <div class="col-md-2">
                                            <button type="submit" class="btn btn-primary btn-block">Filtrer</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <div class="card">
                            <h5 class="card-header">Mise en Sac</h5>
                            <div class="table-responsive text-nowrap">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Poids en kg</th>
                                            <th>Date Entrer</th>
                                            <th>Action</th>
                                            <!--<th>Poids entrer stock</th>-->
                                            <!--<th>NB Colis</th>-->
                                            <!--<th>Type de Colis</th>-->
                                            <!--<th><a href="listemelange.php" class="btn btn-success">Melange</a></th>-->
                                            <!--<th><a href="raportdeci.php" class="btn btn-success">Rappot Deci</a></th>-->
                                        </tr>
                                    </thead>
                                    <tbody>
                                         <?php
                        foreach ($poids_par_date as $date => $total_qtt) {
                            ?>
                            <tr>
                                <td><?= htmlspecialchars($total_qtt) ?></td>
                                <td><?= htmlspecialchars($date) ?></td>
                                
                                <td><a href='pardate.php?date=<?= $date ?>'  class=' btn btn-primary'>Gérer</h5></td>
                            </tr>
                            <?php
                        }
                        ?>
                        <tr>
                            <td align="right"><strong>Total général :</strong></td>
                            <td><strong><?= htmlspecialchars($total_poid) ?></strong></td>
                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <!-- Additional Content -->
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- / Layout wrapper -->

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="../assets/vendor/libs/jquery/jquery.js"></script>
    <script src="../assets/vendor/libs/popper/popper.js"></script>
    <script src="../assets/vendor/js/bootstrap.js"></script>
    <script src="../assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>
    <script src="../assets/vendor/js/menu.js"></script>
    <script src="../assets/vendor/libs/apex-charts/apexcharts.js"></script>
    <script src="../assets/js/main.js"></script>
    <script src="../assets/js/dashboards-analytics.js"></script>
    <script async defer src="https://buttons.github.io/buttons.js"></script>
</body>
</html>
