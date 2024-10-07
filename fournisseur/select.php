<?php
    require('../db.php');

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $fournisseur = $_POST["fournisseur"];
        $date = $_POST["date"];
        $type = $_POST["typ"];

        // Récupérer le dernier id de la table facture
        $sql = "SELECT MAX(id) AS id FROM facture";
        $stmt = $db->prepare($sql);
        $stmt->execute();
        $resultat = $stmt->fetch(); 

        if ($resultat["id"]) {
            $newNumFact = $resultat["id"] + 1;
        } else {
            $newNumFact = 1;
        }

        // Préparer l'insertion de la nouvelle facture avec des placeholders
        $creatNewFact = "INSERT INTO facture(`id`, `id_fou`, `totalapayee`, `payee`, `restapayer`, `date`, `type`) VALUES (:newNumFact, :fournisseur, 0, 0, 0, :date, :type)";
        $validation = $db->prepare($creatNewFact);

        // Lier les valeurs aux placeholders
        $validation->bindParam(':newNumFact', $newNumFact);
        $validation->bindParam(':fournisseur', $fournisseur);
        $validation->bindParam(':date', $date);
        $validation->bindParam(':type', $type);

        // Exécuter la requête
        if ($validation->execute()) {
           ?>
                <script>
                   document.location.href = "../html/FactureAchat.php?id_fournisseur=<?=$fournisseur?>&numFact=<?=$newNumFact?>&origine=<?=$type?>&date=<?=$date?>";
                </script>
           <?php
        } else {
            echo "Erreur lors de l'ajout de la nouvelle facture.";
        }
    }
?>
