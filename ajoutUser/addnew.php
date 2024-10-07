<?php
    require('../db.php');

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $nomUser = htmlspecialchars($_POST["userName"]);
        $UserResp = htmlspecialchars($_POST["UserResp"]);

        // echo $nomfilao.$num_facture_one.$num_fournisseur_one;

        $sql = "INSERT INTO user(`username`,`responsabilite`) VALUES ('$nomUser','$UserResp')";
        $stmt = $db->prepare($sql);
        
        if ($stmt->execute()) {
            
            header("location:../html/");
        
        } else {
            echo "Erreur lors de l'insertion des données au poisson.";
        }
    }
        
?>

