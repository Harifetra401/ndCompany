<?php
// Obtenez la date d'aujourd'hui
$aujourdhui = new DateTime();
$day = clone $aujourdhui;

$niany = $day->modify('-1 day');
$niany = $niany->format('Y-m-d');
// Obtenez la date d'hier
$hier = $day->modify('-1 day');
$hier = $hier->format('Y-m-d');

// Obtenez la date d'avant-hier
$hier_1 = $day ->modify('-1 day');
$hier_1 = $hier_1 ->format('Y-m-d');

// Obtenez la date d'avant-hier -1
$hier_2 = $day ->modify('-1 day');
$hier_2 = $hier_2 ->format('Y-m-d');

// Obtenez la date d'avant-hier -2
$hier_3 = $day ->modify('-1 day');
$hier_3 = $hier_3 ->format('Y-m-d');

// Obtenez la date d'avant-hier -3
$hier_4 = $day ->modify('-1 day');
$hier_4 = $hier_4 ->format('Y-m-d');

// Obtenez la date d'avant-hier -4
$hier_5 = $day ->modify('-1 day');
$hier_5 = $hier_5 ->format('Y-m-d');

// Obtenez la date d'avant-hier -5
$hier_6 = $day ->modify('-1 day');
$hier_6 = $hier_6 ->format('Y-m-d');

// Clonez la date d'aujourd'hui pour obtenir la date du mois précédent
$month = clone $aujourdhui;

// Obtenez le mois et l'année actuel
$actuel = $month -> modify('0 month');
$mois_actuel = $actuel->format('m'); // Mois actuel
$annee_actuel = $actuel->format('Y'); // Année actuel

$precedent_1 = $month -> modify('-1 month');
$mois_precedent_1 = $precedent_1->format('m'); // Mois précédent
$annee_precedente_1 = $precedent_1->format('Y'); // Année précédente

$precedent_2 = $month -> modify('-1 month');
$mois_precedent_2 = $precedent_2->format('m'); // Mois précédent
$annee_precedente_2 = $precedent_2->format('Y'); // Année précédente

$precedent_3 = $month -> modify('-1 month');
$mois_precedent_3 = $precedent_3->format('m'); // Mois précédent
$annee_precedente_3 = $precedent_3->format('Y'); // Année précédente

$precedent_4 = $month -> modify('-1 month');
$mois_precedent_4 = $precedent_4->format('m'); // Mois précédent
$annee_precedente_4 = $precedent_4->format('Y'); // Année précédente

$precedent_5 = $month -> modify('-1 month');
$mois_precedent_5 = $precedent_5->format('m'); // Mois précédent
$annee_precedente_5 = $precedent_5->format('Y'); // Année précédente

$precedent_6 = $month -> modify('-1 month');
$mois_precedent_6 = $precedent_6->format('m'); // Mois précédent
$annee_precedente_6 = $precedent_6->format('Y'); // Année précédente

$precedent_7 = $month -> modify('-1 month');
$mois_precedent_7 = $precedent_7->format('m'); // Mois précédent
$annee_precedente_7 = $precedent_7->format('Y'); // Année précédente

$precedent_8 = $month -> modify('-1 month');
$mois_precedent_8 = $precedent_8->format('m'); // Mois précédent
$annee_precedente_8 = $precedent_8->format('Y'); // Année précédente

$precedent_9 = $month -> modify('-1 month');
$mois_precedent_9 = $precedent_9->format('m'); // Mois précédent
$annee_precedente_9 = $precedent_9->format('Y'); // Année précédente

$precedent_10 = $month -> modify('-1 month');
$mois_precedent_10 = $precedent_10->format('m'); // Mois précédent
$annee_precedente_10 = $precedent_10->format('Y'); // Année précédente

$precedent_11 = $month -> modify('-1 month');
$mois_precedent_11 = $precedent_11->format('m'); // Mois précédent
$annee_precedente_11 = $precedent_11->format('Y'); // Année précédente

?>

