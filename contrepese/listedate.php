<?php
require ('../db.php');
require ('../facture/prix_one_facture.php');
require ('../facture/poid_one_facture.php');

function get_name($id_to_get)
{
    require ('../db.php');
    $new_sql = "SELECT * FROM fournisseur WHERE id = :id";
    $new_st = $db->prepare($new_sql);
    $new_st->bindParam(':id', $id_to_get, PDO::PARAM_INT);
    $new_st->execute();
    $fetch_name = $new_st->fetch();
    return $fetch_name["nomfournisseur"];
}

// Adjust the query to group by id_fou and date
$sql = "SELECT  date, COUNT(id) as total_count FROM facture GROUP BY  date ORDER BY date DESC";

$stmt = $db->prepare($sql);
$stmt->execute();
$all_facture = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="container mt-5">
    <h2 class="mb-4">Liste des Factures</h2>

    <!-- Table -->
    <table class="table table-bordered">
        <thead class="thead-dark">
            <tr>
                
                <th scope="col">Date</th>
                <th scope="col">Nombre Total</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($all_facture as $get_fact): ?>
                <tr>

                    <td><?= $get_fact['date'] ?></td>
                    <td><?= $get_fact['total_count'] ?> Facture</td>
                    <td><a href='traitement.php?date=<?= $get_fact['date'] ?>' class="btn btn-success">voir</a></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
