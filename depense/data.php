<?php

    function get_depense_month($month, $year) {
        require('../db.php');
        $sql = "SELECT SUM(cout) as couts FROM depence WHERE YEAR(`date`)=$year AND MONTH(`date`)=$month";
        $stmt = $db->prepare($sql);
        $stmt->execute();
        $fetch=$stmt->fetch();
        return $fetch['couts'] | 0;
    }

    function get_particulier_month($month, $year) {
        require('../db.php');
        $sql = "SELECT SUM(qtt) as qtt FROM particulier WHERE YEAR(`date`)=$year AND MONTH(`date`)=$month";
        $stmt = $db->prepare($sql);
        $stmt->execute();
        $fetch=$stmt->fetch();
        return $fetch['qtt'] | 0;
    }

    function get_depense_month_by_class1($month, $year) {
        require('../db.php');
        $sql = "SELECT SUM(cout) as couts FROM depence WHERE YEAR(`date`)=$year AND MONTH(`date`)=$month AND class = 1";
        $stmt = $db->prepare($sql);
        $stmt->execute();
        $fetch=$stmt->fetch();
        return $fetch['couts'] | 0;
    }

    function get_depense_month_by_class2($month, $year) {
        require('../db.php');
        $sql = "SELECT SUM(cout) as couts FROM depence WHERE YEAR(`date`)=$year AND MONTH(`date`)=$month AND class = 2";
        $stmt = $db->prepare($sql);
        $stmt->execute();
        $fetch=$stmt->fetch();
        return $fetch['couts'] | 0;
    }
    function get_depense_month_by_class3($month, $year) {
        require('../db.php');
        $sql = "SELECT SUM(cout) as couts FROM depence WHERE YEAR(`date`)=$year AND MONTH(`date`)=$month AND class = 3";
        $stmt = $db->prepare($sql);
        $stmt->execute();
        $fetch=$stmt->fetch();
        return $fetch['couts'] | 0;
    }
?>