<?php
require ('../session.php');
require ('data.php');
require ('date.php');
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
            <?php require ('../nav/menu.php') ?>
            <!-- / Menu -->

            <!-- Layout container -->
            <div class="layout-page">

                <!-- Navbar -->
                <?php $title = 'Suivie de Dépenses' ?>
                <?php require ('../nav/header.php') ?>
                <!-- / Navbar -->

                <!-- Content wrapper -->
                <div class="content-wrapper">
                    <!-- Content -->

                    <div class="container-xxl flex-grow-1 container-p-y">

                        <div class="row">

                            <div class="col-md-4 col-lg-4 order-4 mb-4">
                                <div class="card h-100">
                                    <div class="card-body">
                                        <div class="">
                                            <h1>Debit / credit</h1> <br><br>
                                            <canvas class="col-lg-8" id="myChart2"
                                                style="display: block; width: 300px; height: auto;">
                                            </canvas>
                                            <br><br>
                                            <h6>
                                             Solde en Main : <?= get_entrer($mois_actuel, $annee_actuel) + get_particulier_month($mois_actuel, $annee_actuel) - get_depense_month($mois_actuel, $annee_actuel) ?> Ariary
                                            </h6>
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <div class="col-md-8 col-lg-8 order-0 mb-8">
                                <div class="card h-100">
                                    <div class="card-header d-flex align-items-center justify-content-between">
                                        <h5 class="card-title m-0 me-2">Diagramme annee:
                                            <?= $annee_precedente_11 . '-' . $annee_actuel ?>
                                        </h5>
                                    </div>
                                    <div class="card-body">
                                        <div>
                                            <canvas id="myChartYear"></canvas>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>


                    </div>
                    <div class="container-fluid flex-grow-1 container-p-y">


                        <div class="card h-100">
                            <div class="card-header d-flex align-items-center justify-content-between">
                                <h5 class="card-title m-0 me-2">Diagramme Détaillé </h5>
                            </div>
                            <div class="card-body">
                                <div>
                                    <canvas id="myChartclass"></canvas>
                                </div>
                            </div>
                        </div>


                    </div>
                    <div class="container-fluid flex-grow-1 container-p-y">
                        <div class="card mt-5">
                            <h2>Tableau DEBITEUR</h2>
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Charge</th>
                                        <th>Libelle</th>
                                        <th>Montant</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td></td>
                                        <td>Dépense Personnel</td>
                                        <td> <?= get_depense_pers($mois_actuel, $annee_actuel) ?></td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td>Frais de deplacement</td>
                                        <td><?= get_depense_dpl($mois_actuel, $annee_actuel) ?></td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td>Aménagement</td>
                                        <td><?= get_depense_amenagemen($mois_actuel, $annee_actuel) ?></td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td>Loyer </td>
                                        <td><?= get_depense_loyer($mois_actuel, $annee_actuel) ?></td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td>AUTORITE </td>
                                        <td><?= get_depense_aut($mois_actuel, $annee_actuel) ?></td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td>Commission </td>
                                        <td><?= get_depense_comms($mois_actuel, $annee_actuel) ?></td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td>Compte d'Immobilisation </td>
                                        <td><?= get_depense_imo($mois_actuel, $annee_actuel) ?></td>
                                    </tr>

                                    <tr>
                                        <td></td>
                                        <td>Autres dépenses</td>
                                        <td><?= get_depense_autre($mois_actuel, $annee_actuel) ?></td>
                                    </tr>
                                    <tr class="bg-success">
                                        <td>Depenses Ordinaire</td>
                                        <td></td>
                                        <td><?= get_depense_month_by_class1($mois_actuel, $annee_actuel) ?></td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td>Enlèvement des produits</td>
                                        <td><?= get_depense_elprod($mois_actuel, $annee_actuel) ?></td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td>Conservation des produits</td>
                                        <td><?= get_depense_csrvprod($mois_actuel, $annee_actuel) ?></td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td>Coût du Traitements</td>
                                        <td><?= get_depense_ctrait($mois_actuel, $annee_actuel) ?></td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td>Matériels d'approvisionnements</td>
                                        <td><?= get_depense_appro($mois_actuel, $annee_actuel) ?></td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td>Emballage des produits</td>
                                        <td><?= get_depense_emball($mois_actuel, $annee_actuel) ?></td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td>Dépenses diverses</td>
                                        <td><?= get_depense_dpdiv($mois_actuel, $annee_actuel) ?></td>
                                    </tr>
                                    <tr class="bg-primary">
                                        <td>Couts et Productions</td>
                                        <td></td>
                                        <td><?= get_depense_month_by_class2($mois_actuel, $annee_actuel) ?></td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td>Transport locale</td>
                                        <td><?= get_depense_transloc($mois_actuel, $annee_actuel) ?></td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td>Livraison à Tanà</td>
                                        <td><?= get_depense_lTana($mois_actuel, $annee_actuel) ?></td>
                                    </tr>
                                    <tr class="bg-success">
                                        <td>Transport</td>
                                        <td></td>
                                        <td><?= get_depense_month_by_class3($mois_actuel, $annee_actuel) ?></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!-- / Content -->

                    <!-- Footer -->
                    <!-- / Footer -->

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

    <script>
        let sem = ["Dimanche", "Lundi", "Mardi", "Mercredi", "Jeudi", "Vendredi", "Samedi"];
        let year = ["Janvier", "Février", "Mars", "Avril", "Mai", "Juin", "Juillet", "Août", "Septembre", "Octobre", "Novembre", "Décembre"];
        var date = new Date();

        function get_jour(sous) {
            let code = (date.getDay() - sous);
            code = code < 0 ? 7 + code : code;
            return code;
        }
        function get_month(sous) {
            let code = (date.getMonth() - sous);
            code = code < 0 ? 12 + code : code;
            return code;
        }

        // courbe debit Credit
        var ctx2 = document.getElementById("myChart2").getContext("2d");

        var myChart2 = new Chart(ctx2, {
            type: "pie",
            data: {
                labels: ["Debit", "Credit"],
                datasets: [{
                    label: "work load",
                    data: [<?= get_entrer($mois_actuel, $annee_actuel) + get_particulier_month($mois_actuel, $annee_actuel) ?>, <?= get_depense_month($mois_actuel, $annee_actuel) ?>],
                    backgroundColor: ['rgb(54, 162, 235)', 'rgb(255, 99, 132)'],
                }],
            },
        });

        // diagramme pour chaque annee
        var ctx = document.getElementById("myChartYear").getContext("2d");
        var myChartYear = new Chart(ctx, {
            type: "bar",
            data: {
                labels: [

                    year[get_month(0)],
                ],
                datasets: [

                    {
                        label: "Dépense Ordinaire (MGA)",
                        data: [

                            <?= get_depense_month_by_class1($mois_actuel, $annee_actuel) ?>,
                        ],

                        backgroundColor: "rgba(150,255,0,0.6)",
                    }, {
                        label: "Coûts sur Produits(MGA)",
                        data: [

                            <?= get_depense_month_by_class2($mois_actuel, $annee_actuel) ?>,
                        ],

                        backgroundColor: "rgba(150,0,0,0.6)",
                    }, {

                        label: "Dépense Transport (MGA)",
                        data: [

                            <?= get_depense_month_by_class3($mois_actuel, $annee_actuel) ?>,
                        ],

                        backgroundColor: "rgba(200,0,100,0.6)",
                    }
                ],
            },
        });


        var ctx = document.getElementById("myChartclass").getContext("2d");
        var myChartclass = new Chart(ctx, {
            type: "bar",
            data: {
                labels: [
                    year[get_month(0)],
                ],
                datasets: [
                    {
                        label: "Dépense personnel (MGA)",
                        data: [
                            <?= get_depense_pers($mois_actuel, $annee_actuel) ?>,
                        ],
                        backgroundColor: "rgba(150,255,0,0.6)",
                    },
                    {
                        label: "Frais de deplacement(MGA)",
                        data: [
                            <?= get_depense_dpl($mois_actuel, $annee_actuel) ?>,
                        ],
                        backgroundColor: "rgba(255,99,132,0.6)",
                    },
                    {
                        label: "Aménagement (MGA)",
                        data: [
                            <?= get_depense_amenagemen($mois_actuel, $annee_actuel) ?>,
                        ],
                        backgroundColor: "rgba(54,162,235,0.6)",
                    },
                    {
                        label: "Loyer (MGA)",
                        data: [
                            <?= get_depense_loyer($mois_actuel, $annee_actuel) ?>,
                        ],
                        backgroundColor: "rgba(75,192,192,0.6)",
                    },
                    {
                        label: "AUTORITE (MGA)",
                        data: [
                            <?= get_depense_aut($mois_actuel, $annee_actuel) ?>,
                        ],
                        backgroundColor: "rgba(153,102,255,0.6)",
                    },
                    {
                        label: "Commission (MGA)",
                        data: [
                            <?= get_depense_comms($mois_actuel, $annee_actuel) ?>,
                        ],
                        backgroundColor: "rgba(255,159,64,0.6)",
                    },
                    {
                        label: "Compte d'Immobilisation (MGA)",
                        data: [
                            <?= get_depense_imo($mois_actuel, $annee_actuel) ?>,
                        ],
                        backgroundColor: "rgba(255,206,86,0.6)",
                    },
                    {
                        label: "Autres dépenses (MGA)",
                        data: [
                            <?= get_depense_autre($mois_actuel, $annee_actuel) ?>,
                        ],
                        backgroundColor: "rgba(0,255,127,0.6)",
                    },
                    {
                        label: "Enlèvement des produits (MGA)",
                        data: [
                            <?= get_depense_elprod($mois_actuel, $annee_actuel) ?>,
                        ],
                        backgroundColor: "rgba(0,191,255,0.6)",
                    },
                    {
                        label: "Conservation des produits (MGA)",
                        data: [
                            <?= get_depense_csrvprod($mois_actuel, $annee_actuel) ?>,
                        ],
                        backgroundColor: "rgba(75,0,130,0.6)",
                    },
                    {
                        label: "Coût du Traitements (MGA)",
                        data: [
                            <?= get_depense_ctrait($mois_actuel, $annee_actuel) ?>,
                        ],
                        backgroundColor: "rgba(240,128,128,0.6)",
                    },
                    {
                        label: "Matériels d'approvisionnements (MGA)",
                        data: [
                            <?= get_depense_appro($mois_actuel, $annee_actuel) ?>,
                        ],
                        backgroundColor: "rgba(124,252,0,0.6)",
                    },
                    {
                        label: "Emballage des produits (MGA)",
                        data: [
                            <?= get_depense_emball($mois_actuel, $annee_actuel) ?>,
                        ],
                        backgroundColor: "rgba(238,130,238,0.6)",
                    },
                    {
                        label: "Dépenses diverses (MGA)",
                        data: [
                            <?= get_depense_dpdiv($mois_actuel, $annee_actuel) ?>,
                        ],
                        backgroundColor: "rgba(255,69,0,0.6)",
                    },
                    {
                        label: "Transport locale (MGA)",
                        data: [
                            <?= get_depense_transloc($mois_actuel, $annee_actuel) ?>,
                        ],
                        backgroundColor: "rgba(0,255,255,0.6)",
                    },
                    {
                        label: "Livraison à Tanà (MGA)",
                        data: [
                            <?= get_depense_lTana($mois_actuel, $annee_actuel) ?>,
                        ],
                        backgroundColor: "rgba(255,20,147,0.6)",
                    }
                ],
            },
        });
    </script>

    <!-- Core JS -->
    <!-- build:js assets/vendor/js/core.js -->
    <script src="../assets/vendor/libs/jquery/jquery.js"></script>
    <script src="../assets/vendor/libs/popper/popper.js"></script>
    <script src="../assets/vendor/js/bootstrap.js"></script>
    <script src="../assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>

    <script src="../assets/vendor/js/menu.js"></script>
    <!-- endbuild -->

    <!-- Vendors JS -->

    <!-- Main JS -->
    <script src="../assets/js/main.js"></script>

    <!-- Page JS -->

    <!-- Place this tag in your head or just before your close body tag. -->
    <script async defer src="https://buttons.github.io/buttons.js"></script>
</body>

</html>