
<!DOCTYPE html>
<?php
session_start(); // Démarrer la session

// Vérifier si $_SESSION["nam




// Inclure les fichiers requis
//require ('../session.php');
// require ('../sessioncontrole.php');
require ('data.php');
require ('date.php');
function get_factures_data($start_date, $end_date) {
    require('../db.php');
    setlocale(LC_TIME, 'fr_FR.UTF-8'); // S'assurer que les dates soient en français

    $sql = "SELECT * FROM facture WHERE date BETWEEN :start_date AND :end_date ORDER BY date";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':start_date', $start_date, PDO::PARAM_STR);
    $stmt->bindParam(':end_date', $end_date, PDO::PARAM_STR);
    $stmt->execute();
    $all_facture = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $date_data = [];

    // Grouper les données par mois et somme des poids
    foreach ($all_facture as $facture) {
        $month = strftime('%B %Y', strtotime($facture['date'])); // Formater la date en "mois année"
        if (!isset($date_data[$month])) {
            $date_data[$month] = 0;
        }
        
        // Calculer le poids total pour chaque facture
        $selection = $db->prepare("SELECT qtt FROM detailfilao WHERE NumFac = :num_fact");
        $selection->bindParam(':num_fact', $facture['id'], PDO::PARAM_INT);
        $selection->execute();
        $fetchAll = $selection->fetchAll();

        $total = 0;
        foreach($fetchAll as $fetch){
            $qtt_poisson = $fetch['qtt'];
            $total += $qtt_poisson;
        }

        // Ajouter le poids total au mois correspondant
        $date_data[$month] += $total;
    }

    return $date_data;
}

// Récupérer la plage de dates depuis le formulaire
$start_date = isset($_POST['start_date']) ? $_POST['start_date'] : date('Y-01-01');
$end_date = isset($_POST['end_date']) ? $_POST['end_date'] : date('Y-12-31');

// Obtenir les factures regroupées par mois
$date_data = get_factures_data($start_date, $end_date);

// Préparer les données pour Chart.js
$months = array_keys($date_data);
$weights = array_values($date_data);
?>
?>

