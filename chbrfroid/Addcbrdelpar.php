<?php
require('../db.php');  // Inclusion du fichier de connexion à la base de données

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Collecter les données du formulaire
    $numeroFacture = $_POST['num'];
    $idPoisson = $_POST['poisson_type'];
    $poissonType = $_POST['poisson_type'];
    $daty = $_POST['daty'];
    $poidd = $_POST['poids'];

    try {
        // Préparation de la requête SQL avec des marqueurs de paramètres
        $stmt = $db->prepare("INSERT INTO chbr (numeroFacture, idPoisson, poissonType, qtt, created_at) VALUES (:numeroFacture, :idPoisson, :poissonType, :poidd, :daty)");
        
        // Liaison des paramètres
        $stmt->bindParam(':numeroFacture', $numeroFacture);
        $stmt->bindParam(':idPoisson', $idPoisson);  // This should be idPoisson
        $stmt->bindParam(':poissonType', $poissonType);
        $stmt->bindParam(':poidd', $poidd);
        $stmt->bindParam(':daty', $daty);
        
        // Exécution de la requête
        if ($stmt->execute()) {
            // Suppression de tous les enregistrements de StockParticulier
           

            // Redirection vers entercbr.php avec le numéro de facture en paramètre
            header("Location: deleteparticulier.php");
             // Terminer l'exécution du script après la redirection
        } else {
            echo "Erreur lors de l'insertion des données.";
        }
    } catch (PDOException $e) {
        echo "Erreur : " . $e->getMessage();
    }
}
?>
