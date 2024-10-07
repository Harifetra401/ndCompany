<?php
// Inclure la connexion à la base de données
require('../db.php');

if (isset($_POST['id_poisson']) && isset($_POST['id_sortie'])) {
    $id_poisson = $_POST['id_poisson'];
    $id_sortie = $_POST['id_sortie'];

    // Préparer la requête de suppression
    $sql = "DELETE FROM detailfilaosortie WHERE id = :id_poisson AND id_sortie = :id_sortie";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':id_poisson', $id_poisson, PDO::PARAM_INT);
    $stmt->bindParam(':id_sortie', $id_sortie, PDO::PARAM_INT);

    if ($stmt->execute()) {
        // Redirection après suppression réussie
        header("Location: charge.php?id=$id_sortie");
        exit();
    } else {
        echo "Erreur lors de la suppression.";
    }
} else {
    echo "Données invalides.";
}
?>
