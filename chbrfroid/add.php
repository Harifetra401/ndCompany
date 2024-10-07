<?php
    require('../db.php');

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $nomArt = htmlspecialchars($_POST["poisson"]);
        $qtt = htmlspecialchars($_POST["qtt"]);

        // echo $nomfilao.$num_facture_one.$num_fournisseur_one;

        $sql = "INSERT INTO chbrfroid(`article`,`qtt`) VALUES ('$nomArt','$qtt')";
        $stmt = $db->prepare($sql);
        
        if ($stmt->execute()) {
            
            header("location:index.php");
        
        } else {
            echo "Erreur lors de l'insertion des données au poisson.";
        }
    }
        
?>