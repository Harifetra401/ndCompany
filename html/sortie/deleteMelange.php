<?php
// Inclure la connexion à la base de données
require('../../db.php');

if (isset($_POST['id_poisson']) && isset($_POST['date'])) {
    $id_poisson = $_POST['id_poisson'];
    $date = $_POST['date'];

    // Préparer la requête de suppression
    $sql = "DELETE FROM detailfilaosortie WHERE id_poisson = :id_poisson AND DateMelange = :date";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':id_poisson', $id_poisson, PDO::PARAM_INT);
    $stmt->bindParam(':date', $date, PDO::PARAM_STR);

    if ($stmt->execute()) {
        // Redirection après suppression réussie
        header("Location: ../SortieMelange.php?date=$date");
        exit();
    } else {
        echo "Erreur lors de la suppression.";
    }
} else {
    echo "Données invalides.";
}
?>
