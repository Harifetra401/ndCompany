<?php
    require('../db.php');

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $poisson = $_POST["poisson"];
        $cat = $_POST["cat"];
        $class = 1;
        $qtt = $_POST["qtt"];
        $pu = $_POST["pu"];
        $fournisseur = $_POST["id_fournisseur"];
        $numFact = $_POST["numFact"];
        $ajoutDate = $_POST["date"];
        
        $sql = "INSERT INTO detailfilao(`id_poisson`, `catgr`, `classe`, `qtt`, `prixUnit`, `NumFac`, `idFournisseur`, `date`) 
                VALUES (:poisson, :cat, :class, :qtt, :pu, :numFact, :fournisseur, :ajoutDate)";
        $stmt = $db->prepare($sql);

        // Lier les paramètres pour plus de sécurité
        $stmt->bindParam(':poisson', $poisson);
        $stmt->bindParam(':cat', $cat);
        $stmt->bindParam(':class', $class);
        $stmt->bindParam(':qtt', $qtt);
        $stmt->bindParam(':pu', $pu);
        $stmt->bindParam(':numFact', $numFact);
        $stmt->bindParam(':fournisseur', $fournisseur);
        $stmt->bindParam(':ajoutDate', $ajoutDate);

        if ($stmt->execute()) {
            ?>
            <script>
                document.location.href = "../html/FactureAchat.php?id_fournisseur=<?=$fournisseur?>&numFact=<?=$numFact?>&date=<?=$ajoutDate?>";
            </script>
            <?php
        } else {
            echo "Erreur lors de l'insertion des données.";
        }
    }
?>
