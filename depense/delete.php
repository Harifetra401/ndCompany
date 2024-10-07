<?php
    require('../db.php');
    $id = $_GET["id"];
    $sql = "DELETE FROM `depence` WHERE id=$id";
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