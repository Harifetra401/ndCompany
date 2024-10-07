<?php
require ('../db.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $libelle = $_POST["libelle"];
    $cout = $_POST["cout"];
    $desc = $_POST["desc"];
    $daty = $_POST["daty"];
    
    // Préparer la requête SQL avec des placeholders
    $sql = "INSERT INTO entrer(`libelle`, `cout`, `description`, `date`) VALUES (:libelle, :cout, :desc, :daty)";
    $stmt = $db->prepare($sql);
    
    // Lier les valeurs aux placeholders
    $stmt->bindParam(':libelle', $libelle);
    $stmt->bindParam(':cout', $cout);
    $stmt->bindParam(':desc', $desc);
    $stmt->bindParam(':daty', $daty);
    
    // Exécuter la requête
    if ($stmt->execute()) {
        ?>
        <script>
            document.location.href = "../depense";
        </script>
        <?php
    } else {
        echo "Erreur lors de l'insertion des données.";
    }
}
?>
