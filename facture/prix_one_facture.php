<?php
// get a total of one facture
function nbr_total($num_fact) {
    require('../db.php');
    $total = 0;
    $selection = $db -> prepare("SELECT qtt, prixUnit FROM detailfilao WHERE NumFac=$num_fact");
    $selection -> execute();
    $fetchAll = $selection -> fetchAll();

    foreach($fetchAll as $fetch){
        $qtt_poisson = $fetch['qtt'];
        $prix_poisson = $fetch['prixUnit'];
        $total += ($qtt_poisson * $prix_poisson);
    }
    return $total;
}
?>