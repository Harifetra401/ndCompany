<?php
    require('../../db.php');
    echo "ok";
    $id_fournisseur = $_GET['id_fournisseur'];
    $fact_num = $_GET['numFact'];
    $sql = "UPDATE `facture` SET `text`='oui' WHERE id=$fact_num";
    $stmt = $db->prepare($sql);

    if ($stmt->execute()) {
        ?>
            <script>
                document.location.href = "../FactureAchat.php?id_fournisseur=<?=$id_fournisseur?>&numFact=<?=$fact_num?>";
            </script>
       <?php
    } else {
        echo " $sql Erreur lors de supression des personnel.";
    }
?>