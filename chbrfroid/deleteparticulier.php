<?php
require('../db.php');  // Inclusion du fichier de connexion à la base de données

try {
    // Préparation de la requête de suppression
    $stmt = $db->prepare('DELETE FROM StockParticulier');
    
    // Exécution de la requête
    if ($stmt->execute()) {
        echo "Tous les enregistrements ont été supprimés avec succès.";
    } else {
        echo "Erreur lors de la suppression des enregistrements.";
    }
} catch (PDOException $e) {
    echo "Erreur : " . $e->getMessage();
}
?>
