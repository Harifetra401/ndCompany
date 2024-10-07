<?php

try {
    require('../db.php');

    // Récupération des valeurs du formulaire
    $num = $_POST['num'];
    $id_poisson = $_POST['id_poisson'];
    $poids = $_POST['poid'];
    $contre_Pese = $_POST['contre_Pese'];
    $sortie = $_POST['sortie'];
    $sgcite = $_POST['sgcite'];
    $sgTana = $_POST['sgTana'];
    $date = $_POST['datedate'];
    $rtraiter = $contre_Pese - $sortie - $sgcite - $sgTana;

    // Vérifier si l'enregistrement existe déjà
    $checkSql = "SELECT COUNT(*) FROM bdAchat WHERE numFact = :num AND article = :id_poisson";
    $checkStmt = $db->prepare($checkSql);
    $checkStmt->bindParam(':num', $num);
    $checkStmt->bindParam(':id_poisson', $id_poisson);
    $checkStmt->execute();

    $count = $checkStmt->fetchColumn();

    if ($count > 0) {
        // Mise à jour de l'enregistrement existant
        $updateSql = "UPDATE bdAchat 
                      SET poids = :poid, contrePese = :contre_Pese, SortieLocal = :sortie, 
                          sous_glaceLocal = :sgcite, sous_glaceTana = :sgTana, RestAtraiter = :rtraiter, date = :date
                      WHERE numFact = :num AND article = :id_poisson";
        $updateStmt = $db->prepare($updateSql);

        // Liaison des paramètres
        $updateStmt->bindParam(':poid', $poids);
        $updateStmt->bindParam(':contre_Pese', $contre_Pese);
        $updateStmt->bindParam(':sortie', $sortie);
        $updateStmt->bindParam(':sgcite', $sgcite);
        $updateStmt->bindParam(':sgTana', $sgTana);
        $updateStmt->bindParam(':rtraiter', $rtraiter);
        $updateStmt->bindParam(':num', $num);
        $updateStmt->bindParam(':id_poisson', $id_poisson);
        $updateStmt->bindParam(':date', $date);

        // Exécution de la mise à jour
        $updateStmt->execute();

            ?><script>
                document.location.href = "traitement.php?date=<?=$date?>";
            </script><?php
    } else {
        // Insertion d'un nouvel enregistrement
        $insertSql = "INSERT INTO bdAchat (numFact, article, poids, contrePese, SortieLocal, sous_glaceLocal, sous_glaceTana, RestAtraiter, date)
                      VALUES (:num, :id_poisson, :poid, :contre_Pese, :sortie, :sgcite, :sgTana, :rtraiter, :datedate)";
        $insertStmt = $db->prepare($insertSql);

        // Liaison des paramètres
        $insertStmt->bindParam(':num', $num);
        $insertStmt->bindParam(':id_poisson', $id_poisson);
        $insertStmt->bindParam(':poid', $poids);
        $insertStmt->bindParam(':contre_Pese', $contre_Pese);
        $insertStmt->bindParam(':sortie', $sortie);
        $insertStmt->bindParam(':sgcite', $sgcite);
        $insertStmt->bindParam(':sgTana', $sgTana);
        $insertStmt->bindParam(':rtraiter', $rtraiter);
        $insertStmt->bindParam(':datedate', $date);

        // Exécution de l'insertion
        $insertStmt->execute();
             ?>
            <script>
                document.location.href = "traitement.php?date=<?=$date?>";
            </script>
            <?php
    }

} catch (PDOException $e) {
    echo "Erreur : " . $e->getMessage();
}

// Fermeture de la connexion
$db = null;
?>
