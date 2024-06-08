<?php
require ('../session.php');
require ('../db.php');
$id = $_GET['id'];

// Utilisation des paramètres préparés pour éviter les injections SQL
$selection = $db->prepare("SELECT * FROM particulier WHERE id = :id");
$selection->bindParam(':id', $id, PDO::PARAM_INT);
$selection->execute();
$fetchAll = $selection->fetchAll();
?>
<!DOCTYPE html>
<html lang="en" class="light-style layout-menu-fixed" dir="ltr" data-theme="theme-default" data-assets-path="../assets/"
  data-template="vertical-menu-template-free">

<head>
  <meta charset="utf-8" />
  <meta name="viewport"
    content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
  <title>Logiciel de Gestion</title>
  <meta name="description" content="Système de gestion" />
  <link rel="icon" type="image/x-icon" href="../assets/img/favicon/favicon.ico" />
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Public+Sans:wght@300;400;500;600;700&display=swap"
    rel="stylesheet" />
  <link rel="stylesheet" href="../assets/vendor/fonts/boxicons.css" />
  <link rel="stylesheet" href="../assets/vendor/css/core.css" />
  <link rel="stylesheet" href="../assets/vendor/css/theme-default.css" />
  <link rel="stylesheet" href="../assets/css/demo.css" />
  <link rel="stylesheet" href="../assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />
  <link rel="stylesheet" href="../assets/vendor/libs/apex-charts/apex-charts.css" />
  <link rel="stylesheet" href="../css/custom.css" /> <!-- Custom styles -->
  <script src="../assets/vendor/js/helpers.js"></script>
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
        <?php $title = 'Vente Perticulier' ?>
        <?php require ('../nav/header.php') ?>
        <!-- / Navbar -->

        <!-- Content wrapper -->
        <div class="content-wrapper">
          <!-- Content -->

          <div class="container-xxl flex-grow-2 container-p-y">
            <h4 class="fw-bold py-3 mb-4">
              <span class="text-muted fw-light"> </span> Enregistrement de vent Local
            </h4>
            <div class="d-flex mb-3">

              <div class="flex-grow-1 row">
                <div class="col- col-sm-10 mb-sm-0 mb-8">
                
                </div>
                <!-- <div class=""> -->

                <button type="button" class="col-4 col-sm-2  btn btn-icon btn-primary" data-bs-toggle="modal"
                  data-bs-target="#basicModal">
                  <i class="">+</i>
                </button>
                <div class="modal fade" id="basicModal" tabindex="-1" aria-hidden="true">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel1">Ajout client</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                      </div>
                      <form action="client.php" method='POST'>
                        <div class="modal-body">
                          <div class="row">
                            <div class="col mb-3">
                              <label for="nameBasic" class="form-label">Nom</label>
                              <input type="text" id="nameBasic" class="form-control" placeholder="Non de Poisson"
                                name="name" /> 
                                <input type="hidden" name="id" value="<?= $_GET['id'] ?>">
                             <br>   <label for="nameBasic" class="form-label">Adresse</label>
                              <input type="text" class="form-control" name="adresse" value="" />
                              <br><label for="nameBasic" class="form-label">Contact</label>
                              <input type="text" class="form-control" name="contact" value="" />
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
                <!-- </div> -->
              </div>
            </div>
            <div class="row">
              <div class="col-md-4 col-12 mb-md-0 mb-4">
                <div class="card">

                  <h5 class="card-header">Les poissons sortie</h5>
                  <div class="card-body">
                    <form id="formAuthentication" class="mb-3" action="add.php" method="POST">
                      <div class="mb-3">
                        <label class="form-label" for="poisson">Selection Poisson</label>
                        <select id="defaultSelect" name="poisson" class="form-select">
                          <?php require ('../poisson/liste.php') ?>
                        </select>
                      </div>
                      <div class="mb-3">
                        <label class="form-label" for="qtt">Poid en Kg</label>
                        <input type="hidden" name="id" value="<?= $_GET['id'] ?>">
                        <input type="number" class="form-control" name="qtt" required />
                      </div>
                      <div class="mb-3">
                        <label class="form-label" for="pu">Prix par KG</label>
                        <input type="number" class="form-control" name="pu" required />
                      </div>
                      <div class="mb-3">
                        <button class="btn btn-primary d-grid w-100" type="submit">Ajouter</button>
                      </div>


                    </form>

                    <!-- Modal -->
                  </div>
                </div>
              </div>
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
                  <h5 class="card-header">Vente d'aujourd'hui</h5>
                  <div class="card-body">
                    <div class="table-responsive text-nowrap">
                      <table class="table table-hover">
                        <thead>
                          <tr>
                            <th>Poisson</th>
                            <th>Poid</th>
                            <th>Prix</th>
                          </tr>
                        </thead>
                        <tbody class="table-border-bottom-0">
                          <?php require ('liste.php') ?>
                        </tbody>
                      </table>
                    </div><br><br><br>
                    <div class="col-md">

                          <h6 class="my-4">Client : <?= htmlspecialchars($client) ?> </h6>
                          <h6 class="my-4">Adresse :</h6>
                          <h6 class="my-4">Contact :</h6>


                        </div>
                    <h6> Somme de :<?= htmlspecialchars($total) ?></h6>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!-- / Content -->
          <div class="modal fade" id="addClientModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="addClientModalLabel">Ajouter Client</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  <form id="addClientForm" action="insert_client.php" method="POST">
                    <div class="form-group">
                      <label for="clientName">Nom du Client</label>
                      <input type="text" class="form-control" id="clientName" name="clientName" required>
                    </div>
                    <div class="form-group">
                      <label for="clientAddress">Adresse du Client</label>
                      <input type="text" class="form-control" id="clientAddress" name="clientAddress" required>
                    </div>
                    <div class="form-group">
                      <label for="clientContact">Contact du Client</label>
                      <input type="text" class="form-control" id="clientContact" name="clientContact" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Ajouter</button>
                  </form>
                </div>
              </div>
            </div>
          </div>
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