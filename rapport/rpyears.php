<?php
require('../db.php');
require('../facture/prix_one_facture.php');

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

<!DOCTYPE html>
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

<div class="container mt-5">
    <h2 class="mb-4">Poids Total par mois</h2>

    <!-- Chart Container -->
    <div>
        <canvas id="factureChart"></canvas>
    </div>
</div>

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

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
