<?php
// Inclure la connexion à la base de données
require('../db.php'); 

// Récupération des paramètres de filtre mois et année
$month = isset($_GET['month']) ? $_GET['month'] : '';
$year = isset($_GET['year']) ? $_GET['year'] : '';
$id_sortie = isset($_GET['id']) ? $_GET['id'] : '';

// Requête SQL pour obtenir les factures en fonction des filtres
$sql = "
    SELECT *
    FROM facturesortie
    WHERE id = :id_sortie";  // On commence par filtrer selon l'id_sortie

// Ajout de conditions dynamiques pour le mois et l'année
$params = [':id_sortie' => $id_sortie];

if (!empty($month)) {
    $sql .= " AND MONTH(date) = :month";
    $params[':month'] = $month;
}

if (!empty($year)) {
    $sql .= " AND YEAR(date) = :year";
    $params[':year'] = $year;
}

// Préparer et exécuter la requête
$stmt = $db->prepare($sql);
$stmt->execute($params);
$factures = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Filtrage des Factures</title>
    <!-- Inclure ici vos styles CSS et autres ressources -->
</head>
<body>
    <h1>Filtrage des Factures par Mois et Année</h1>

    <!-- Formulaire de filtrage par mois et année -->
    <form method="GET" action="">
        <input type="hidden" name="id" value="<?= htmlspecialchars($id_sortie) ?>">

        <label for="month">Mois :</label>
        <select name="month" id="month">
            <option value="">Tous</option>
            <?php
            for ($m = 1; $m <= 12; $m++) {
                $month_value = str_pad($m, 2, '0', STR_PAD_LEFT);
                $selected = ($month == $month_value) ? 'selected' : '';
                echo "<option value='$month_value' $selected>" . date('F', mktime(0, 0, 0, $m, 1)) . "</option>";
            }
            ?>
        </select>

        <label for="year">Année :</label>
        <select name="year" id="year">
            <option value="">Tous</option>
            <?php
            $currentYear = date('Y');
            for ($y = $currentYear; $y >= $currentYear - 10; $y--) {
                $selected = ($year == $y) ? 'selected' : '';
                echo "<option value='$y' $selected>$y</option>";
            }
            ?>
        </select>

        <button type="submit">Filtrer</button>
    </form>

    <!-- Affichage des résultats filtrés -->
    <h2>Résultats</h2>
    <table border="1">
        <thead>
            <tr>
                <th>ID</th>
                <th>Date</th>
                <th>Quantité</th>
                <th>Prix</th>
                <th>ID Sortie</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($factures)): ?>
                <?php foreach ($factures as $facture): ?>
                    <tr>
                        <td><?= htmlspecialchars($facture['id']) ?></td>
                        <td><?= htmlspecialchars($facture['date']) ?></td>
                        <td><?= htmlspecialchars($facture['qtt']) ?></td>
                        <td><?= htmlspecialchars($facture['prix']) ?></td>
                        <td><?= htmlspecialchars($facture['id_sortie']) ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="5">Aucun enregistrement trouvé.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</body>
</html>
