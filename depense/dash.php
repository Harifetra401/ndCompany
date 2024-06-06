<!DOCTYPE html>
<?php 
  require('../session.php');

  function total_depense($jour, $mois, $annee) {
    require('../db.php');
    $getBy = $db -> prepare("SELECT id, libelle, cout, description, date, SUM(cout) AS total_cout FROM depence WHERE DAY(date) = $jour AND MONTH(date) = $mois AND YEAR(date) = $annee");
    $getBy -> execute();
    $fetchBy = $getBy -> fetch();
    return ($fetchBy);
}

    $jourActuel = date("d");
    $moisActuel = date("n"); // Obtenez le mois en cours (1 = janvier, 2 = février, etc.)
    $anneeActuelle = date("Y"); // Obtenez l'année en cours

    // Gérez le cas particulier où le mois actuel est janvier
    if ($moisActuel == 1) {
        $moisPrecedent = 12; // Le mois précédent est décembre
        $anneePrecedente = $anneeActuelle - 1; // L'année précédente
    } else {
        $moisPrecedent = $moisActuel - 1;
        $anneePrecedente = $anneeActuelle;
    }
    $nomMoisPrecedent = date("F", mktime(0, 0, 0, $moisPrecedent, 1, $anneePrecedente));
    $nomMoisActuel = date("F", mktime(0, 0, 0, $moisActuel, 1, $anneeActuelle));
    $nombreDeJours = cal_days_in_month(CAL_GREGORIAN, $moisPrecedent, $anneePrecedente);

    $sem = array();
    $donne = array();

    for($i=1 ; $i < $jourActuel; $i++) {
      array_push($sem, $i);
      array_push($donne ,total_depense($i, $moisActuel, $anneeActuelle)["total_cout"]|0);
    }

    $sem1 = array();
    $donne1 = array();

    for($i=1 ; $i <= $nombreDeJours; $i++) {
      array_push($sem1, $i);
      array_push($donne1 ,total_depense($i, $moisPrecedent, $anneePrecedente)["total_cout"]|0);
    }

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
    href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap" rel="stylesheet" />

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
      <?php require('../nav/menu.php');?>
      <!-- / Menu -->

      <!-- Layout container -->
      <div class="layout-page">

        <!-- Navbar -->
        <?php $title='Dashboard'?>
      <?php require('../nav/header.php')?>
        <!-- / Navbar -->

        <!-- Content wrapper -->
        <div class="content-wrapper">
          <!-- Content -->

          <div class="container-xxl flex-grow-1 container-p-y">

            <div class="row">

              <!-- Expense Overview -->
              
              <!--/ Expense Overview -->

              <!-- Transactions -->
              <div class="col-md-8 col-lg-8 order-0 mb-8">
                <div class="card h-100">
                  <div class="card-header d-flex align-items-center justify-content-between">
                    <h5 class="card-header">Dashboard de depense de cette mois (<?=$nomMoisActuel?>)</h5>

                  </div>
                  <div class="card-body">
                  <div>
                    <canvas id="myChart"></canvas>
                  </div>
                  </div>
                </div>
              </div>
              <!--/ Transactions -->

              <!-- Transactions2 -->
              <div class="col-md-8 col-lg-8 order-0 mb-8">
                <div class="card h-100">
                  <div class="card-header d-flex align-items-center justify-content-between">
                    <h5 class="card-header">Dashboard de depense du mois precedant (<?=$nomMoisPrecedent?>)</h5>

                  </div>
                  <div class="card-body">
                  <div>
                    <canvas id="myChart2"></canvas>
                  </div>
                  </div>
                </div>
              </div>
              <!--/ Transactions2 -->

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

  <script>
    const sem = <?=json_encode($sem)?>;
    const donne = <?=json_encode($donne)?>;
    console.log(sem);

    var ctx = document.getElementById("myChart").getContext("2d");
    var myChart = new Chart(ctx, {
      type: "bar",
      data: {
        labels: sem,
        datasets: [
          {
            label: "Depense effectué",
            data: donne,
            backgroundColor: "rgba(153,205,1,0.6)",
          },
        ],
      },

    });

    // tableau du mois precedant
    const sem1 = <?=json_encode($sem1)?>;
    const donne1 = <?=json_encode($donne1)?>;
    var ctx2 = document.getElementById("myChart2").getContext("2d");
    var myChart2 = new Chart(ctx2, {
      type: "bar",
      data: {
        labels: sem1,
        datasets: [
          {
            label: "Depense effectué",
            data: donne1,
            backgroundColor: "rgba(153,205,1,0.6)",
          },
        ],
      },

    });

  </script>
</body>

</html>