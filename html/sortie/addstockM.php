<?php
// add.php

// Inclure le fichier de connexion à la base de données
require('../../db.php');

// Vérifier si le formulaire est soumis et tous les champs nécessaires sont présents
if (isset($_POST['nom_poisson'], $_POST['qtt'], $_POST['type'], $_POST['EnterDate'])) {
    // Récupérer les données du formulaire et les sécuriser
    $nom_poisson = htmlspecialchars($_POST['nom_poisson']);
    $retHier = 0;
    $PEnter = htmlspecialchars($_POST['enter']);
    $poisson = 0; // Si "poisson" est caché
    $qtt = htmlspecialchars($_POST['qtt']);
    $type = htmlspecialchars($_POST['type']);
    $sac = isset($_POST['sac']) ? htmlspecialchars($_POST['sac']) : null;
    $retour = 0;
    $sortie = 0 ;
    $EnterDate = htmlspecialchars($_POST['EnterDate']);
    $traitType = htmlspecialchars($_POST['traitType']);

    // Construire la requête SQL pour insérer les données
    $insert_sql = "INSERT INTO testStock (nom_poisson, retourhiere, PEnter, poisson, qtt, type, sac, retour, sortie, EnterDate, traiteTyp) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $insert_stmt = $db->prepare($insert_sql);
    $insert_stmt->bindParam(1, $nom_poisson);
    $insert_stmt->bindParam(2, $retHier);
    $insert_stmt->bindParam(3, $PEnter);
    $insert_stmt->bindParam(4, $poisson);
    $insert_stmt->bindParam(5, $qtt);
    $insert_stmt->bindParam(6, $type);
    $insert_stmt->bindParam(7, $sac);
    $insert_stmt->bindParam(8, $retour);
    $insert_stmt->bindParam(9, $sortie);
    $insert_stmt->bindParam(10, $EnterDate);
     $insert_stmt->bindParam(11, $traitType);

    // Exécuter la requête et vérifier si elle a réussi
    if ($insert_stmt->execute()) {
         ?>
            <script>
                document.location.href = "operationTranche.php?date=<?= htmlspecialchars($EnterDate, ENT_QUOTES, 'UTF-8') ?>";
            </script>
       <?php
    } else {
        echo "Error: " . $insert_sql . "<br>" . $db->errorInfo()[2];
    }

    // Fermer la connexion
    $insert_stmt = null;
    $db = null;
} else {
    echo "All required fields are not present.";
}
?>
