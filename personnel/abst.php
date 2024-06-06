<?php

// obtenir le jour actuel
$jourActuel = date("d");

// Définir la connexion à la base de données
require('../db.php');

// Assuming $ville is defined or passed into the script. Example:
// $ville = 'SomeVille';
if (!isset($ville)) {
    $ville = 'DefaultVille'; // Or fetch it from request parameters or another source
}

function pointage($db, $id_selector, $jour)
{
    $getBy = $db->prepare("SELECT * FROM present WHERE id_personnel = :id_personnel AND YEAR(date) = YEAR(CURDATE()) AND MONTH(date) = MONTH(CURDATE()) AND DAY(date) = :jour");
    $getBy->execute(['id_personnel' => $id_selector, 'jour' => $jour]);
    return $getBy->fetch(PDO::FETCH_ASSOC);
}

function total_heure_month($db, $id_selector, $mois)
{
    $getBy = $db->prepare("SELECT id, id_personnel, SUM(TIME_TO_SEC(TIMEDIFF(fin, debut))/3600) AS total_heure FROM present WHERE id_personnel = :id_personnel AND MONTH(date) = :mois");
    $getBy->execute(['id_personnel' => $id_selector, 'mois' => $mois]);
    return $getBy->fetch(PDO::FETCH_ASSOC);
}

$per = "SELECT * FROM personnel WHERE poste = :poste ORDER BY nom ASC";
$stmt_per = $db->prepare($per);
$stmt_per->execute(['poste' => $ville]);

$stmt_per_pre = $stmt_per->fetchAll(PDO::FETCH_ASSOC);

?>

<div class="container-fluid flex-grow-1 container-p-y col-md-12 col-lg-12 order-2 mb-12">
    <div class="card">
        <h5 class="card-header">Liste de suivis pendant ce mois</h5>
        <div class="table-responsive text-nowrap">
            <table class="table">
                <thead>
                    <tr class="text-nowrap">
                        <th>Nom</th>
                        <?php for ($i = 1; $i <= $jourActuel; $i++) : ?>
                            <th><?= htmlspecialchars($i) ?></th>
                        <?php endfor; ?>
                        <th>Total heure</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($stmt_per_pre as $all_per) : ?>
                        <tr>
                            <td><?= htmlspecialchars($all_per['nom']) ?></td>
                            <?php for ($i = 1; $i <= $jourActuel; $i++) : ?>
                                <!-- si la date $i est avoir l'heure d'entrée alors marquer vert -->
                                <?php
                                $pointage = pointage($db, $all_per['id'], $i);
                                if ($pointage && isset($pointage['debut'])) :
                                ?>
                                    <td><?php require('icon/ico2.php') ?></td>
                                <?php else : ?>
                                    <!-- sinon marquer rouge -->
                                    <td><?php require('icon/ico.php') ?></td>
                                <?php endif ?>
                            <?php endfor; ?>
                            <?php
                            $total_heure = total_heure_month($db, $all_per['id'], date("n"));
                            ?>
                            <td><?= $total_heure && isset($total_heure['total_heure']) ? htmlspecialchars($total_heure['total_heure']) : '0' ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
    <!--/ Layout Demo -->
</div>
