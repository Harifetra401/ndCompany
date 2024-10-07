<?php
require('../../db.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nomfilao = $_POST["nom"];
    $date = $_POST['date'];
    $num_facture_one = $_POST['numFact'];
    

    // Utilisation de requêtes préparées pour éviter les injections SQL
    $insertQueries = [
        "INSERT INTO froidf (`nomFilao`) VALUES (:nomfilao)",
        "INSERT INTO stockf (`nomFilao`) VALUES (:nomfilao)",
        "INSERT INTO ventetana (`nomFilao`, `qtt`) VALUES (:nomfilao, 0)",
        "INSERT INTO poisson (`nomFilao`) VALUES (:nomfilao)"
    ];

    // Gestion des erreurs avec try-catch
    try {
        foreach ($insertQueries as $query) {
            $stmt = $db->prepare($query);
            $stmt->bindParam(':nomfilao', $nomfilao);
            $stmt->execute();
        }

        // Redirection côté serveur
        header("Location: operationTranche.php?date=$date");
        exit();
    } catch (Exception $e) {
        echo "Erreur lors de l'insertion des données au poisson. Détails : " . $e->getMessage();
    } finally {
        // Assurez-vous de fermer la connexion à la base de données
        $db = null;
    }
}
?>
