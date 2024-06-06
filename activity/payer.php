<?php
    require('../db.php');
    $id = $_GET["id"];
    $sql = "UPDATE `facture` SET `text`= 'oui' WHERE id=$id";
    $stmt = $db->prepare($sql);

    if ($stmt->execute()) {
        ?>
            <script>
                document.location.href = "facture.php?num=<?=$id?>";
            </script>
       <?php
    } else {
        echo " $sql Erreur lors de supression des personnel.";
    }
?>