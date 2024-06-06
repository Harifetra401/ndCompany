<?php
    require('../../db.php');
    $id_fournisseur = $_GET['id_fournisseur'];
    $fact_num = $_GET['numFact'];
    $sql = "UPDATE `facture` SET `text`='non' WHERE id=$fact_num";
    echo "$sql";
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