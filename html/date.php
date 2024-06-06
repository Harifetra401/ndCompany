<?php
// Obtenez la date d'aujourd'hui
$aujourdhui = new DateTime();
$day = clone $aujourdhui;

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
?>

