<?php

    function get_depense_month($month, $year) {
        require('../db.php');
        $sql = "SELECT SUM(cout) as couts FROM depence WHERE YEAR(`date`)=$year AND MONTH(`date`)=$month";
        $stmt = $db->prepare($sql);
        $stmt->execute();
        $fetch=$stmt->fetch();
        return $fetch['couts'] | 0;
    }
    function get_depense_pers($month, $year) {
        require('../db.php');
        $sql = "SELECT SUM(cout) as couts FROM depence WHERE YEAR(`date`)=$year AND MONTH(`date`)=$month AND libelle = 'depense_personnel'";
        $stmt = $db->prepare($sql);
        $stmt->execute();
        $fetch=$stmt->fetch();
        return $fetch['couts'] | 0;
    }


    function get_depense_dpl($month, $year) {
        require('../db.php');
        $sql = "SELECT SUM(cout) as couts FROM depence WHERE YEAR(`date`)=$year AND MONTH(`date`)=$month AND libelle = 'frais_deplacement'";
        $stmt = $db->prepare($sql);
        $stmt->execute();
        $fetch=$stmt->fetch();
        return $fetch['couts'] | 0;
    }
    function get_depense_amenagemen($month, $year) {
        require('../db.php');
        $sql = "SELECT SUM(cout) as couts FROM depence WHERE YEAR(`date`)=$year AND MONTH(`date`)=$month AND libelle = 'amenagement'";
        $stmt = $db->prepare($sql);
        $stmt->execute();
        $fetch=$stmt->fetch();
        return $fetch['couts'] | 0;
    }
    function get_depense_loyer($month, $year) {
        require('../db.php');
        $sql = "SELECT SUM(cout) as couts FROM depence WHERE YEAR(`date`)=$year AND MONTH(`date`)=$month AND libelle = 'loyer'";
        $stmt = $db->prepare($sql);
        $stmt->execute();
        $fetch=$stmt->fetch();
        return $fetch['couts'] | 0;
    }
    function get_depense_aut($month, $year) {
        require('../db.php');
        $sql = "SELECT SUM(cout) as couts FROM depence WHERE YEAR(`date`)=$year AND MONTH(`date`)=$month AND libelle = 'autorite'";
        $stmt = $db->prepare($sql);
        $stmt->execute();
        $fetch=$stmt->fetch();
        return $fetch['couts'] | 0;
    }
    function get_depense_imo($month, $year) {
        require('../db.php');
        $sql = "SELECT SUM(cout) as couts FROM depence WHERE YEAR(`date`)=$year AND MONTH(`date`)=$month AND libelle = 'compte_immobilisation'";
        $stmt = $db->prepare($sql);
        $stmt->execute();
        $fetch=$stmt->fetch();
        return $fetch['couts'] | 0;
    }
    function get_depense_comms($month, $year) {
        require('../db.php');
        $sql = "SELECT SUM(cout) as couts FROM depence WHERE YEAR(`date`)=$year AND MONTH(`date`)=$month AND libelle = 'commission'";
        $stmt = $db->prepare($sql);
        $stmt->execute();
        $fetch=$stmt->fetch();
        return $fetch['couts'] | 0;
    }
    function get_depense_autre($month, $year) {
        require('../db.php');
        $sql = "SELECT SUM(cout) as couts FROM depence WHERE YEAR(`date`)=$year AND MONTH(`date`)=$month AND libelle = 'autres_depenses'";
        $stmt = $db->prepare($sql);
        $stmt->execute();
        $fetch=$stmt->fetch();
        return $fetch['couts'] | 0;
    }
    function get_depense_elprod($month, $year) {
        require('../db.php');
        $sql = "SELECT SUM(cout) as couts FROM depence WHERE YEAR(`date`)=$year AND MONTH(`date`)=$month AND libelle = 'enlevement_produits'";
        $stmt = $db->prepare($sql);
        $stmt->execute();
        $fetch=$stmt->fetch();
        return $fetch['couts'] | 0;
    }
    function get_depense_csrvprod($month, $year) {
        require('../db.php');
        $sql = "SELECT SUM(cout) as couts FROM depence WHERE YEAR(`date`)=$year AND MONTH(`date`)=$month AND libelle = 'conservation_produits'";
        $stmt = $db->prepare($sql);
        $stmt->execute();
        $fetch=$stmt->fetch();
        return $fetch['couts'] | 0;
    }
    function get_depense_ctrait($month, $year) {
        require('../db.php');
        $sql = "SELECT SUM(cout) as couts FROM depence WHERE YEAR(`date`)=$year AND MONTH(`date`)=$month AND libelle = 'cout_traitements'";
        $stmt = $db->prepare($sql);
        $stmt->execute();
        $fetch=$stmt->fetch();
        return $fetch['couts'] | 0;
    }
    function get_depense_appro($month, $year) {
        require('../db.php');
        $sql = "SELECT SUM(cout) as couts FROM depence WHERE YEAR(`date`)=$year AND MONTH(`date`)=$month AND libelle = 'materiels_approvisionnements'";
        $stmt = $db->prepare($sql);
        $stmt->execute();
        $fetch=$stmt->fetch();
        return $fetch['couts'] | 0;
    }
    function get_depense_emball($month, $year) {
        require('../db.php');
        $sql = "SELECT SUM(cout) as couts FROM depence WHERE YEAR(`date`)=$year AND MONTH(`date`)=$month AND libelle = 'emballage_produits'";
        $stmt = $db->prepare($sql);
        $stmt->execute();
        $fetch=$stmt->fetch();
        return $fetch['couts'] | 0;
    }
    function get_depense_dpdiv($month, $year) {
        require('../db.php');
        $sql = "SELECT SUM(cout) as couts FROM depence WHERE YEAR(`date`)=$year AND MONTH(`date`)=$month AND libelle = 'depenses_diverses'";
        $stmt = $db->prepare($sql);
        $stmt->execute();
        $fetch=$stmt->fetch();
        return $fetch['couts'] | 0;
    }
    function get_depense_transloc($month, $year) {
        require('../db.php');
        $sql = "SELECT SUM(cout) as couts FROM depence WHERE YEAR(`date`)=$year AND MONTH(`date`)=$month AND libelle = 'transport_locale'";
        $stmt = $db->prepare($sql);
        $stmt->execute();
        $fetch=$stmt->fetch();
        return $fetch['couts'] | 0;
    }
    function get_depense_lTana($month, $year) {
        require('../db.php');
        $sql = "SELECT SUM(cout) as couts FROM depence WHERE YEAR(`date`)=$year AND MONTH(`date`)=$month AND libelle = 'livraison_tana'";
        $stmt = $db->prepare($sql);
        $stmt->execute();
        $fetch=$stmt->fetch();
        return $fetch['couts'] | 0;
    }












    function get_entrer($month, $year) {
        require('../db.php');
        $sql = "SELECT SUM(cout) as couts FROM entrer WHERE YEAR(`date`)=$year AND MONTH(`date`)=$month";
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
        $sql = "SELECT SUM(cout) as couts FROM depence WHERE YEAR(`date`)=$year AND MONTH(`date`)=$month";
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