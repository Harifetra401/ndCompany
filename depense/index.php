<?php
session_start();
// if ($_SESSION['username']!='Severin') {
//   ?>
//     // <script>
//     //   alert("Vous ne pouvez pas acceder a cette page, Merci de contacter Votre administrateur ");
//     //   window.location.href = "../html/index.php"; 

//     // </script>
//   <?php
   
// }
?>
<?php
// require ('../session.php');

require('data.php');
require('date.php');
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
            <center><h1 class="">
              <span class="text-muted fw-light"> </span> Flux Financiers
            </h1></center><br>

            <div class="row">
              <div class="col-md-6 col-12 mb-md-0 mb-6">
                <div class="card">
                  <center><h2 class="card-header">Crédit (Somme sortie)</h2></center>
                  <div class="card-body">
                     <form id="formAuthentication" class="mb-3" action="ajout.php" method="POST">
                      <div class="mb-3">
                        
                        <label class="form-label" for="libelle">Libelle</label>
                        <select name="libelle" class="form-control" required>
                          <option value="administration">ADMINISTRATION</option>
                          <option value="autorite">AUTORITE</option>
                          <option value="dpsprsls">DPS PRSNLS</option>
                          <option value="carburant">CARBURANT</option>
                          
                          <option value="emballage">EMBALLAGE</option>
                          <option value="jacky">JACKY</option>
                          <option value="tl">TL</option>
                          <option value="vedette">VEDETTE</option>
                          <option value="fraisdeplacement">FRAIS DEPLACEMENT</option>
                          <option value="materieldeproduit">MATERIEL DE PRODUIT</option>
                          <option value="chequier">CHEQUIER</option>
                          <option value="commission">COMMISSION</option>
                          <option value="livraisontana">LIVRAISON TANA</option>
                          <option value="ramassage">RAMASSAGE</option>
                          <option value="sortie">SORTIE</option>
                          <option value="fournisseurs">FOURNISSEURS</option>
                          <option value="appromateriel">APPRO MATERIEL</option>
                          <option value="coutdetraitement">COUT DE TRAITEMENT</option>
                          <option value="conservation">CONSERVATION</option>
                          <option value="loyer">LOYER</option>
                          <option value="immobilier">IMMOBILIER</option>
                        </select>

                      </div>
                      <div class="mb-3">
                        <label class="form-label" for="cout">Coût de Dépense (AR)</label>
                        <input type="number" class="form-control" name="cout" placeholder="Coût de Dépenses" required />
                      </div>
                      <div class="mb-3">
                        <label class="form-label" for="date">Date</label>
                        <input type="date" class="form-control" name="daty" required />
                      </div>
                      <div class="mb-3">
                        <label class="form-label" for="desc">Description</label>
                        <textarea name="desc" class="form-control" placeholder="Votre text ici"></textarea>
                      </div>
                      <div class="mb-3">
                        <button class="btn btn-primary d-grid w-100" type="submit">Ajouter</button>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
              
              <div class="col-md-6 col-12">
              
                <div class="card">
                  <center><h2 class="card-header">Débit (Somme Entrer)</h2></center>
                  <div class="card-body">
                    <form id="formAuthentication" class="mb-3" action="entrer.php" method="POST">
                      <div class="mb-3">
                        
                        <label class="form-label" for="libelle">Libelle</label>
                        <select name="libelle" class="form-control" required>
                          <option value=""></option>
                          <option value="CLIENTS LOCALE">CLIENTS LOCALE </option>
                          <option value="CHEQUIER">CHEQUIER</option>
                          <option value="VTE PRSNLS">VTE PRSNLS</option>
                          <option value="PATRONALE">PATRONALE</option>
                          <option value="COMPTABLE">COMPTABLE</option>
                          
                            
                            
                            


                        </select>
                      </div>
                      <div class="mb-3">
                        <label class="form-label" for="cout">Montant déposer (AR)</label>
                        <input type="number" class="form-control" name="cout" placeholder="Montant déposer (AR)" required />
                      </div>
                      <div class="mb-3">
                        <label class="form-label" for="date">Date</label>
                        <input type="date" class="form-control" name="daty" required />
                      </div>
                      <div class="mb-3">
                        <label class="form-label" for="desc">Description</label>
                        <textarea name="desc" class="form-control" placeholder="Votre text ici"></textarea>
                      </div>
                      <div class="mb-3">
                        <button class="btn btn-primary d-grid w-100" type="submit">Ajouter</button>
                      </div>
                    </form>
                  </div>
                </div>
              </div>


            </div>
            <br><br><br>
            <div class="container">
              <div class="col-md-12 col-12 mb-md-0 mb-12">
                  <div class="card">

                          <?php require ('liste.php') ?>
                       
                    </div>
                  </div>
                </div>
              </div>
              </div>
             <div class="container">
              <div class="col-md-12 col-12 mb-md-0 mb-12">
                <div class="card">

                        <?php require ('listeEntrer.php') ?>
                        
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

  <script>
    let sem = ["Dimanche", "Lundi", "Mardi", "Mercredi", "Jeudi", "Vendredi", "Samedi"];
    let year = ["Janvier", "Février", "Mars", "Avril", "Mai", "Juin", "Juillet", "Août", "Septembre", "Octobre", "Novembre", "Décembre"];
    var date = new Date();

    function get_month(sous) {
      let code = (date.getMonth() - sous);
      code = code < 0 ? 12 + code : code;
      return code;
    }

     // diagramme pour chaque annee
    var ctx = document.getElementById("myChartYear").getContext("2d");
    var myChartYear = new Chart(ctx, {
      type: "bar",
      data: {
        labels: [

          year[get_month(0)],
        ],
        datasets: [{
            label: "Credit (MGA)",
            data: [

              <?= get_depense_month($mois_actuel, $annee_actuel) ?>,
            ],
            
            backgroundColor: "rgba(255,0,0,0.6)",
          },{
            label: "DEBIT en (MGA)",
            data: [

              <?= get_entrer($mois_actuel, $annee_actuel) ?>,
            ],
            
            backgroundColor: "rgba(255,0,0)",
          },
          
          {
            label: "Vente Local (MGA)",
            data: [

              <?= get_particulier_month($mois_actuel, $annee_actuel) ?>,
            ],
            
            backgroundColor: "rgba(0,0,0,0.6)",
          },{
            label: "Dépense Ordinaire (MGA)",
            data: [

              <?= get_depense_month_by_class1($mois_actuel, $annee_actuel) ?>,
            ],
            
            backgroundColor: "rgba(150,255,0,0.6)",
          },{
            label: "Coûts sur Produits(MGA)",
            data: [

              <?= get_depense_month_by_class2($mois_actuel, $annee_actuel) ?>,
            ],
            
            backgroundColor: "rgba(150,0,0,0.6)",
          },{
            type: "line",
            label: "Dépense Trasport (MGA)",
            data: [

              <?= get_depense_month_by_class3($mois_actuel, $annee_actuel) ?>,
            ],
            
            backgroundColor: "rgba(200,0,100,0.6)",
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