<?php

$moisActuel = date("n");
$anneeActuelle = date("Y"); // Obtenez l'année en cours

// Gérez le cas particulier où le mois actuel est janvier
if ($moisActuel == 1) {
    $moisPrecedent = 12; // Le mois précédent est décembre
    $anneePrecedente = $anneeActuelle - 1; // L'année précédente
} else {
    $moisPrecedent = $moisActuel - 1;
    $anneePrecedente = $anneeActuelle;
}

$nombreDeJours = cal_days_in_month(CAL_GREGORIAN, $moisPrecedent, $anneePrecedente);
$jrtrav = $nombreDeJours - 2;
$htrav = 8 * $jrtrav;

// echo "Le mois précédent avait $nombreDeJours jours.";

if (!function_exists('pointage_precedant')) {
    function pointage_precedant($db, $id_selector, $annee, $mois, $jour)
    {
        $getBy = $db->prepare("SELECT * FROM present WHERE id_personnel = :id_personnel AND YEAR(date) = :annee AND MONTH(date) = :mois AND DAY(date) = :jour");
        $getBy->execute([
            'id_personnel' => $id_selector,
            'annee' => $annee,
            'mois' => $mois,
            'jour' => $jour
        ]);
        return $getBy->fetch(PDO::FETCH_ASSOC);
    }
}

if (!function_exists('pointage_precedantday')) {
    function pointage_precedantday($db, $id_selector, $annee, $mois)
    {
        $getBy = $db->prepare("SELECT COUNT(id_personnel) AS nbrjr FROM present WHERE id_personnel = :id_personnel AND YEAR(date) = :annee AND MONTH(date) = :mois");
        $getBy->execute([
            'id_personnel' => $id_selector,
            'annee' => $annee,
            'mois' => $mois
        ]);
        return $getBy->fetch(PDO::FETCH_ASSOC);
    }
}

if (!function_exists('total_heure_month')) {
    function total_heure_month($db, $id_selector, $mois)
    {
        $getBy = $db->prepare("SELECT SUM(TIME_TO_SEC(TIMEDIFF(fin, debut))/3600) AS total_heure FROM present WHERE id_personnel = :id_personnel AND MONTH(date) = :mois");
        $getBy->execute(['id_personnel' => $id_selector, 'mois' => $mois]);
        return $getBy->fetch(PDO::FETCH_ASSOC);
    }
}

// commenter cette car il est deja existe depuis le fichier liste_absent.php

require('../db.php');
$per = "SELECT * FROM personnel WHERE poste='Mahajanga' ORDER BY nom ASC";
$stmt_per = $db->prepare($per);
$stmt_per->execute();
$stmt_per_pre = $stmt_per->fetchAll(PDO::FETCH_ASSOC);

// Obtenez le nom complet du mois précédent
$nomMoisPrecedent = date("F", mktime(0, 0, 0, $moisPrecedent, 1, $anneePrecedente));

?>

<div class="container-fluid flex-grow-1 container-p-y col-md-12 col-lg-12 order-2 mb-12">
    <div class="card">
        <h5 class="card-header">Liste de suivis pendant le mois précédent (<?= htmlspecialchars($nomMoisPrecedent) ?>)</h5>
        <div class="table-responsive text-nowrap">
            <table class="table">
                <thead>
                    <tr class="text-nowrap">
                        <th>Nom</th>
                        <?php for ($i = 1; $i <= $nombreDeJours; $i++) : ?>
                            <th><?= htmlspecialchars($i) ?></th>
                        <?php endfor; ?>
                        <th>Heures de travail</th>
                        <th>Nombre de jours</th>
                        <th>Salaire</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($stmt_per_pre as $all_per) : ?>
                        <tr>
                            <td><?= htmlspecialchars($all_per['nom']) ?></td>
                            <?php for ($i = 1; $i <= $nombreDeJours; $i++) : ?>
                                <!-- si la date $i est avoir l'heure d'entrée alors marquer vert -->
                                <?php $pointage = pointage_precedant($db, $all_per['id'], $anneePrecedente, $moisPrecedent, $i); ?>
                                <?php if ($pointage && isset($pointage['debut'])) : ?>
                                    <td><?php require('icon/ico2.php') ?></td>
                                <?php else : ?>
                                    <!-- sinon marquer rouge -->
                                    <td><?php require('icon/ico.php') ?></td>
                                <?php endif ?>
                            <?php endfor; ?>
                            <?php $total_heure = total_heure_month($db, $all_per['id'], $moisPrecedent); ?>
                            <td><?= $total_heure && isset($total_heure['total_heure']) ? htmlspecialchars($total_heure['total_heure']) : '0' ?></td>
                            <?php $nbr_jours = pointage_precedantday($db, $all_per['id'], $anneePrecedente, $moisPrecedent); ?>
                            <td><?= $nbr_jours && isset($nbr_jours['nbrjr']) ? htmlspecialchars($nbr_jours['nbrjr']) : '0' ?></td>
                            <td>
                                <?php
                                $slr = $nbr_jours['nbrjr'] ?? 0;
                                if ($slr == $jrtrav) {
                                    $karama = 300000;
                                } elseif ($slr > $jrtrav) {
                                    $karama = 300000 + 10000 * ($slr - $jrtrav);
                                } elseif ($slr == 0) {
                                    $karama = 0;
                                } else {
                                    $karama = 300000 - 10000 * ($jrtrav - $slr);
                                }
                                echo htmlspecialchars($karama);
                                ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
    <!--/ Layout Demo -->
</div>
