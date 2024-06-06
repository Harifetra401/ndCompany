<?php
    require('../db.php');
    $idc = $_GET["idc"];
    $id = $_GET["id"];
    $sql = "DELETE FROM `particulier` WHERE idc=$idc";
    $stmt = $db->prepare($sql);

    if ($stmt->execute()) {
        ?>
            <script>
                document.location.href = "../particulier/?id=<?=$id?>";
            </script>
       <?php
    } else {
        echo " $sql Erreur lors de supression des particulier filao.";
    }
?>