<?php
require('../db.php');
require('../facture/prix_one_facture.php');

// Function to get the supplier's name based on id_fou
function get_name($id_fou)
{
    require('../db.php');
    $new_sql = "SELECT nomfournisseur FROM fournisseur WHERE id = :id_fou";
    $new_st = $db->prepare($new_sql);
    $new_st->bindParam(':id_fou', $id_fou, PDO::PARAM_INT);
    $new_st->execute();
    $fetch_name = $new_st->fetch();
    return $fetch_name ? $fetch_name["nomfournisseur"] : '';
}

function poid_total($num_fact) {
    require('../db.php');
    $total = 0;
    $selection = $db->prepare("SELECT qtt FROM detailfilao WHERE NumFac=:num_fact");
    $selection->bindParam(':num_fact', $num_fact, PDO::PARAM_INT);
    $selection->execute();
    $fetchAll = $selection->fetchAll();

    foreach($fetchAll as $fetch){
        $qtt_poisson = $fetch['qtt'];
        $total += ($qtt_poisson);
    }
    return $total;
}

// Get the dates from the form submission and sanitize them
$start_date = isset($_GET['start_date']) ? htmlspecialchars($_GET['start_date']) : date('Y-m-d');


// Adjust the query based on the selected dates
$sql = "SELECT * FROM facture WHERE date = :start_date ";
$stmt = $db->prepare($sql);
$stmt->bindParam(':start_date', $start_date, PDO::PARAM_STR);

$stmt->execute();
$all_facture = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Group the data by supplier
$grouped_data = [];
$poidsjiab = 0;

foreach ($all_facture as $facture) {
    $fournisseur_name = get_name($facture['id_fou']);
    $poids = poid_total($facture['id']);

    if (!isset($grouped_data[$fournisseur_name])) {
        $grouped_data[$fournisseur_name] = 0;
    }

    $grouped_data[$fournisseur_name] += $poids;
    $poidsjiab += $poids; // Total poids
}
?>
<!DOCTYPE html>
<html lang="en" class="light-style layout-menu-fixed" dir="ltr" data-theme="theme-default" data-assets-path="../assets/" data-template="vertical-menu-template-free">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
  <title>Collect</title>
  <meta name="description" content="" />
  <link rel="icon" type="image/x-icon" href="../assets/img/favicon/favicon.ico" />
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="../assets/vendor/fonts/boxicons.css" />
  <link rel="stylesheet" href="../assets/vendor/css/core.css" class="template-customizer-core-css" />
  <link rel="stylesheet" href="../assets/vendor/css/theme-default.css" class="template-customizer-theme-css" />
  <link rel="stylesheet" href="../assets/css/demo.css" />
  <link rel="stylesheet" href="../assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />
  <script src="../assets/vendor/js/helpers.js"></script>
  <script src="../assets/js/config.js"></script>
</head>

<body>
  <div class="layout-wrapper layout-content-navbar">
    <div class="layout-container">
      <?php require ('../nav/menu.php'); ?>
      <div class="layout-page">
        <?php require ('../nav/header.php'); ?> 
        <div class="content-wrapper">
          <div class="container-xxl flex-grow-1 container-p-y">
            <style>
                .table-hover tbody tr:hover { background-color: #f9f9f9; }
                .table th, .table td { vertical-align: middle; text-align: center; }
                .table thead th { background-color: #343a40; color: #fff; border-bottom: 2px solid #dee2e6; }
                .custom-select { width: 200px; display: inline-block; }
                .btn-filter { background-color: #007bff; color: white; padding: 5px 10px; cursor: pointer; border-radius: 4px; }
                .btn-filter:hover { background-color: #0056b3; }
                .total-row { font-weight: bold; background-color: #e9ecef; }
            </style>
            <div class="container mt-5">
              <div class="card">
                <br><br>
                <center><h2 class="mb-4">Achat Par Jour</h2></center>
                <br>
                <table>
                    <tr>
                        <td>
                            <form method="GET" action="">
                                <div class="form-group">
                                    <input type="date" id="start_date" name="start_date" class="form-control" value="<?= isset($_GET['start_date']) ? htmlspecialchars($_GET['start_date']) : date('Y-m-d') ?>">
                                </div>
                        </td>
                        <td>
                                <button type="submit" class="btn btn-primary">Filtrer Par Date</button>
                            </form>
                        </td>
                    </tr>
                </table>
                
                   
                <br>
                <button class="btn btn-success w-50" onclick="exporterTableauEnCSV('tableau.csv')">Exporter en CSV</button>
                <br><br>
                <table class="table table-bordered">
                  <thead class="thead-dark">
                    <tr>
                      <th scope="col">Nom Fournisseur</th>
                      <th scope="col">Poids Total</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php foreach ($grouped_data as $fournisseur => $poids_total): ?>
                      <?php if ($poids_total > 0): ?>
                        <tr>
                          <td><?= htmlspecialchars($fournisseur) ?></td>
                          <td><?= htmlspecialchars(number_format($poids_total, 2, ',', ' ')) ?></td>
                        </tr>
                      <?php endif; ?>
                    <?php endforeach; ?>
                  </tbody>
                  <thead class="thead-dark">
                    <tr>
                      <th scope="col">TOTAL</th>
                      <th scope="col"><?= number_format($poidsjiab, 2, ',', ' ') ?></th>
                    </tr>
                  </thead>
                </table>
              </div>
            </div>
            <div class="content-backdrop fade"></div>
          </div>
        </div>
      </div>
      <div class="layout-overlay layout-menu-toggle"></div>
    </div>
  </div>
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
