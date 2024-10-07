<?php
require('../db.php');

// // Function to get the name of the fish based on its ID
// function getNomPoisson($db, $id_selector)
// {
//     $getBy = $db->prepare("SELECT nomFilao FROM poisson WHERE id = :id");
//     $getBy->bindParam(':id', $id_selector, PDO::PARAM_INT);
//     $getBy->execute();
//     $fetchBy = $getBy->fetch();
//     return $fetchBy["nomFilao"];
// }

// // Fetch all records from chbr where qtt > 0
// $selection = $db->prepare("SELECT * FROM chbr WHERE qtt > 0");
// $selection->execute();
// $fetchAll = $selection->fetchAll();

// $total_poid = 0;
// $poissons = [];

// // Process the fetched records
// foreach ($fetchAll as $fetch) {
//     $id_poisson = getNomPoisson($db, $fetch['poissonType']);
//     $qtt_poisson = $fetch['qtt'];
//     $datentrer = $fetch['created_at'];

//     if (!isset($poissons[$id_poisson])) {
//         $poissons[$id_poisson] = 0;
//     }

//     $poissons[$id_poisson] += $qtt_poisson;
//     $total_poid += $qtt_poisson;
// }
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
    <link href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap" rel="stylesheet" />
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
                    
                    <div class="col-md-8 col-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="table-responsive text-nowrap">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>Nom</th>
                                                <th>Poid</th>
                                                <th>Nombre de sacs (cartons)</th>
                                            </tr>
                                        </thead>
                                        <tbody class="table-border-bottom-0">
                                            <?php require ('../stock/liste.php'); ?>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="mt-3">
                                    <p>Poid total: <?= $total_poid_all ?? 0 ?> kg</p>
                                    <p>Nombre de sac: <?= $total_sac_all ?? 0 ?></p>
                                    <p>Nombre de carton: <?= $total_carton_all ?? 0 ?></p>
                                </div>
                                <?php require('mixt.php')?>
                            </div>
                        </div>
                    </div>
                    <!-- / Content -->
                    <div class="content-backdrop fade"></div>
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
</html
