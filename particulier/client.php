<?php
require('../db.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupération des valeurs du formulaire
    $id = $_POST["id"];
    $name = $_POST["name"];
    $adresse = $_POST["adresse"];
    $contact = $_POST["contact"];

    // Préparation de la requête SQL avec des paramètres
    $sql = "UPDATE particulier SET client = :name, adresse = :adresse, contact = :contact WHERE id = :id";
    $stmt = $db->prepare($sql);

    // Liaison des paramètres
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':adresse', $adresse);
    $stmt->bindParam(':contact', $contact);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);

    // Exécution de la requête
    if ($stmt->execute()) {
        ?>
        <script>
            document.location.href = "../particulier/?id=<?=$id?>";
        </script>
        <?php
    } else {
        echo "Erreur lors de la mise à jour.";
    }
}
?>
