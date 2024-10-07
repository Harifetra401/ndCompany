<?php
require('../db.php');

// Fetching all stocks with positive quantities
$selection = $db->prepare("SELECT `id_poisson`, `qtt` FROM `StockParticulier` WHERE `qtt` > 0");
$selection->execute();
$fetchAll = $selection->fetchAll(PDO::FETCH_ASSOC);

// Function to get fish name by ID
function getNomPoissonstp($db, $id_selector) {
    $getBy = $db->prepare("SELECT nomFilao FROM poisson WHERE id = :id");
    $getBy->bindParam(':id', $id_selector, PDO::PARAM_INT);
    $getBy->execute();
    $fetchBy = $getBy->fetch(PDO::FETCH_ASSOC);
    return $fetchBy["nomFilao"];
}

$total_poid = 0;
$poissons = [];

// Aggregating quantities by fish name
foreach ($fetchAll as $fetch) {
    $id_poisson = getNomPoissonstp($db, $fetch['id_poisson']);
    $qtt_poisson = $fetch['qtt'];

    if (!isset($poissons[$id_poisson])) {
        $poissons[$id_poisson] = 0;
    }

    $poissons[$id_poisson] += $qtt_poisson;
    $total_poid += $qtt_poisson;
}
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
    <link href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700&display=swap" rel="stylesheet" />
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
                <?php $title = 'Traitement'; require('../nav/header.php')?>
                <!-- / Navbar -->

                <!-- Content wrapper -->
                <div class="content-wrapper">
                    <!-- Content -->
                    <div class="container-fluid flex-grow-1 container-p-y">
                        <div class="card"> <br>
                            <center><h5 class="">MIXTE</h5></center>
                            <div class="table-responsive text-nowrap">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Nom</th>
                                            <th>Poids en kg</th>
                                            <th>Type de Colis</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($poissons as $nom_poisson => $qtt_poisson): ?>
                                            <tr>
                                                <form action="../stock/add.php" method="POST">
                                                    <td><i class="fab fa-angular fa-lg text-danger me-3"></i> <strong><?= htmlspecialchars($nom_poisson) ?></strong></td>
                                                    <td><?= htmlspecialchars($qtt_poisson) ?></td>
                                                    
                                                    <td>
                                                        <input type="hidden" value='<?= htmlspecialchars($qtt_poisson) ?>' name="poids">
                                                        <input type="submit" value="Retour" class="form-control btn-success">
                                                    </td>
                                                </form>
                                            </tr>
                                        <?php endforeach; ?>
                                        <tr>
                                            <form action="Addcbrdelpar.php" method="POST">
                                                <td><strong>Total : <?= htmlspecialchars($total_poid) ?></strong></td>
                                                <td>
                                                    <input type="hidden" value='100' name="num">
                                                    <input type="hidden" value='<?= htmlspecialchars($total_poid) ?>' name="poids">
                                                    <select class="form-control" name="poisson_type">
                                                        <?php require('../poisson/liste.php') ?>
                                                    </select>
                                                </td>
                                                <td>
                                                    <input type="date" name="daty" class="form-control">
                                                </td>
                                                <td>
                                                    <input type="submit" value="Melange" class="form-control btn-danger">
                                                </td>
                                            </form>
                                            
                                            <td><strong></strong></td>
                                        </tr>
                                    </tbody>
                                </table>
                              
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
    <!-- / Layout wrapper -->

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <!-- Core JS -->
    <script src="../assets/vendor/libs/jquery/jquery.js"></script>
    <script src="../assets/vendor/libs/popper/popper.js"></script>
    <script src="../assets/vendor/js/bootstrap.js"></script>
    <script src="../assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>
    <script src="../assets/vendor/js/menu.js"></script>
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
