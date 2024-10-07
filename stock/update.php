<?php
// update.php

// Inclure le fichier de connexion à la base de données
require('../db.php');

// Vérifier si le formulaire est soumis et tous les champs nécessaires sont présents
if (isset($_POST['id'], $_POST['nom_poisson'], $_POST['retHier'], $_POST['enter'], $_POST['qtt'], $_POST['type'], $_POST['EnterDate'])) {
    // Récupérer les données du formulaire et les sécuriser
    $id = htmlspecialchars($_POST['id']);
    $nom_poisson = htmlspecialchars($_POST['nom_poisson']);
    $retHier = htmlspecialchars($_POST['retHier']);
    $PEnter = htmlspecialchars($_POST['enter']);
    $poisson = isset($_POST['poisson']) ? htmlspecialchars($_POST['poisson']) : ''; // Si "poisson" est caché
    $qtt = htmlspecialchars($_POST['qtt']);
    $type = htmlspecialchars($_POST['type']);
    $sac = isset($_POST['sac']) ? htmlspecialchars($_POST['sac']) : null;
    $retour = isset($_POST['retour']) ? htmlspecialchars($_POST['retour']) : null;
    $sortie = isset($_POST['sortie']) ? htmlspecialchars($_POST['sortie']) : null;
    $EnterDate = htmlspecialchars($_POST['EnterDate']);

    // Construire la requête SQL pour mettre à jour les données
    $update_sql = "UPDATE testStock SET nom_poisson = ?, retourhiere = ?, PEnter = ?, poisson = ?, qtt = ?, type = ?, sac = ?, retour = ?, sortie = ?, EnterDate = ? WHERE id = ?";
    $update_stmt = $db->prepare($update_sql);
    $update_stmt->bindParam(1, $nom_poisson);
    $update_stmt->bindParam(2, $retHier);
    $update_stmt->bindParam(3, $PEnter);
    $update_stmt->bindParam(4, $poisson);
    $update_stmt->bindParam(5, $qtt);
    $update_stmt->bindParam(6, $type);
    $update_stmt->bindParam(7, $sac);
    $update_stmt->bindParam(8, $retour);
    $update_stmt->bindParam(9, $sortie);
    $update_stmt->bindParam(10, $EnterDate);
    $update_stmt->bindParam(11, $id);

    // Exécuter la requête et vérifier si elle a réussi
    if ($update_stmt->execute()) {
        ?>
        <script>
            document.location.href = "../chbrfroid/pardate.php?date=<?= htmlspecialchars($EnterDate, ENT_QUOTES, 'UTF-8') ?>";
        </script>
        <?php
    } else {
        echo "Error: " . $update_sql . "<br>" . $db->errorInfo()[2];
    }

    // Fermer la connexion
    $update_stmt = null;
    $db = null;
} else {
    echo "All required fields are not present.";
}
?>
