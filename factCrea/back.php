<?php
require('../db.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $idFournisseur = $_POST['idFournisseur'];
    $NumFac = $_POST['NumFac'];
    $poisson = $_POST['poisson'];
    $qtt = $_POST['qtt'];
    $pu = $_POST['pu'];
    $ptotal = $qtt * $pu;

    try {
        // Requête préparée pour insérer les données
        $sql = "INSERT INTO detailfilao (Nom, qtt, prixUnit, PrixTotal, NumFac, idFournisseur) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $db->prepare($sql);
        $stmt->bindParam(1, $poisson);
        $stmt->bindParam(2, $qtt);
        $stmt->bindParam(3, $pu);
        $stmt->bindParam(4, $ptotal);
        $stmt->bindParam(5, $NumFac);
        $stmt->bindParam(6, $idFournisseur);

        if ($stmt->execute()) {
            echo "Données insérées avec succès.";
        } else {
            echo "Erreur lors de l'insertion des données.";
        }
    } catch (PDOException $e) {
        echo "Erreur de connexion à la base de données : " . $e->getMessage();
    }

    $db = null; // Fermer la connexion
}
?>

