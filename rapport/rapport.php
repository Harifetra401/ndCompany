<?php
session_start();
if ($_SESSION['username']!='Anthony' && $_SESSION['username']!='Nordine' && $_SESSION['username']!='Arsene') {
  ?>
    <script>
      alert("Vous ne pouvez pas acceder a cette page, Merci de contacter Votre administrateur ");
      window.location.href = "../html/index.php"; 

    </script>
  <?php
   
}
require ('../html/data.php');
require ('../html/date.php');
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
  <link href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap" rel="stylesheet" />
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
      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
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

            <div class="row">
              <!-- Order Statistics -->

              <div class="col-md-6 col-lg-4 col-xl-4 order-1 mb-4">
                <div class="card h-100">
                  <div class="card-body">
                    <div class="d-flex justify-content-between  flex-column mb-3">
                     
                      
                      <div class="d-flex flex-column gap-0">
                      <h3>Achat</h3>
                       
                      </div>
                      <br>
                    <div class="btn-group">
                      <!--<a href="article.php" class="btn btn-primary">Détails</a>-->
                      <button type="button" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                        Rapport
                      </button>
                      <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="TotalAchatParjour.php">Achat par jour</a></li>
                        <li><a class="dropdown-item" href="PoisFournisseur.php">Achat par fournisseur</a></li>
                        <li><a class="dropdown-item" href="filtreAchatPar.php">Achat par type de produit</a></li>
                      </ul>
                    </div>

                      <div class="d-flex flex-column gap-0">
                        
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <div class="col-md-6 col-lg-4 col-xl-4 order-1 mb-4">
                <div class="card h-100">
                  <div class="card-body">
                    <div class="d-flex justify-content-between  flex-column mb-3">
                     
                      
                      <div class="d-flex flex-column gap-0">
                      <h3>Traitement</h3>
                       
                      </div>
                      <br>
                    <div class="btn-group">
                      <!--<a href="article.php" class="btn btn-primary">Détails</a>-->
                      <button type="button" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                        Rapport
                      </button>
                      <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="rpdate.php">Traitement Par jour</a></li>
                        <!--<li><a class="dropdown-item" href="achat_par_fournisseur.php"></a></li>-->
                        <!--<li><a class="dropdown-item" href="achat_par_produit.php">Traitement par type de produit</a></li>-->
                      </ul>
                    </div>

                      <div class="d-flex flex-column gap-0">
                        
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-md-6 col-lg-4 col-xl-4 order-1 mb-4">
                <div class="card h-100">
                  <div class="card-body">
                    <div class="d-flex justify-content-between  flex-column mb-3">
                     
                      
                      <div class="d-flex flex-column gap-0">
                      <h3>Stock & Chargement</h3>
                       
                      </div>
                      <br>
                    <div class="btn-group">
                      <!--<a href="article.php" class="btn btn-primary">Détails</a>-->
                      <button type="button" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                        Rapports
                      </button>
                      <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="miseSac.php">Mise en sac par variete</a></li>
                        <!--<li><a class="dropdown-item" href="achat_par_fournisseur.php">Sortie Stock</a></li>-->
                        <li><a class="dropdown-item" href="TotalSortieTranche.php">Sortie Stock pour Tranche</a></li>
                        <li><a class="dropdown-item" href="SortieMelange.php">Sortie Stock Pour Melange</a></li>
                        <!--<li><a class="dropdown-item" href="achat_par_produit.php">Vente congele</a></li>-->
                        <li><a class="dropdown-item" href="../activity/chargement.php">Chargement par jour</a></li>
                        <li><a class="dropdown-item" href="chargementParvariete.php">Chargement par variete</a></li>
                        <li><a class="dropdown-item" href="SousglassVariete.php">Sous - Glace par variete</a></li>
                      </ul>
                    </div>

                      <div class="d-flex flex-column gap-0">
                        
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <!--<div class="col-md-6 col-lg-4 col-xl-4 order-1 mb-4">-->
              <!--  <div class="card h-100">-->
              <!--    <div class="card-body">-->
              <!--      <div class="d-flex justify-content-between  flex-column mb-3">-->
                     
                      
              <!--        <div class="d-flex flex-column gap-0">-->
              <!--        <h3>Chargement</h3>-->
                       
              <!--        </div>-->
              <!--        <br>-->
              <!--      <div class="btn-group">-->
                      <!--<a href="article.php" class="btn btn-primary">Détails</a>-->
              <!--        <button type="button" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">-->
              <!--          Rapport-->
              <!--        </button>-->
              <!--        <ul class="dropdown-menu">-->
              <!--          <li><a class="dropdown-item" href="../activity/chargement.php">Chargement par jour</a></li>-->
              <!--          <li><a class="dropdown-item" href="chargementParvariete.php">Chargement par variete</a></li>-->
              <!--          <li><a class="dropdown-item" href="SousglassVariete.php">Sous - Glace par variete</a></li>-->
              <!--        </ul>-->
              <!--      </div>-->

              <!--        <div class="d-flex flex-column gap-0">-->
                        
              <!--        </div>-->
              <!--      </div>-->
              <!--    </div>-->
              <!--  </div>-->
              <!--</div>-->
              <!--<div class="col-md-6 col-lg-4 col-xl-4 order-1 mb-4">-->
              <!--  <div class="card h-100">-->
              <!--    <div class="card-body">-->
              <!--      <div class="d-flex justify-content-between  flex-column mb-3">-->
                     
                      
              <!--        <div class="d-flex flex-column gap-0">-->
              <!--        <h3>Flux Financiers</h3>-->
                       
              <!--        </div>-->
              <!--        <br>-->
              <!--      <div class="btn-group">-->
                      <!--<a href="article.php" class="btn btn-primary">Détails</a>-->
              <!--        <button type="button" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">-->
              <!--          Rapport-->
              <!--        </button>-->
              <!--        <ul class="dropdown-menu">-->
              <!--          <li><a class="dropdown-item" href="achat_par_jour.php">Journal de Caisse</a></li>-->
              <!--        </ul>-->
              <!--      </div>-->

              <!--        <div class="d-flex flex-column gap-0">-->
                        
              <!--        </div>-->
              <!--      </div>-->
              <!--    </div>-->
              <!--  </div>-->
              <!--</div>-->
              <!--<div class="col-md-6 col-lg-4 col-xl-4 order-1 mb-4">-->
              <!--  <div class="card h-100">-->
              <!--    <div class="card-body">-->
              <!--      <div class="d-flex justify-content-between  flex-column mb-3">-->
                     
                      
              <!--        <div class="d-flex flex-column gap-0">-->
              <!--        <h3>Vente</h3>-->
                       
              <!--        </div>-->
              <!--        <br>-->
              <!--      <div class="btn-group">-->
                      <!--<a href="article.php" class="btn btn-primary">Détails</a>-->
              <!--        <button type="button" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">-->
              <!--          Rapport-->
              <!--        </button>-->
              <!--        <ul class="dropdown-menu">-->
              <!--          <li><a class="dropdown-item" href="achat_par_jour.php">vente par Jour</a></li>-->
              <!--          <li><a class="dropdown-item" href="achat_par_fournisseur.php">vente par client</a></li>-->
              <!--          <li><a class="dropdown-item" href="achat_par_produit.php">vente par type de produit</a></li>-->
              <!--        </ul>-->
              <!--      </div>-->

              <!--        <div class="d-flex flex-column gap-0">-->
                        
              <!--        </div>-->
              <!--      </div>-->
              <!--    </div>-->
              <!--  </div>-->
              <!--</div>-->
              <!--/ Order Statistics -->

              <style>
                .chart-container {
                  position: relative;
                  width: 100%;
                  height: 100%;
                }

                #myChart {
                  width: 100% !important;
                  height: 100% !important;
                }
              </style>
              <!-- Transactions -->
              <!-- <div class="col-md-8 col-lg-8 order-0 mb-8">
                <div class="card h-100">
                  <div class="card-header d-flex align-items-center justify-content-between">
                    <h5 class="card-title m-0 me-2">Diagramme </h5>
                  </div>
                  <div class="card-body">
                    <div>
                      <canvas id="myChart"></canvas>
                    </div>
                  </div>
                </div>
              </div> -->
              <!--/ Transactions -->
              <div class="container-fluid flex-grow-1 container-p-y col-md-8 col-lg-8 order-3 mb-8">


                <div class="card h-100">
                  
                  <?php require('rpyears.php')?>
                 <?php require('listeFact.php')?>
                </div>


              </div>
              <!--/ Layout Demo -->


            </div>

          </div>
        </div>
        <!-- / Content -->

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
  <script async defer src="https://buttons.github.io/buttons.js"></script>
