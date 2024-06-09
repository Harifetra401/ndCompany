<?php
    function get_all($place) {
        require('../db.php');
        $sql = "SELECT SUM(qtt) as qtt FROM stock WHERE place=$place";
        $sql1 = "SELECT SUM(nombre_sac) as sac FROM stock WHERE place=$place";
        $sql2 = "SELECT SUM(qtt) as stocktana FROM ventetana WHERE qtt !=0";
        $stmt = $db->prepare($sql);
        $stmt1 = $db->prepare($sql1);
        $stmt2 =  $db->prepare($sql2);
        $stmt->execute();
        $stmt1->execute();
        $stmt2 -> execute();
        $fetch=$stmt->fetch();
        $fetch1=$stmt1->fetch();
        $fetch2=$stmt2->fetch();

        return [$fetch["qtt"],$fetch1["sac"],$fetch2["stocktana"]];
    }

    function get_sortie($place) {
        require('../db.php');
        $sql = "SELECT SUM(qtt) as qtt FROM detailfilaosortie WHERE place=$place";
        $sql1 = "SELECT SUM(sac) as sac FROM detailfilaosortie WHERE place=$place";
        $stmt = $db->prepare($sql);
        $stmt1 = $db->prepare($sql1);
        $stmt->execute();
        $stmt1->execute();
        $fetch=$stmt->fetch();
        $fetch1=$stmt1->fetch();
        return [$fetch["qtt"],$fetch1["sac"]];
    }

    function get_particulier($date) {
        require('../db.php');
        $sql = "SELECT SUM(qtt) as qtt FROM particulier WHERE date(`date`)='$date'";
        $stmt = $db->prepare($sql);
        $stmt->execute();
        $fetch=$stmt->fetch();
        return $fetch['qtt'] | 0;
    }

    function get_achat($date) {
        require('../db.php');
        $sql = "SELECT SUM(qtt) as qtt FROM detailfilao WHERE date(`date`)='$date'";
        $stmt = $db->prepare($sql);
        $stmt->execute();
        $fetch=$stmt->fetch();
        return $fetch['qtt'] | 0;
    }

    function get_achat_month($month, $year) {
        require('../db.php');
        $sql = "SELECT SUM(qtt) as qtt FROM detailfilao WHERE YEAR(`date`)=$year AND MONTH(`date`)=$month";
        $stmt = $db->prepare($sql);
        $stmt->execute();
        $fetch=$stmt->fetch();
        return $fetch['qtt'] | 0;
    }

    function get_particulier_month($month, $year) {
        require('../db.php');
        $sql = "SELECT SUM(qtt) as qtt FROM particulier WHERE YEAR(`date`)=$year AND MONTH(`date`)=$month";
        $stmt = $db->prepare($sql);
        $stmt->execute();
        $fetch=$stmt->fetch();
        return $fetch['qtt'] | 0;
    }

?>