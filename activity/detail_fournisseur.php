<?php
    require('../db.php');

        $sql_fou = "SELECT id_fou FROM facture WHERE id =".$_GET['num'];
        $stmt_fou = $db->prepare($sql_fou);
        $stmt_fou->execute();
        $fetch_fou = $stmt_fou -> fetch();
        $id_fou = $fetch_fou["id_fou"];
        
        $sql = "SELECT * FROM fournisseur WHERE id =$id_fou";
        $stmt = $db->prepare($sql);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            $nom_fou = $row['nomfournisseur']; 
            $Adresse_fou = $row['Adress'];
            $contact_fou = $row['contact'];
        } else {
            echo "Aucun fournisseur trouvé avec cet ID.";
        }
?>