<html lang="en" class="light-style layout-menu-fixed" dir="ltr" data-theme="theme-default" data-assets-path="../assets/"
  data-template="vertical-menu-template-free">

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
      <?php require ('../nav/menu.php'); ?>
      <!-- / Menu -->

      <!-- Layout container -->
      <div class="layout-page">

        <!-- Navbar -->

        <?php require ('../nav/header.php'); ?> 
        <div class="content-wrapper">

          <div class="container-xxl flex-grow-1 container-p-y">
              <div class="row">
              <!-- Order Statistics -->

             <!-- <div class="col-md-6 col-lg-4 col-xl-4 order-1 mb-4">-->
             <!--     <div class="card h-100">-->
             <!--       <div class="card-body">-->
             <!--         <div class="d-flex justify-content-between flex-column mb-3">-->
             <!--           <div class="d-flex flex-column gap-0">-->
             <!--             <h3 class="card-title">Vente Congeler</h3>-->
             <!--             <p class="card-text">-->
                          
             <!--             </p>-->
             <!--           </div>-->
             <!--           <br>-->
             <!--           <style>-->
             <!--             .table {-->
             <!--               width: 100%;-->
             <!--             }-->
                        
             <!--             .th {-->
                            <!--width: 50%; /* Distribute the width evenly */-->
                            <!--text-align: center; /* Center the buttons */-->
             <!--             }-->
                        
             <!--             .btn {-->
                            <!--width: 100%; /* Make both buttons fill the width of their table cells */-->
                            <!--padding: 10px; /* Add some padding for better appearance */-->
             <!--             }-->
             <!--           </style>-->
             <!--         <table class='table'>-->
             <!--             <tr>-->
             <!--                 <th class='th'>-->
             <!--                     <button id='openMtn' class="btn btn-primary">Operation</button>-->
             <!--                 </th>-->
                              
             <!--             </tr>-->
             <!--         </table>-->
             <!--         </div>-->
             <!--       </div>-->
             <!--     </div>-->
             <!--</div>-->
             <div id="myModalvente" class="modal">
                    <div class="modal-content">
                        <span class="close">&times;</span>
                        <h2>Date de Sortie Tranche</h2>
                        <form>
                            <input type='date' name='date' class =' form-control'>
                            <input type='submit'>
                        </form>
                        
                    </div>
                </div>

              <div class="col-md-6 col-lg-6 col-xl-6 order-1 mb-6">
                <div class="card h-100">
                  <div class="card-body">
                    <div class="d-flex justify-content-between  flex-column mb-3">
                      
                      <div class="d-flex flex-column gap-0">
                      <h3>Tranche </h3>

                       
                      </div>
                      <br>
                      <style>
                          .table {
                            width: 100%;
                          }
                        
                          .th {
                            width: 50%; /* Distribute the width evenly */
                            text-align: center; /* Center the buttons */
                          }
                        
                          .btn {
                            width: 100%; /* Make both buttons fill the width of their table cells */
                            padding: 10px; /* Add some padding for better appearance */
                          }
                        </style>
                      <table class='table'>
                          <tr>
                              <th class='th'>
                                  <button id='openModalBtn' class="btn btn-primary">Operation</button>
                              </th>
                               
                          </tr>
                      </table>
                      
                      <div class="d-flex flex-column gap-0">
                        
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div id="myModal" class="modal">
                    <div class="modal-content">
                        <span class="close">&times;</span>
                        <h2>Date de Sortie Tranche</h2>
                        <form method='POST' action='sortie/datetranche.php'>
                            <input type='date' name='date' class =' form-control'>
                            <input type='submit'>
                        </form>
                        
                    </div>
                </div>
              <div class="col-md-6 col-lg-6 col-xl-6 order-1 mb-6">
                <div class="card h-100">
                  <div class="card-body">
                    <div class="d-flex justify-content-between  flex-column mb-3">
                     
                      
                      <div class="d-flex flex-column gap-0">
                      <h3>Melange</h3>
                       
                      </div>
                      <br>
                      <style>
                          .table {
                            width: 100%;
                          }
                        
                          .th {
                            width: 50%; /* Distribute the width evenly */
                            text-align: center; /* Center the buttons */
                          }
                        
                          .btn {
                            width: 100%; /* Make both buttons fill the width of their table cells */
                            padding: 10px; /* Add some padding for better appearance */
                          }
                        </style>
                      <table class='table'>
                          <tr>
                              <th class='th'>
                                  <a href="SortieMelange.php" id='optn' class="btn btn-primary">Operation</a>
                              </th>
                              
                          </tr>
                      </table>
                      <div class="d-flex flex-column gap-0">
                        
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div id="myModalm" class="modal">
                    <div class="modal-content">
                        <span class="close">&times;</span>
                        <h2>Date de Sortie Melange</h2>
                        <form>
                            <input type='date' class =' form-control'>
                        </form>
                        
                    </div>
                </div>
             <div id="myModalm" class="modal">
                <div class="modal-content">
                    <span class="close">&times;</span>
                    <h2>Date de Sortie Melange</h2>
                    <form>
                        <input type="date" class="form-control">
                    </form>
                </div>
            </div>
            </div>
              <!--/ Order Statistics -->


             
              <!--/ Layout Demo -->


            </div>

            <div class="row">
              <!-- Order Statistics -->

              <div class="container-fluid col-md-6 col-lg-4 col-xl-4 order-1 mb-4">
                <div class="card h-100">
                  <div class="card-body">
                    <div class="d-flex justify-content-between  flex-column mb-3">
                      <h1>Entrer Stock</h1>
                      <canvas class="d-flex flex-column align-items-center gap-0" id="myChart2"
                        style="display: block; width: 100%; height: 150px;">
                      </canvas>
                      <div class="d-flex flex-column gap-0">
                        
                      </div>
                      <div class="d-flex flex-column gap-0">
                        <h3 class="mb-2"><?= (get_all(1)[0] - get_sortie(1)[0]) ?> Kg :
                        <?= get_all(1)[1] - get_sortie(1)[1] - get_sortieStock(1)[1]  ?> Colis
                        </h3>
                        <span>Poids total interne</span>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
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
              <div class="container-fluid col-md-8 col-lg-8 order-0 mb-8">
                <div class="card h-100">
                  <div class="card-header d-flex align-items-center justify-content-between">
                    <h5 class="card-title m-0 me-2">Diagramme </h5>
                  </div>
                  <div class="card-body">
                    <div>
                        
                            <canvas id="factureChart"></canvas>
                        
                    </div>
                  </div>
                </div>
              </div>
              <!--/ Transactions -->
              <!--<div class="container-fluid flex-grow-1 container-p-y col-md-8 col-lg-8 order-3 mb-8">-->

              <!--  <div class="card h-100">-->
              <!--    <div class="card-header d-flex align-items-center justify-content-between">-->
              <!--      <h5 class="card-title m-0 me-2">Diagramme </h5>-->
              <!--    </div>-->
              <!--    <div class="card-body">-->
              <!--      <div>-->
              <!--        <canvas id="myChartYear"></canvas>-->
              <!--      </div>-->
              <!--    </div>-->
              <!--  </div>-->

              <!--</div>-->
              <!--/ Layout Demo -->
                
              <?php require ('liste_facture.php'); ?>
              <?php require ('liste_chargement.php'); ?>
              <?php require ('liste_stock.php'); ?>
             
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
<style>
        /* Style de base pour masquer le modal */
    .modal {
        display: none; 
        position: fixed; 
         
        left: 0;
        top: 0;
        width: 100%; 
        height: 100%; 
        background-color: rgba(0, 0, 0, 0.4);
    }
    
    /* Contenu du modal */
    .modal-content {
        background-color: #fefefe;
        margin: 10% auto; 
        padding: 20px;
        border: 1px solid #888;
        width: 80%; 
        max-width: 600px; /* Largeur maximum */
        box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
        animation-name: animatetop;
        animation-duration: 0.4s;
        border-radius: 10px;
    }
    
    /* Animation */
    @keyframes animatetop {
        from { top: -50px; opacity: 0; }
        to { top: 0; opacity: 1; }
    }
    
    /* Bouton de fermeture */
    .close {
        color: #aaa;
        float: right;
        font-size: 28px;
        font-weight: bold;
    }
    
    .close:hover,
    .close:focus {
        color: black;
        text-decoration: none;
        cursor: pointer;
    }
    
    /* Responsiveness pour petits écrans */
    @media screen and (max-width: 768px) {
        .modal-content {
            width: 95%; /* Réduit la largeur sur les petits écrans */
        }
    }

