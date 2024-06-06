<?php
  require('../session.php');
  ?>
<?php
    require('../db.php');
    $id = $_GET["id"];
    $id_fournisseur = $_GET["id_fournisseur"];
    $numFact = $_GET["numFact"];
    $sql = "DELETE FROM `detailfilao` WHERE id=$id";
    $stmt = $db->prepare($sql);

    if ($stmt->execute()) {
        ?>
            <script>
                document.location.href = "FactureAchat.php?id_fournisseur=<?=$id_fournisseur?>&numFact=<?=$numFact?>";
            </script>
       <?php
    } else {
        echo " $sql Erreur lors de supression des datail filao.";
    }
?>