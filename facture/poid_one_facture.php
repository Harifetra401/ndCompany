<?php
// get a total of one facture
function poid_total($num_fact) {
    require('../db.php');
    $total = 0;
    $selection = $db -> prepare("SELECT qtt FROM detailfilao WHERE NumFac=$num_fact");
    $selection -> execute();
    $fetchAll = $selection -> fetchAll();

    foreach($fetchAll as $fetch){
        $qtt_poisson = $fetch['qtt'];
        $total += ($qtt_poisson);
    }
    return $total;
}
?>