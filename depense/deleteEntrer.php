<?php
    require('../db.php');
    $id = $_GET["id"];
    $sql = "DELETE FROM `entrer` WHERE id=$id";
    $stmt = $db->prepare($sql);

    if ($stmt->execute()) {
        ?>
            <script>
                document.location.href = "../depense";
            </script>
       <?php
    } else {
        echo " $sql Erreur";
    }
?>