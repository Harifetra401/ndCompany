<?php
  require('../session.php');
?>
<?php
    require('../db.php');
    $id = $_GET["id"];
    $id_fournisseur = $_GET["id_fournisseur"];
    $numFact = $_GET["numFact"];
    
    // Define the new values to update. Replace with actual values you want to update.
    $prix = $_POST["prixUnit"];
    
    // Add more variables if needed based on what fields you're updating.

    // Update query
    $sql = "UPDATE `detailfilao` SET prixUnit = :prixUnit WHERE id = :id";
    $stmt = $db->prepare($sql);
    
    // Bind parameters
    $stmt->bindParam(':prixUnit', $prix);
  
    $stmt->bindParam(':id', $id);
    
    if ($stmt->execute()) {
        ?>
            <script>
                document.location.href = "FactureAchat.php?id_fournisseur=<?=$id_fournisseur?>&numFact=<?=$numFact?>";
            </script>
       <?php
    } else {
        echo "$sql Erreur lors de la mise à jour des détails filao.";
    }
?>
