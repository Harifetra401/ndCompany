<?php session_start();
  

?>
<!DOCTYPE html>
<html lang="en" class="light-style layout-menu-fixed" dir="ltr" data-theme="theme-default" data-assets-path="../assets/" data-template="vertical-menu-template-free">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
  <title>Logiciel de Gestion</title>
  <meta name="description" content="" />
  <link rel="icon" type="image/x-icon" href="../assets/img/favicon/favicon.ico" />
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Public+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="../assets/vendor/fonts/boxicons.css" />
  <link rel="stylesheet" href="../assets/vendor/css/core.css" class="template-customizer-core-css" />
  <link rel="stylesheet" href="../assets/vendor/css/theme-default.css" class="template-customizer-theme-css" />
  <link rel="stylesheet" href="../assets/css/demo.css" />
  <link rel="stylesheet" href="../assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />
  <link rel="stylesheet" href="../assets/vendor/libs/apex-charts/apex-charts.css" />
  <script src="../assets/vendor/js/helpers.js"></script>
  <script src="../assets/js/config.js"></script>
</head>

<body>
  <div class="layout-wrapper layout-content-navbar">
    <div class="layout-container">
      <?php require ('../nav/menu.php') ?>
      <div class="layout-page">
        <?php $title = 'Gestion de Stock'; require ('../nav/header.php'); ?>
        <div class="content-wrapper">
          <div class="container-xxl flex-grow-1 container-p-y">
            <div class="row">
              <div class="col-md-12">
                <div class="row">
                  <?php require ("liste_traitement.php"); ?>
                  <div class="col-md-4 col-12 mb-md-0 mb-4">
                    <div class="card">
                      <h5 class="card-header">Stock</h5>
                      <div class="card-body">
                        <form id="formAuthentication" class="mb-3" action="add.php" method="POST">
                          <div class="mb-3 form-password-toggle">
                            <label class="form-label" for="poisson">Selection Poisson</label>
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
                              </div>
                            </div>
                            <label class="form-label" for="qtt">Poid en Kg</label>
                            <div class="input-group input-group-merge">
                              <input type="text" class="form-control" name="qtt" placeholder="Enter weight in kg" required />
                            </div>
                            <label class="form-label" for="type">Mise en Carton/sac</label>
                            <div class="input-group input-group-merge">
                              <select name="type" class="form-control">
                                <option value="1">en Sac</option>
                                <option value="2">en Carton</option>
                              </select>
                            </div>
                            <label class="form-label" for="sac">Quantite</label>
                            <div class="input-group input-group-merge">
                              <input type="number" class="form-control" name="sac" placeholder="Enter quantity" required />
                            </div>
                          </div>
                          <button class="btn btn-primary d-grid w-100" type="submit">Ajouter</button>
                        </form>
                        <div class="modal fade" id="basicModal" tabindex="-1" aria-hidden="true">
                          <div class="modal-dialog" role="document">
                            <div class="modal-content">
                              <div class="modal-header">
                                <h5 class="modal-title">Ajout Poisson</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                              </div>
                              <form action="addp.php" method='POST'>
                                <div class="modal-body">
                                  <div class="mb-3">
                                    <label for="nameBasic" class="form-label">Nom</label>
                                    <input type="text" id="nameBasic" class="form-control" placeholder="Nom de Poisson" name="nom" required />
                                  </div>
                                </div>
                                <div class="modal-footer">
                                  <button type="submit" class="btn btn-primary">Enregistrer</button>
                                </div>
                              </form>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
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
                              <?php require ('liste.php'); ?>
                            </tbody>
                          </table>
                        </div>
                        <div class="mt-3">
                          <p>Poid total: <?= $total_poid_all ?? 0 ?> kg</p>
                          <p>Nombre de sac: <?= $total_sac_all ?? 0 ?></p>
                          <p>Nombre de carton: <?= $total_carton_all ?? 0 ?></p>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="content-backdrop fade"></div>
        </div>
      </div>
    </div>
    <div class="layout-overlay layout-menu-toggle"></div>
  </div>
  <script src="../assets/vendor/libs/jquery/jquery.js"></script>
  <script src="../assets/vendor/libs/popper/popper.js"></script>
  <script src="../assets/vendor/js/bootstrap.js"></script>
  <script src="../assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>
  <script src="../assets/vendor/js/menu.js"></script>
  <script src="../assets/js/main.js"></script>
  <script async defer src="https://buttons.github.io/buttons.js"></script>
</body>

</html>
