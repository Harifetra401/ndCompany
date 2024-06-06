<?php
    require('../db.php');
    $del = $_GET["del"];
    $id = $_GET["id"];
    $sql = "DELETE FROM `detailfilaosortie` WHERE id=$del";
    $stmt = $db->prepare($sql);

    if ($stmt->execute()) {
        ?>
            <script>
                document.location.href = "../chargement/?id=<?=$id?>";
            </script>
       <?php
    } else {
        echo " $sql Erreur lors de supression des detailfilaosortie filao.";
    }
?>