<?php
session_start();
if ($_SESSION['username']!='Anthony') {
    header('location:../index.php');
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
  <link href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap" rel="stylesheet" />

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
      <?php require('../nav/menu.php') ?>
      <!-- / Menu -->

      <!-- Layout container -->
      <div class="layout-page">

        <!-- Navbar -->
        <?php $title = 'Achat' ?>
        <?php require('../nav/header.php') ?>
        <!-- / Navbar -->

        <!-- Content wrapper -->
        <div class="content-wrapper">
          <!-- Content -->

          <div class="container-xxl flex-grow-1 container-p-y">
            <h4 class="fw-bold py-3 mb-4">
              <span class="text-muted fw-light"> </span> Facture D'Achat
            </h4>

            <div class="row">
              <div class="col-md-12">
                <div class="row">
                  <div class="col-md-4 col-12 mb-md-0 mb-4">
                    <div class="card">
                      <h5 class="card-header">Creation Facture</h5>
                      <div class="card-body">
                        <form id="formAuthentication" class="mb-3" action="../poisson/ajoutDetail.php" method="POST">
                          <div class="mb-3 form-password-toggle">
                            <div class="d-flex justify-content-between">
                              <label class="form-label" for="password">Selection Poisson</label>

                            </div>


                            <div class="d-flex mb-3">

                              <div class="flex-grow-1 row">
                                <div class="col- col-sm-10 mb-sm-0 mb-8">
                                  <div class="input-group input-group-merge">
                                    <select id="defaultSelect" name="poisson" class="form-select">
                                      <?php require('../poisson/liste.php') ?>
                                    </select>
                                  </div>
                                </div>
                                <!-- <div class=""> -->

                                <button type="button" class="col-4 col-sm-2  btn btn-icon btn-primary" data-bs-toggle="modal" data-bs-target="#basicModal">
                                  <i class="">+</i>
                                </button>

                                <!-- </div> -->
                              </div>
                            </div>
                            <div class="d-flex justify-content-between">

                              <label class="form-label" for="password">Poid en Kg</label>

                            </div>
                            <div class="input-group input-group-merge">
                              <input type="number" id="" step="0.01" title="" class="form-control" name="qtt" placeholder="" required />
                            </div>
                            <div class="d-flex justify-content-between">
                              <label class="form-label" for="password">Categorie</label>
                            </div>
                            <div class="input-group input-group-merge">
                                  <select id="defaultSelect" name="cat" class="form-select">
                                    <option value="1"></option>
                                    <option value="2">Triee</option>
                                    <option value="3">TV</option>
                                    <option value="4">Petit</option>
                                  </select>
                                  </div>

                                  <div class="d-flex justify-content-between">
                             
                            </div>
                            
                            <div class="d-flex justify-content-between">
                              <label class="form-label" for="password"></label>
                            </div>
                            <div class="input-group input-group-merge">
                              <input type="hidden" class="form-control" value="0" name="pu" placeholder="" aria-describedby=""  />

                            </div>
                          </div>
                          <input type="hidden" name="id_fournisseur" value="<?= $_GET['id_fournisseur'] ?>" />
                          <input type="hidden" name="numFact" value="<?= $_GET['numFact'] ?>" />
                          <div class="mb-3">
                            <button class="btn btn-primary d-grid w-100" type="submit">Ajouter</button>
                          </div>
                        </form>
                        <div class="modal fade" id="basicModal" tabindex="-1" aria-hidden="true">
                          <div class="modal-dialog" role="document">
                            <div class="modal-content">
                              <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel1">Ajout Poisson</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                              </div>
                              <form action="../poisson/add_new.php" method='POST'>
                                <div class="modal-body">
                                  <div class="row">
                                    <div class="col mb-3">
                                      <label for="nameBasic" class="form-label">Nom</label>
                                      <input type="text" id="nameBasic" class="form-control" placeholder="Non de Poisson" name="nom" />
                                      <input type="hidden" name="id_fournisseur" value="<?= $_GET['id_fournisseur'] ?>" />
                                      <input type="hidden" name="numFact" value="<?= $_GET['numFact'] ?>" />
                                    </div>
                                  </div>


                                </div>
                                <div class="modal-footer">

                                  <button type="submit" class="btn btn-primary">Enregistrer</button>
                                </div>
                              </form>
                            </div>
                          </div>
                        </div>
                        <!-- Connections -->

                        <!-- /Connections -->
                      </div>
                    </div>
                  </div>
                  <div class="col-md-8 col-12">

                    <div class="card" id="content">
                      <table class="table">

                        <tr>
                          <th style="width:200px"> <br><br>
                            <div class="col-md-12  w-300">
                              <center> <img src="../assets/img/logonordine.jpg" width="150px" alt=""></center>
                            </div>
                          </th>
                          <th>
                            <div class="col-md">
                              <?php require('../fournisseur/detail.php') ?>
                              <h6 class="my-4">Fournisseur : <?= $nom_fou ?></h6>
                              <h6 class="my-4">Adresse : <?= $Adresse_fou ?></h6>
                              <h6 class="my-4">Contact : <?= $contact_fou ?></h6>


                            </div>
                          </th>

                        </tr>

                      </table>
                      <div class="row">
                        <!-- Bootstrap carousel -->

                        <!-- Bootstrap crossfade carousel -->

                      </div>
                      <div class="card-body">
                        <p></p>
                        <!-- Social Accounts -->
                        <div class="card">
                          <h5 class="card-header">Facture Numero : <?= $_GET['numFact'] ?></h5>
                          <div class="table-responsive text-nowrap">
                            <table class="table">
                              <thead>
                                <tr>
                                  <th>Poisson</th>
                                  <th>Poid</th>
                                  <th>Prix Unitaire</th>
                                  <th>Prix Total</th>

                                </tr>
                              </thead>
                              <tbody class="table-border-bottom-0">
                                <?php require('../poisson/list_detail.php') ?>
                              </tbody>
                            </table>
                          </div>
                        </div>
                        <p>Poid total: <?= $total_poid ?> KG</p>
                        <p>Prix total: <?= $total ?> AR</p>
                        <!-- /Social Accounts -->
                      </div>
                    </div>
                    <button class="btn btn-primary" onclick="imprimerContenu()">Imprimer</button>
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
  <script>
    function imprimerContenu() {
      var contenuDiv = document.getElementById('content').innerHTML;
      var fenetreImpression = window.open('', '_blank');
      fenetreImpression.document.write('<html><head><link rel="stylesheet" href="../assets/vendor/css/core.css" class="template-customizer-core-css"/><link rel="stylesheet" href="../assets/vendor/css/theme-default.css" class="template-customizer-theme-css" /><link rel="stylesheet" href="../assets/css/demo.css" /><title>Impression</title></head><body>');
      fenetreImpression.document.write(contenuDiv);
      fenetreImpression.document.write('</body></html>');
      fenetreImpression.document.close();
      fenetreImpression.print();
      fermerModal(); // Fermer la modal après l'impression
    }
  </script>
</body>

</html>