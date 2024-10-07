<?php
require '../session.php';
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
  <link href="https://fonts.googleapis.com/css2?family=Public+Sans:wght@300;400;500;600;700&display=swap"
    rel="stylesheet" />

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
  <link rel="stylesheet" href="../assets/css/custom.css" /> <!-- Custom styles -->

  <!-- Helpers -->
  <script src="../assets/vendor/js/helpers.js"></script>
  <script src="../assets/js/config.js"></script>
</head>

<body>
  <!-- Layout wrapper -->
  <div class="layout-wrapper layout-content-navbar">
    <div class="layout-container">
      <!-- Menu -->
      <?php require '../nav/menu.php'; ?>
      <!-- / Menu -->

      <!-- Layout container -->
      <div class="layout-page">
        <!-- Navbar -->
        <?php $title = 'Chargement'; ?>
        <?php require '../nav/header.php'; ?>
        <!-- / Navbar -->

        <!-- Content wrapper -->
        <div class="content-wrapper">
          <!-- Content -->
          <div class="container-xxl flex-grow-1 container-p-y">
            <div class="row">
              <div class="col-md-12">
                <div class="row">
                  <!-- Add Poisson Form -->
                  <div class="col-md-4 col-12 mb-md-0 mb-4">
                    <div class="card">
                      <h5 class="card-header">Les poissons sortie</h5>
                      <div class="card-body">
                        <form id="formAuthentication" class="mb-3" action="add.php" method="POST">
                          <input type="hidden" name="id_sortie" value="<?= htmlspecialchars($_GET["id"]) ?>">
                          <div class="mb-3 form-password-toggle">
                            <label class="form-label" for="poissonSelect">Selection Poisson</label>
                            <select id="poissonSelect" name="poisson" class="form-select" required>
                              <?php require '../poisson/liste.php'; ?>
                            </select>
                            <br>
                            <label class="form-label" for="typeselect">Mise En</label>
                            <select id="typ" name="typ" class="form-select" required>
                              <option value="1">En sac</option>
                              <option value="2">En Carton</option>
                            </select>
                            <label class="form-label mt-3" for="sacNumber">QUANTITE</label>
                            <input type="number" id="sacNumber" class="form-control" name="sac" required />

                            <label class="form-label mt-3" for="poidNumber">Poid en Kg</label>
                            <input type="number" step="0.01" id="poidNumber" class="form-control" name="qtt" required />
                          </div>
                          <button class="btn btn-primary d-grid w-100" type="submit">Ajouter</button>
                        </form>
                      </div>
                    </div>
                  </div>

                  <!-- Bon de Livraison -->
                  <div class="col-md-8 col-12">
                    <div class="card">
                      <table class="table">

                        <tr>
                          <th></th>
                          <th style="width:200px"> <br><br>
                            <div class="col-md-12  w-300">
                              <center> <img src="../assets/img/logonordine.jpg" width="150px" alt=""></center>
                            </div>
                          </th>
                          <th></th>
                          <th></th>
                          <th>
                            <div class="col-md">

                              <h6 class="my-4">Client : </h6>
                              <h6 class="my-4">Adresse :</h6>
                              <h6 class="my-4">Contact :</h6>


                            </div>
                          </th>

                        </tr>

                      </table>
                      <h5 class="card-header">Bon de livraison numero <?= htmlspecialchars($_GET["id"]) ?> du chargement
                        aujourd'hui</h5>
                      <div class="card-body">
                        <div class="table-responsive text-nowrap">
                          <table class="table">
                            
                              <tr>
                                <th>Poisson</th>
                                <th>Poid</th>
                                <th>Nombre de sac</th>
                              </tr>
                           
                              <?php require 'liste_total.php'; ?>
                            
                          </table>
                        </div>
                      </div>
                    </div>
                  </div>

                  <!-- Detailed List -->

                  <!-- /Detailed List -->

                </div>
              </div>
            </div>
          </div>
          <!-- / Content -->

          <!-- Footer -->
          <footer class="content-footer footer bg-footer-theme">
            <div class="container-xxl">
              <div class="footer-container d-flex justify-content-between py-2 flex-md-row flex-column">
                <div class="mb-2 mb-md-0">

                </div>
                <div>

                </div>
              </div>
            </div>
          </footer>
          <!-- / Footer -->

          <div class="content-backdrop fade"></div>
        </div>
        <!-- / Content wrapper -->
      </div>
      <!-- / Layout page -->
    </div>
    <!-- Overlay -->
    <div class="layout-overlay layout-menu-toggle"></div>
  </div>
  <!-- / Layout wrapper -->

  <!-- Core JS -->
  <script src="../assets/vendor/libs/jquery/jquery.js"></script>
  <script src="../assets/vendor/libs/popper/popper.js"></script>
  <script src="../assets/vendor/js/bootstrap.js"></script>
  <script src="../assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>
  <script src="../assets/vendor/js/menu.js"></script>

  <!-- Main JS -->
  <script src="../assets/js/main.js"></script>
  <!-- Custom JS -->
  <script src="../assets/js/custom.js"></script>
</body>

</html>