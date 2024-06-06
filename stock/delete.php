<?php
    require('../db.php');
    $id = $_GET["id"];
    $sql = "DELETE FROM `stock` WHERE id=$id";
    $stmt = $db->prepare($sql);

    if ($stmt->execute()) {
        ?>
            <script>
                document.location.href = "../stock";
            </script>
       <?php
    } else {
        echo " $sql Erreur lors de supression des stock filao.";
    }
?>