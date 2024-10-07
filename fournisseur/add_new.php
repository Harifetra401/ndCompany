<?php
    require('../db.php');

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $nomfournisseur = $_POST["nom"];
        $adressF = $_POST["adressF"];
        $numeroF = $_POST["numeroF"];
    
        $sql = "INSERT INTO `fournisseur` (`NUMERO`, `NOMS`, `PRENOMS`, `nomfournisseur`, `CIN`, `dateCin`, `LieudeDelivrance`) 
                VALUES (0, :nomfournisseur, :nomfournisseur, :nomfournisseur, 0, 0, 0)";
        
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':nomfournisseur', $nomfournisseur);

        if ($stmt->execute()) {
            // Redirection vers une autre page
            ?>
            <script>
                window.document.location.href = "../html/choixFournisseur.php";
            </script>
            <?php
        } else {
            echo "Erreur lors de l'insertion des données.";
        }
    }
?>
