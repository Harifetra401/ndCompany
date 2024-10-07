<?php
require('../db.php');
require('prix_one_facture.php');
require('poid_one_facture.php');

function get_name($id_to_get)
{
    require('../db.php');
    $new_sql = "SELECT * FROM fournisseur WHERE id = :id";
    $new_st = $db->prepare($new_sql);
    $new_st->bindParam(':id', $id_to_get, PDO::PARAM_INT);
    $new_st->execute();
    $fetch_name = $new_st->fetch();
    return $fetch_name["nomfournisseur"];
}

// Get the date from the form submission and sanitize it
$date = isset($_GET['date']) ? htmlspecialchars($_GET['date']) : '';

// Adjust the query based on the provided date
$sql = "SELECT * FROM facture WHERE date = :date ORDER BY id DESC";

$stmt = $db->prepare($sql);
$stmt->bindParam(':date', $date, PDO::PARAM_STR);

$stmt->execute();
$all_facture = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!-- <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des Factures</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body> -->
<div class="container mt-5">
    <h2 class="mb-4">Liste des Factures</h2>

    <!-- Table -->
    <table class="table table-bordered">
        <thead class="thead-dark">
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Nom Fournisseur</th>
                <th scope="col">Poids Total</th>
                <th scope="col">Date</th>
                <th scope="col">Nombre Total</th>
                <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($all_facture as $get_fact):
                if (poid_total($get_fact['id']) > 0) { ?>
                    <tr>
                        <th scope="row"><?= htmlspecialchars($get_fact['id']) ?></th>
                        <td><?= htmlspecialchars(get_name($get_fact['id_fou'])) ?></td>
                        <td><?= htmlspecialchars(poid_total($get_fact['id'])) ?> KG</td>
                        <td><?= htmlspecialchars($get_fact['date']) ?></td>
                        <td><?= htmlspecialchars(nbr_total($get_fact['id'])) ?></td>
                        <td>
                            <a class="btn btn-success" href="../contrepese/traitement.php?num=<?= htmlspecialchars($get_fact['id']) ?>&frnss=<?= htmlspecialchars(get_name($get_fact['id_fou'])) ?>">
                                Traiter
                            </a>
                        </td>
                    </tr>
                <?php } endforeach; ?>
        </tbody>
    </table>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<!-- </body>
</html> -->
