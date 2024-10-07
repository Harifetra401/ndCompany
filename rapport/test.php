<?php
// Inclure la connexion à la base de données
require('../db.php');

// Vérifiez si le mois et l'année sont définis, sinon utiliser le mois et l'année courants
$month = isset($_GET['month']) && is_numeric($_GET['month']) ? $_GET['month'] : date('m');
$year = isset($_GET['year']) && is_numeric($_GET['year']) ? $_GET['year'] : date('Y');

// Définir les dates de début et de fin pour le formulaire de filtrage
$startDate = isset($_GET['start_date']) ? $_GET['start_date'] : date('Y-m-01'); // Premier jour du mois courant
$endDate = isset($_GET['end_date']) ? $_GET['end_date'] : date('Y-m-t'); // Dernier jour du mois courant

// Requête SQL pour regrouper les articles par nom_poisson et additionner les poids et autres champs, avec filtre par mois et année
$sql = "SELECT ts.nom_poisson, SUM(ts.PEnter) AS total_PEnter, SUM(ts.qtt) AS total_qtt, ts.type, SUM(ts.sac) AS total_sac,
        SUM(dfs.qtt) AS qtt_sortie
        FROM testStock ts
        LEFT JOIN detailfilaosortie dfs ON ts.nom_poisson = dfs.id_poisson
        INNER JOIN facturesortie fs ON dfs.id_sortie = fs.id AND ts.EnterDate = fs.date
        WHERE 
         dfs.typ != 3
        GROUP BY ts.nom_poisson, ts.type";

$stmt = $db->prepare($sql);
$stmt->execute(['month' => $month, 'year' => $year]);
$stocks = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Calculer les totaux pour les poids, colis, et qtt_sortie
$totalWeight = 0;
$totalColis = 0;
$totalQttSortie = 0;

foreach ($stocks as $stock) {
    $totalWeight += $stock['total_qtt'];
    $totalColis += $stock['total_sac'];
    $totalQttSortie += $stock['qtt_sortie'];
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
  <title>Collect</title>

  <!-- Favicon -->
  <link rel="icon" type="image/x-icon" href="../assets/img/favicon/favicon.ico" />
  <!-- Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Public+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet" />

  <!-- Icons -->
  <link rel="stylesheet" href="../assets/vendor/fonts/boxicons.css" />

  <!-- Core CSS -->
  <link rel="stylesheet" href="../assets/vendor/css/core.css" class="template-customizer-core-css" />
  <link rel="stylesheet" href="../assets/vendor/css/theme-default.css" class="template-customizer-theme-css" />
  <link rel="stylesheet" href="../assets/css/demo.css" />

  <!-- Vendors CSS -->
  <link rel="stylesheet" href="../assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />

  <!-- Page CSS -->
  <script src="../dashboardata/chart.js"></script>
  <script src="../assets/vendor/js/helpers.js"></script>
  <script src="../assets/js/config.js"></script>
</head>
<body>
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
            <div class="card row">
              <div class="container mt-4">
                <!-- Formulaire de filtre entre deux dates -->
                <form method="GET" action="">
                  <div class="form-group">
                    <label for="start_date">Date de début :</label>
                    <input type="date" name="start_date" id="start_date" class="form-control" value="<?= htmlspecialchars($startDate) ?>">
                  </div>
                  <div class="form-group">
                    <label for="end_date">Date de fin :</label>
                    <input type="date" name="end_date" id="end_date" class="form-control" value="<?= htmlspecialchars($endDate) ?>">
                  </div>
                  <button type="submit" class="btn btn-primary mt-2">Filtrer</button>
                </form>
                <br>
                <button onclick="exporterTableauEnCSV('MiseEnSacde<?= $startDate ?>-<?= $endDate ?>.csv')" class='btn btn-success'>Exporter en Exel</button>

                <!-- Table d'affichage des stocks filtrés -->
                <table class="table table-bordered mt-3">
                  <thead>
                    <tr>
                      <th>Articles</th>
                      <th>Poids (kg)</th>
                      <th>Nbr colis</th>
                      <th>Qtt Sortie</th> <!-- Nouvelle colonne pour la quantité de detailfilaosortie -->
                    </tr>
                  </thead>
                  <tbody>
                    <?php if($stocks): ?>
                      <?php foreach ($stocks as $stock): ?>
                        <tr>
                          <td><?= htmlspecialchars($stock['nom_poisson']) ?></td>
                          <td><?= number_format((float)$stock['total_qtt'], 2, ',', ' ') ?></td>
                          <td><?= htmlspecialchars($stock['total_sac']) ?></td>
                          <td><?= number_format((float)$stock['qtt_sortie'], 2, ',', ' ') ?></td> <!-- Afficher qtt_sortie -->
                        </tr>
                      <?php endforeach; ?>
                      <!-- Ligne pour les totaux -->
                      <tr>
                        <th>Total</th>
                        <th><?= number_format((float)$totalWeight, 2, ',', ' ') ?> kg</th>
                        <th><?= htmlspecialchars($totalColis) ?></th>
                        <th><?= number_format((float)$totalQttSortie, 2, ',', ' ') ?></th>
                      </tr>
                    <?php else: ?>
                      <tr>
                        <td colspan="4" class="text-center">Aucun article trouvé pour cette période.</td>
                      </tr>
                    <?php endif; ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Core JS -->
  <script src="../assets/vendor/libs/jquery/jquery.js"></script>
  <script src="../assets/vendor/libs/popper/popper.js"></script>
  <script src="../assets/vendor/js/bootstrap.js"></script>
  <script src="../assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>
  <script src="../assets/vendor/js/menu.js"></script>
  <script src="../assets/js/main.js"></script>
  <script async defer src="https://buttons.github.io/buttons.js"></script>
  <script src="export.js"></script>
</body>
</html>
