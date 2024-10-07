<?php
require('../db.php');
require('../facture/prix_one_facture.php');

// Fonction pour obtenir le nom du fournisseur
function get_name($id_to_get) {
    require('../db.php');
    $new_sql = "SELECT * FROM fournisseur WHERE id = :id";
    $new_st = $db->prepare($new_sql);
    $new_st->bindParam(':id', $id_to_get, PDO::PARAM_INT);
    $new_st->execute();
    $fetch_name = $new_st->fetch();
    return $fetch_name["nomfournisseur"];
}

// Fonction pour calculer le poids total
function poid_total($num_fact) {
    require('../db.php');
    $total = 0;
    $selection = $db->prepare("SELECT qtt FROM detailfilao WHERE NumFac = :num_fact");
    $selection->bindParam(':num_fact', $num_fact, PDO::PARAM_INT);
    $selection->execute();
    $fetchAll = $selection->fetchAll();

    foreach($fetchAll as $fetch){
        $qtt_poisson = $fetch['qtt'];
        $total += $qtt_poisson;
    }
    return $total;
}

// Fonction pour obtenir les factures et les regrouper par date
function get_factures($start_date, $end_date) {
    require('../db.php');
    setlocale(LC_TIME, 'fr_FR.UTF-8'); // S'assurer que les dates soient en français

    // Générer tous les jours de la plage de dates
    $start = new DateTime($start_date);
    $end = new DateTime($end_date);
    $interval = new DateInterval('P1D');
    $period = new DatePeriod($start, $interval, $end->modify('+1 day'));

    $date_data = [];
    foreach ($period as $date) {
        $date_data[$date->format('d/m/Y')] = 0; // Initialiser chaque jour à 0
    }

    $sql = "SELECT * FROM facture WHERE date BETWEEN :start_date AND :end_date ORDER BY date";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':start_date', $start_date, PDO::PARAM_STR);
    $stmt->bindParam(':end_date', $end_date, PDO::PARAM_STR);
    $stmt->execute();
    $all_facture = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Grouper les données par date et somme des poids
    foreach ($all_facture as $facture) {
        $date = strftime('%d/%m/%Y', strtotime($facture['date'])); // Formater la date en j/m/y
        $weight = poid_total($facture['id']);
        $date_data[$date] += $weight;
    }

    return $date_data;
}

// Récupérer la plage de dates depuis le formulaire
$start_date = isset($_POST['start_date']) ? $_POST['start_date'] : date('Y-m-01');
$end_date = isset($_POST['end_date']) ? $_POST['end_date'] : date('Y-m-t');

// Obtenir les factures regroupées par date
$date_data = get_factures($start_date, $end_date);

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Filter</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <h2 class="mb-4">Liste des Factures</h2>

    <form method="post" action="" class="">
        <div class="form-row">
            <div class="form-group col-md-5">
                <label for="start_date">Date de début</label>
                <input type="date" class="form-control" id="start_date" name="start_date" value="<?= htmlspecialchars($start_date) ?>">
            </div>
            <div class="form-group col-md-5">
                <label for="end_date">Date de fin</label>
                <input type="date" class="form-control" id="end_date" name="end_date" value="<?= htmlspecialchars($end_date) ?>">
            </div>
            <div class="form-group col-md-2">
                <button type="submit" class="btn btn-primary mt-4">Filtrer</button>
            </div>
        </div>
    </form>
 <button onclick="exporterTableauEnCSV('PoidsAchatParJour.csv')">Exporter en Exel</button>
    <!-- Tableau des factures -->
    <div>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Poids Total (KG)</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($date_data as $date => $weight): ?>
                    <tr>
                        <td><?= htmlspecialchars($date) ?></td>
                        <td><?= htmlspecialchars(number_format($weight, 2, ',', ' ')) ?></td> <!-- Conversion des points en virgules -->
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="export.js"></script>
</body>
</html>
