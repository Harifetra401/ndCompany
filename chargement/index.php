<?php
require ('../session.php');
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
        <?php $title = 'Chargement' ?>
        <?php require ('../nav/header.php') ?>
        <!-- / Navbar -->

        <!-- Content wrapper -->
        <div class="content-wrapper">
          <!-- Content -->

          <div class="container-xxl flex-grow-1 container-p-y">
            <div class="row">
              <div class="col-md-12">
                <div class="row">
                  <div class="col-md-4 col-12 mb-md-0 mb-4">
                    <div class="card">
                      <h5 class="card-header">Les poissons sortie</h5>
                      <div class="card-body">
                        <form id="formAuthentication" class="mb-3" action="add.php" method="POST">
                          <input type="hidden" name="id_sortie" value="<?= $_GET["id"] ?>">
                          <div class="mb-3 form-password-toggle">
                            <div class="d-flex justify-content-between">
                              <label class="form-label" for="password">Selection Poisson</label>

                            </div>


                            <div class="d-flex mb-3">

                              <div class="flex-grow-1 row">
                                <div class="input-group input-group-merge">
                                  <select id="defaultSelect" name="poisson" class="form-select">
                                    <?php require ('../poisson/liste.php') ?>
                                  </select>
                                </div>

                                <!-- </div> -->
                              </div>
                            </div>
                            <div class="d-flex justify-content-between">
                              <label class="form-label" for="password">Nombre de sac</label>

                            </div>
                            <div class="input-group input-group-merge">
                              <input type="number" class="form-control" name="sac" placeholder="" aria-describedby=""
                                require />
                            </div>
                            <div class="d-flex justify-content-between">

                              <label class="form-label" for="password">Poid en Kg</label>

                            </div>
                            <div class="input-group input-group-merge">
                              <input type="number" step="0.01" id="" class="form-control" name="qtt" placeholder=""
                                require />
                            </div>
                          </div>
                          <div class="mb-3">
                            <button class="btn btn-primary d-grid w-100" type="submit">Ajouter</button>
                          </div>
                        </form>


                        <!-- /Connections -->
                      </div>
                    </div>
                  </div>
                  <div class="col-md-8 col-12">
                    <div class="card">
                      <div class="row">
                        <!-- Bootstrap carousel -->
                        <div class="col-md">
                          <h5 class="my-4">Bon de livraison numero <?= $_GET["id"] ?> du chargemnt aujourd'hui</h5>
                          <div>
                          </div>
                        </div>
                      </div>
                      <div class="card-body">
                        <p></p>
                        <!-- Social Accounts -->
                        <div class="card">
                          <div class="table-responsive text-nowrap">
                            <table class="table">
                              <thead>
                                <tr>
                                  <th>Poisson</th>
                                  <th>Poid</th>
                                  <th>Nombre de sac</th>

                                </tr>
                              </thead>
                              <tbody class="table-border-bottom-0">
                                <?php require ('liste_total.php') ?>
                              </tbody>
                            </table>
                          </div>
                        </div>
                        <!-- /Social Accounts -->
                      </div>
                    </div>
                  </div>
                  <!-- tout les liste  -->
                  <div class="col-md-12 col-12">
                    <div class="card">
                      <div class="row">
                        <!-- Bootstrap carousel -->
                        <div class="col-md">
                          <h5 class="my-4">Tout les listes detailler</h5>

                        </div>
                      </div>
                      <div class="card-body">
                        <p></p>
                        <!-- Social Accounts -->
                        <div class="card">
                          <div class="table-responsive text-nowrap">
                            <table class="table">
                              <thead>
                                <tr>
                                  <th>Poisson</th>
                                  <th>Poid</th>
                                  <th>Nombre de sac</th>

                                </tr>
                              </thead>
                              <tbody class="table-border-bottom-0">
                                <?php require ('liste.php') ?>
                              </tbody>
                            </table>
                          </div>
                        </div>
                        <!-- /Social Accounts -->
                      </div>
                    </div>
                  </div>

                </div>
              </div>
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