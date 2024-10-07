<?php
    $sql_new = "SELECT destination FROM facturesortie WHERE id=".$_GET["id"];
    $execute = $db->prepare($sql_new);
    $execute->execute();
    $resultat = $execute -> fetch(); 
    $destin = $resultat["destination"];
?>
    <p>Expedier à <?=$destin?></p>