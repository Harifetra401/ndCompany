<?php
    require('../db.php');
    $num = $_GET["num"];
    $selection = $db -> prepare("SELECT * FROM facturesortie WHERE id=$num");
    $selection -> execute();
    $fetch_depot = $selection -> fetch();
    $receveur = $fetch_depot["destination"];
    echo "Cette chargement est destiné au ".$receveur;

    if($receveur=="client") {
        $select_client = $db -> prepare("SELECT * FROM client WHERE id_sortie=$num");
        $select_client -> execute();
        $fetch_client = $select_client -> fetch();
?>
<h5><?=($fetch_client["nom"]!=0? $fetch_client["nom"] : "<i>Aucun client</i>")?></h5>
<h5><?=$fetch_client["adresse"]!=0? $fetch_client["adresse"] : "<i>Aucun adresse</i>"?></h5>
<h5><?=$fetch_client["contact"]!=0? $fetch_client["contact"] : "<i>Aucun contact</i>"?></h5>

<?php
    }
    ?>