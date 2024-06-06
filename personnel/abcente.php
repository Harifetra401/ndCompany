<?php
    require('../db.php');
    $id = $_GET["id"];
    $sql = "DELETE FROM present WHERE id_personnel=$id AND date(`date`)=CURDATE()";
    $stmt = $db->prepare($sql);

    if ($stmt->execute()) {
        ?>
            <script>
                document.location.href = "../personnel/listepresence.php";
            </script>
       <?php
    } else {
        echo " $sql Erreur lors de supression des personnel.";
    }
?>