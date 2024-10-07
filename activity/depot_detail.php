<?php
    require('../db.php');
    $num = $_GET["num"];
    $selection = $db -> prepare("SELECT * FROM facturesortie WHERE id=$num");
    $selection -> execute();
    $fetch_depot = $selection -> fetch();
    $receveur = $fetch_depot["destination"];
    $chauff = $fetch_depot["chauffeur"];
    $date = $fetch_depot["date"];
    $numero = $fetch_depot["numero"];
    $numVoiture = $fetch_depot["imat"];
    $emeteur = $fetch_depot["emeteur"];
    

    if($receveur=="client") {
        $select_client = $db -> prepare("SELECT * FROM client WHERE id_sortie=$num");
        $select_client -> execute();
        $fetch_client = $select_client -> fetch();
?>


<?php
    }
    ?>