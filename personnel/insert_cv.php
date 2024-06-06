<?php
  require('../db.php');
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!empty($_FILES["fichier"])) {
        $id = $_POST["id"];
        $targetDirectory = "uploads/$id"; // Répertoire de destination pour stocker l'fichier
        $targetFile = $targetDirectory . basename($_FILES["fichier"]["name"]);

            if (move_uploaded_file($_FILES["fichier"]["tmp_name"], $targetFile)) {
                echo "L'fichier a été téléchargée avec succès.";
                $delete_img = $db->prepare("DELETE FROM cv WHERE id=$id");
                $delete_img -> execute();
                $insert_img = $db->prepare("INSERT INTO cv (id, cv) VALUES ($id, '$targetFile')");
                $insert_img -> execute();
                header("location:profil.php?id=$id");
            } else {
                echo "Une erreur s'est produite lors du téléchargement de l'fichier.";
            }
    } else {
        echo "fichier vide, veillez ajouter un autre.";
    }
}
?>