</style>

  <!-- / Layout wrapper -->
    <script>
        // Ouvre le modal
        let modal = document.getElementById("myModal");
        let btn = document.getElementById("openModalBtn");
        let span = document.getElementsByClassName("close")[0];
        
        btn.onclick = function() {
            modal.style.display = "block";
        }
        
        // Ferme le modal quand on clique sur "x"
        span.onclick = function() {
            modal.style.display = "none";
        }
        
        // Ferme le modal si l'utilisateur clique en dehors
        window.onclick = function(event) {
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }

    </script>
        <script>
        
            // Ouvre le modal
            let modal = document.getElementById("myModalm");
            let btn = document.getElementById("openModalBtnm");
            let span = document.getElementsByClassName("close")[0];
        
            btn.onclick = function() {
                modal.style.display = "block";
            }
        
            // Ferme le modal quand on clique sur "x"
            span.onclick = function() {
                modal.style.display = "none";
            }
        
            // Ferme le modal si l'utilisateur clique en dehors
            window.onclick = function(event) {
                if (event.target == modal) {
                    modal.style.display = "none";
                }
            }
        </script>
                
             
            </div>
        <script>
        // Ouvre le modal
        let modal = document.getElementById("myModalvente");
        let btn = document.getElementById("openModalBtnvente");
        let span = document.getElementsByClassName("close")[0];
        
        btn.onclick = function() {
            modal.style.display = "block";
        }
        
        // Ferme le modal quand on clique sur "x"
        span.onclick = function() {
            modal.style.display = "none";
        }
        
        // Ferme le modal si l'utilisateur clique en dehors
        window.onclick = function(event) {
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }

    </script>
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

    var ctx = document.getElementById("myChart").getContext("2d");
    var myChart = new Chart(ctx, {
      type: "bar",
      data: {
        labels: [
          sem[get_jour(6)],
          sem[get_jour(5)],
          sem[get_jour(4)],
          sem[get_jour(3)],
          sem[get_jour(2)],
          sem[get_jour(1)],
          sem[get_jour(0)],
        ],
        datasets: [{
          label: "Achat effectué",
          data: [
           
            <?= get_achat($hier_5) ?>,
            <?= get_achat($hier_4) ?>,
            <?= get_achat($hier_3) ?>,
            <?= get_achat($hier_2) ?>,
            <?= get_achat($hier_1) ?>,
            <?= get_achat($hier) ?>,
            <?= get_achat_aujourd($niany) ?>


          ],
          backgroundColor: "rgba(153,205,1,0.6)",
        },
        {
          label: "vente Local",
          data: [
            <?= get_particulier($hier_6) ?>,
            <?= get_particulier($hier_5) ?>,
            <?= get_particulier($hier_4) ?>,
            <?= get_particulier($hier_3) ?>,
            <?= get_particulier($hier_2) ?>,
            <?= get_particulier($hier_1) ?>,
            <?= get_particulier($hier) ?>,
          ],
          backgroundColor: "rgba(155,153,10,0.6)",
        },
        ],
      },
    });

    var ctx2 = document.getElementById("myChart2").getContext("2d");
    var stockexterne = <?= get_all(2)[1] - get_sortie(2)[1] - get_sortieStock(2)[1] ?>;
    var stockinterne = <?= get_all(1)[1] - get_sortie(1)[1] - get_sortieStock(1)[1]  ?>;
    var myChart2 = new Chart(ctx2, {
      type: "pie",
      data: {
        labels: ["externe", "interne"],
        datasets: [{
          label: "work load",
          data: [stockexterne, stockinterne],
          backgroundColor: ['rgb(255, 99, 132)', 'rgb(54, 162, 235)'],
        }],
      },
    });


    var ctx = document.getElementById("myChartYear").getContext("2d");
    var myChartYear = new Chart(ctx, {
      type: "bar",
      data: {
        labels: [
          year[get_month(11)],
          year[get_month(10)],
          year[get_month(9)],
          year[get_month(8)],
          year[get_month(7)],
          year[get_month(6)],
          year[get_month(5)],
          year[get_month(4)],
          year[get_month(3)],
          year[get_month(2)],
          year[get_month(1)],
          year[get_month(0)],
        ],
        datasets: [{
          label: "Vente Local  <?= get_particulier_month($mois_actuel, $annee_actuel) ?>  Kg",
          data: [
            <?= get_particulier_month($mois_precedent_11, $annee_precedente_11) ?>,
            <?= get_particulier_month($mois_precedent_10, $annee_precedente_10) ?>,
            <?= get_particulier_month($mois_precedent_9, $annee_precedente_9) ?>,
            <?= get_particulier_month($mois_precedent_8, $annee_precedente_8) ?>,
            <?= get_particulier_month($mois_precedent_7, $annee_precedente_7) ?>,
            <?= get_particulier_month($mois_precedent_6, $annee_precedente_6) ?>,
            <?= get_particulier_month($mois_precedent_5, $annee_precedente_5) ?>,
            <?= get_particulier_month($mois_precedent_4, $annee_precedente_4) ?>,
            <?= get_particulier_month($mois_precedent_3, $annee_precedente_3) ?>,
            <?= get_particulier_month($mois_precedent_2, $annee_precedente_2) ?>,
            <?= get_particulier_month($mois_precedent_1, $annee_precedente_1) ?>,
            <?= get_particulier_month($mois_actuel, $annee_actuel) ?>,
          ],

          backgroundColor: "rgba(255,0,0,0.6)",
        }, {
          label: "Achat  <?= get_achat_month($mois_actuel, $annee_actuel) ?> kg",
          data: [
            <?= get_achat_month($mois_precedent_11, $annee_precedente_11) ?>,
            <?= get_achat_month($mois_precedent_10, $annee_precedente_10) ?>,
            <?= get_achat_month($mois_precedent_9, $annee_precedente_9) ?>,
            <?= get_achat_month($mois_precedent_8, $annee_precedente_8) ?>,
            <?= get_achat_month($mois_precedent_7, $annee_precedente_7) ?>,
            <?= get_achat_month($mois_precedent_6, $annee_precedente_6) ?>,
            <?= get_achat_month($mois_precedent_5, $annee_precedente_5) ?>,
            <?= get_achat_month($mois_precedent_4, $annee_precedente_4) ?>,
            <?= get_achat_month($mois_precedent_3, $annee_precedente_3) ?>,
            <?= get_achat_month($mois_precedent_2, $annee_precedente_2) ?>,
            <?= get_achat_month($mois_precedent_1, $annee_precedente_1) ?>,
            <?= get_achat_month($mois_actuel, $annee_actuel) ?>,
          ],

          backgroundColor: "rgba(0,0,0,0.6)",
        }
        ],
      },
    });
  </script>
  <script>
    document.addEventListener('DOMContentLoaded', function () {
        const ctx = document.getElementById('factureChart').getContext('2d');

        // Détecter la largeur de l'écran et ajuster le type de graphique en conséquence
        const screenWidth = window.innerWidth;
        const chartType = screenWidth < 800 ? 'horizontalBar' : 'bar';

        const factureChart = new Chart(ctx, {
            type: chartType,
            data: {
                labels: <?= json_encode($months) ?>,
                datasets: [{
                    label: 'Poids Total (KG)',
                    data: <?= json_encode($weights) ?>,
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    });
</script>

  <!-- Core JS -->
  <!-- build:js assets/vendor/js/core.js -->
  <script src="../assets/vendor/libs/jquery/jquery.js"></script>
  <script src="../assets/vendor/libs/popper/popper.js"></script>
  <script src="../assets/vendor/js/bootstrap.js"></script>
  <script src="../assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>
  <script src="../assets/vendor/js/menu.js"></script>
  <script src="../assets/js/main.js"></script>
  <script async defer src="https://buttons.github.io/buttons.js"></script>