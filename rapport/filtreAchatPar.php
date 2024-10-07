<?php
require_once('../db.php');

// Récupérer les fournisseurs depuis la base de données
$getFournisseurs = $db->prepare("SELECT id, nomfournisseur	 FROM fournisseur ORDER BY id ASC");
$getFournisseurs->execute();
$fournisseurs = $getFournisseurs->fetchAll(PDO::FETCH_ASSOC);

// Vérifier si un mois est sélectionné
$selectedMonth = isset($_POST['mois']) ? (int)$_POST['mois'] : date('m');
$selectedDay = isset($_POST['jour']) && !empty($_POST['jour']) ? (int)$_POST['jour'] : null;

// Vérifier si un fournisseur est sélectionné
$selectedIdFou = isset($_POST['id']) && !empty($_POST['id']) ? (int)$_POST['id'] : null;

// Construire la requête SQL avec filtres conditionnels
$sql = "
    SELECT detailfilao.*, facture.id 
    FROM detailfilao 
    INNER JOIN facture ON detailfilao.NumFac = facture.id 
    WHERE MONTH(facture.date) = :mois
";

if ($selectedIdFou !== null) {
    $sql .= " AND facture.id_fou = :id_fou";
}

if ($selectedDay !== null) {
    $sql .= " AND DAY(facture.date) = :jour";
}

$selection = $db->prepare($sql);
$selection->bindParam(':mois', $selectedMonth, PDO::PARAM_INT);

if ($selectedIdFou !== null) {
    $selection->bindParam(':id_fou', $selectedIdFou, PDO::PARAM_INT);
}

if ($selectedDay !== null) {
    $selection->bindParam(':jour', $selectedDay, PDO::PARAM_INT);
}

$selection->execute();
$fetchAll = $selection->fetchAll(PDO::FETCH_ASSOC);


// Préparer la requête pour obtenir le nom du poisson
$getBy = $db->prepare("SELECT nomFilao FROM poisson WHERE id = :id");

// Regrouper les poissons par ID
$poissons = [];
$totalQuantite = 0; // Initialiser la variable pour le total des quantités

foreach ($fetchAll as $fetch) {
    $poissonId = $fetch['id_poisson'];

    if (!isset($poissons[$poissonId])) {
        // Associer l'ID poisson et exécuter la requête pour obtenir le nom
        $getBy->bindParam(':id', $poissonId, PDO::PARAM_INT);
        $getBy->execute();
        $fetchBy = $getBy->fetch(PDO::FETCH_ASSOC);
        $poissons[$poissonId] = [
            'nom' => $fetchBy['nomFilao'],
            'qtt' => 0,
            'total' => 0
        ];
    }

    // Additionner la quantité et le prix total pour ce poisson
    $poissons[$poissonId]['qtt'] += $fetch['qtt'];
    $poissons[$poissonId]['total'] += ($fetch['qtt'] * $fetch['prixUnit']);

    // Ajouter la quantité à la somme totale
    $totalQuantite += $fetch['qtt'];
}

// Calcul du total général
$totalGeneral = 0;
?>

<!DOCTYPE html>
<html lang="fr" class="light-style layout-menu-fixed" dir="ltr" data-theme="theme-default" data-assets-path="../assets/" data-template="vertical-menu-template-free">
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

        <?php
        require ('../nav/header.php')
          ?> 
        <div class="content-wrapper">
          <div class="container-xxl flex-grow-1 container-p-y">

            <!-- Ajouter le style CSS pour le tableau -->
            <style>
                .table-hover tbody tr:hover {
                    background-color: #f9f9f9;
                }

                .table th, .table td {
                    vertical-align: middle;
                    text-align: center;
                }

                .table thead th {
                    background-color: #343a40;
                    color: #fff;
                    border-bottom: 2px solid #dee2e6;
                }

                .text-danger {
                    color: #dc3545 !important;
                }

                .custom-select {
                    width: 200px;
                    display: inline-block;
                }

                .btn-filter {
                    background-color: #007bff;
                    color: white;
                    border: none;
                    padding: 5px 10px;
                    cursor: pointer;
                    border-radius: 4px;
                }

                .btn-filter:hover {
                    background-color: #0056b3;
                }

                .total-row {
                    font-weight: bold;
                    background-color: #e9ecef;
                }
            </style>
            
            <!-- Formulaire de sélection du mois et du fournisseur -->
            <form method="post" action="" class="mb-4">
                <div class="form-group mb-2">
                    <label for="mois" class="mr-2">Sélectionner un mois :</label>
                    <select name="mois" id="mois" class="form-control custom-select mr-2 d-inline-block">
                        <?php for ($m = 1; $m <= 12; $m++): ?>
                            <option value="<?= $m ?>" <?= $m == $selectedMonth ? 'selected' : '' ?>>
                                <?= strftime('%B', mktime(0, 0, 0, $m, 10)) ?>
                            </option>
                        <?php endfor; ?>
                    </select>
                </div>
                <div class="form-group mb-2">
                    <label for="id_fou" class="mr-2">Sélectionner un fournisseur :</label>
                    <select name="id" id="id_fou" class="form-control custom-select mr-2 d-inline-block">
                        <option value="">Tous les fournisseurs</option>
                        <?php foreach ($fournisseurs as $fou): ?>
                            <option value="<?= htmlspecialchars($fou['id']) ?>" <?= ($fou['id'] == $selectedIdFou) ? 'selected' : '' ?>>
                                <?= htmlspecialchars($fou['nomfournisseur']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group mb-2">
                    <label for="jour" class="mr-2">Sélectionner un jour :</label>
                    <select name="jour" id="jour" class="form-control custom-select mr-2 d-inline-block">
                        <option value="">Tous les jours</option>
                        <?php for ($d = 1; $d <= 31; $d++): ?>
                            <option value="<?= $d ?>" <?= ($d == $selectedDay) ? 'selected' : '' ?>>
                                <?= $d ?>
                            </option>
                        <?php endfor; ?>
                    </select>
                </div>
                <button type="submit" class="btn-filter">Filtrer</button>
            </form>

            
            <!-- Bouton pour exporter en Excel (CSV) -->
            <button onclick="exporterTableauEnCSV('tableau.csv')" class="btn btn-success mb-3">Exporter en Excel</button>
            
            <!-- Tableau avec classes Bootstrap -->
            <table class="table table-bordered table-striped table-hover">
                <thead class="thead-light">
                    <tr>
                        <th>Poisson</th>
                        <th>Quantité</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($poissons as $poisson) {
                        $totalGeneral += $poisson['total'];
                        ?>
                
                        <tr>
                            <td><i class="fas fa-fish fa-lg text-info mr-3"></i> <strong><?= htmlspecialchars($poisson['nom']) ?></strong></td>
                            <td><?= htmlspecialchars($poisson['qtt']) ?></td>
                        </tr>
                
                        <?php
                    }
                    ?>
                </tbody>
                <tfoot>
                    <tr class="total-row">
                        <th class="text-right">Total Quantité :</th>
                        <th><?= htmlspecialchars($totalQuantite) ?></th>
                    </tr>
                </tfoot>
            </table>

          </div>
        </div>
      </div>
    </div>
    
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
<script src="../assets/js/main.js"></script>
<script src="export.js"></script>
<script async defer src="https://buttons.github.io/buttons.js"></script>
</body>
</html>
