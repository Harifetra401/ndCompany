<?php
    require('../db.php');
    $id = $_GET["id"];
    $qtt = $_GET['qtt'];

    $sql = "DELETE FROM `stock` WHERE id=$id";
    $stmt = $db->prepare($sql);
    $sql02 = "UPDATE froidf SET qtt = qtt + :qtt WHERE id = :id";
    $stmt02 = $db->prepare($sql02);
    $stmt02->bindParam(':qtt', $qtt, PDO::PARAM_INT);
    $stmt02->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt02->execute();
    
    $sql03 = "UPDATE stockf SET qtt = qtt - :qtt WHERE id = :id";
    $stmt03 = $db->prepare($sql03);
    $stmt03->bindParam(':qtt', $qtt, PDO::PARAM_INT);
    $stmt03->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt03->execute();
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