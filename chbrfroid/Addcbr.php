<?php
require('../db.php');  // Inclusion du fichier de connexion à la base de données

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Collecter les données du formulaire
    $numeroFacture = $_POST['num'];
    $idPoisson = $_POST['id_poisson'];
    $poissonType = $_POST['poisson_type'];
    $daty = $_POST['daty'];
    $poidd =  $_POST['poids'];
     
    try {
        // Vérifier si l'enregistrement existe déjà
        $checkStmt = $db->prepare("
            SELECT COUNT(*) FROM chbr 
            WHERE numeroFacture = :numeroFacture 
            AND idPoisson = :idPoisson 
        ");
        
        $checkStmt->bindParam(':numeroFacture', $numeroFacture);
        $checkStmt->bindParam(':idPoisson', $idPoisson);
        $checkStmt->execute();
        $exists = $checkStmt->fetchColumn();
        
        if ($exists) {
            // Si l'enregistrement existe, mettre à jour
            $stmt = $db->prepare("
                UPDATE chbr 
                SET qtt = :poidd, created_at = :daty, poissonType = :poissonType
                WHERE numeroFacture = :numeroFacture 
                AND idPoisson = :idPoisson 
            ");
        } else {
            // Si l'enregistrement n'existe pas, insérer un nouvel enregistrement
            $stmt = $db->prepare("
                INSERT INTO chbr (numeroFacture, idPoisson, poissonType, qtt, created_at) 
                VALUES (:numeroFacture, :idPoisson, :poissonType, :poidd, :daty)
            ");
        }
        
        // Liaison des paramètres
        $stmt->bindParam(':numeroFacture', $numeroFacture);
        $stmt->bindParam(':idPoisson', $idPoisson);
        $stmt->bindParam(':poissonType', $poissonType);
        $stmt->bindParam(':poidd', $poidd);
        $stmt->bindParam(':daty', $daty);
        
        // Exécution de la requête
        if ($stmt->execute()) {
            header("Location: entercbr.php?num=$numeroFacture&date=$daty");
            exit(); // Terminer l'exécution du script après la redirection
        } else {
            echo "Erreur lors de l'exécution de la requête.";
        }
    } catch (PDOException $e) {
        echo "Erreur : " . $e->getMessage();
    }
    
    // Fermeture de la connexion à la base de données
    $db = null;
}
?>
