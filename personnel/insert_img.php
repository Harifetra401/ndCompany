<?php
  require('../db.php');
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!empty($_FILES["image"])) {
        $id = $_POST["id"];
        $targetDirectory = "uploads/$id"; // Répertoire de destination pour stocker l'image
        $targetFile = $targetDirectory . basename($_FILES["image"]["name"]);

            if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile)) {
                echo "L'image a été téléchargée avec succès.";
                $delete_img = $db->prepare("DELETE FROM imgpers WHERE id=$id");
                $delete_img -> execute();
                $insert_img = $db->prepare("INSERT INTO imgpers (id, img) VALUES ($id, '$targetFile')");
                $insert_img -> execute();
                header("location:profil.php?id=$id");
            } else {
                echo "Une erreur s'est produite lors du téléchargement de l'image.";
            }
    } else {
        echo "Image vide, veillez ajouter un autre.";
    }
}
?>
