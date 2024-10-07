<?php
require('../db.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $livraison = $_POST["livraison"];
    $chauffeur = $_POST["chauf"];
    $numero = $_POST["numero"];
    $date = $_POST["date"];

    $sql_old = "SELECT MAX(id) AS idprec FROM facturesortie";
    $exe = $db->prepare($sql_old);
    $exe->execute();
    $resul = $exe->fetch();
    
    $idnews = $resul["idprec"] ? $resul["idprec"] + 1 : 1;

    $sql = "INSERT INTO facturesortie(`id`, `destination`, `chauffeur`, `numero`, `date`) 
            VALUES (:id, :destination, :chauffeur, :numero, :date)";
    
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':id', $idnews);
    $stmt->bindParam(':destination', $livraison);
    $stmt->bindParam(':chauffeur', $chauffeur);
    $stmt->bindParam(':numero', $numero);
    $stmt->bindParam(':date', $date);

    if ($stmt->execute()) {
        $newNumFact = $idnews;
        ?>
        <script>
            window.document.location.href = "../chargement/charge.php?id=<?=$newNumFact?>";
        </script>
        <?php
    } else {
        echo "Erreur lors de l'insertion des données.";
    }
}
?>
