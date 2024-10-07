<?php
    require('../db.php');
    $id = $_GET["id"];
    $date = $_GET['date'];
    
    // Utilisation de paramètres préparés pour éviter les injections SQL
    $sql = "DELETE FROM `testStock` WHERE id = :id";
    $stmt = $db->prepare($sql);
    
    // Liaison de la variable $id au paramètre préparé
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    
    if ($stmt->execute()) {
        ?>
            <script>
                document.location.href = "pardate.php?date=<?= htmlspecialchars($_GET['date'], ENT_QUOTES, 'UTF-8') ?>";
            </script>
       <?php
    } else {
        echo "Erreur lors de l'exécution de la requête.";
    }
?>
