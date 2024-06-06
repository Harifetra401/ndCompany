<?php
require('../db.php');
// //   if(empty($_GET['id'])) header('location:../html');
$id = $_GET['id'];

// selection information dans table 
$per = "SELECT * FROM personnel WHERE id=$id";
$stmt_per = $db->prepare($per);
$stmt_per->execute();
$fetch = $stmt_per->fetch();

// selection photo de profil
$select_img = $db->prepare("SELECT * FROM imgpers WHERE id=$id");
$select_img->execute();
$fetch_img = $select_img->fetch();
$img_pdp = $fetch_img["img"];

// selection CV
$select_cv = $db->prepare("SELECT * FROM cv WHERE id=$id");
$select_cv->execute();
$fetch_cv = $select_cv->fetch();
$cv = $fetch_cv["cv"];
?>
<!DOCTYPE html>

<html lang="en" class="light-style layout-menu-fixed" dir="ltr" data-theme="theme-default" data-assets-path="../assets/" data-template="vertical-menu-template-free">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

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
</head>

<body>
  <!-- Layout wrapper -->
  <div class="layout-wrapper layout-content-navbar">
    <div class="layout-container">
      <!-- Menu -->
      <?php require('../nav/menu.php'); ?>
      <!-- / Menu -->

      <!-- Layout container -->
      <div class="layout-page">

        <!-- Navbar -->
        <?php $title = 'Dashboard' ?>
        <?php require('../nav/header.php') ?>
        <!-- / Navbar -->
        <div class="content-wrapper">
          <!-- Content -->
          <div class="container-xxl flex-grow-1 container-p-y">

            <div class="row">
              <div class="col-md-12">
                <div class="row">


                  <div class="col-md-4 col-4 mb-md-0 mb-4">
                    <div class="card">

                      <div class="card-body">
                        <form action="insert_img.php" method="post" enctype="multipart/form-data">
                          <input type="hidden" name="id" value="<?= $id ?>">
                          <?php
                          if (!empty($img_pdp)) {
                            echo "<img src='$img_pdp' alt='$img_pdp' title='photo de profil' class='img-fluid' />";
                          } else {
                            require('uploads/avatar_default.php');
                          }
                          ?>
                          <input type="file" id="mypdp" name="image" class="form-control" title="Choisir une autre image">
                          <br>
                          <h5><?= $fetch['nom'] ?></h5>
                          <i class="far fa-edit mb-5"></i>
                          <h6>Information</h6>
                          <hr class="mt-0 mb-4">
                          <div class="row pt-1">
                            <div class="col-6 mb-3">
                              <h6>Poste</h6>
                              <p class="text-muted"><?= $fetch['poste'] ?></p>
                            </div>
                            <div class="col-6 mb-3">
                              <h6>Contact</h6>
                              <p class="text-muted"><?= $fetch['contact'] ?></p>
                            </div>
                            <input type="submit" name="submit" value="Modifier l'image" class="btn btn-primary">
                          </div>
                        </form>
                      </div>
                    </div>
                    <!-- Connections -->
                  </div>

                  <div class="col-md-8 col-12">
                    <div class="card">
                      <div class="row">

                      </div>
                      <div class="card-body">
                        <p></p>
                        <div class="card">
                          <form action="insert_cv.php" method="post" enctype="multipart/form-data">
                            <input type="hidden" name="id" value="<?= $id ?>">
                            
                            <div class="card-body">
                              <div>
                                <?php
                                if (!empty($cv)) {
                                  echo "<iframe src='$cv' width='100%' height='600'></iframe>";
                                } else {
                                  echo "importer un cv (*pdf)";
                                }

                                ?>

                              </div>
                              <input type="file" id="mypdp" name="fichier" class="" accept="application/pdf" title="Choisir un autre image">
                              <input type="submit" value="modifier le cv" class="btn btn-primary">
                            </div>
                          </form>
                        </div>
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
        </div>

        <!-- </div>
</div>
</div> -->
        <!--/ Order Statistics -->

        <!-- Expense Overview -->

        <!--/ Expense Overview -->


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