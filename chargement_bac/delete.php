<?php
    require('../db.php');
    $id = $_GET["id"];
    $sql = "DELETE FROM `chargement_bac` WHERE id=$id";
    $stmt = $db->prepare($sql);

    if ($stmt->execute()) {
        ?>
            <script>
                document.location.href = "../chargement_bac";
            </script>
       <?php
    } else {
        echo " $sql Erreur lors de supression des chargement_bac filao.";
    }
?>