<?php
    require('../db.php');
    $idc = $_GET["idc"];
    $id = $_GET["id"];
    $sql = "DELETE FROM `ventetana` WHERE idc=$idc";
    $stmt = $db->prepare($sql);

    if ($stmt->execute()) {
        ?>
            <script>
                document.location.href = "../ventetana/?id=<?=$id?>";
            </script>
       <?php
    } else {
        echo " $sql Erreur de connexion a la base de donne";
    }
?>