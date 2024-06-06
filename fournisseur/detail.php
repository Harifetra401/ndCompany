<?php
require('../db.php');

if (isset($_GET['id_fournisseur'])) {
    $fournisseurId = $_GET['id_fournisseur'];

    try {
       

        $sql = "SELECT * FROM fournisseur WHERE id = :fournisseurId";
        $stmt = $db->prepare($sql);
        $stmt->bindParam(":fournisseurId", $fournisseurId, PDO::PARAM_INT);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            $nom_fou = $row['nomfournisseur'];
            $Adresse_fou = $row['Adress'];
            $contact_fou = $row['contact'];
        } else {
            echo "Aucun fournisseur trouvé avec cet ID.";
        }
    } catch (PDOException $e) {
        echo "Erreur de connexion à la base de données : " . $e->getMessage();
    }
} else {
    echo "ID du fournisseur non spécifié.";
}
?>

