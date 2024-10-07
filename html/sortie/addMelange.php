<?php
require('../../db.php');


if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $poisson = htmlspecialchars($_POST['poisson']);
    $typ = (int)$_POST['typ'];
    $qtt = (float)$_POST['qtt'];
    $sac = (int)$_POST['sac'];
    $date = $_POST['date'];
    $zero = 0;
    

    $sql = "INSERT INTO detailfilaosortie (id_poisson, sac, qtt, typ, id_sortie, qttTranche, dateTranche, Qttmelange, DateMelange)
            VALUES (:poisson, :sac, :qtt, :typ, :id_sortie, :qttTranche, :dateTranche, :Qttmelange, :DateMelange)";

    $stmt = $db->prepare($sql);

    // Liaison des paramètres
    $stmt->bindParam(':poisson', $poisson);
    $stmt->bindParam(':typ', $typ);
    $stmt->bindParam(':qtt', $zero);
    $stmt->bindParam(':sac', $sac);
    $stmt->bindParam(':id_sortie', $zero);
    $stmt->bindParam(':qttTranche', $zero);
    $stmt->bindParam(':dateTranche', $zero);
    $stmt->bindParam(':Qttmelange', $qtt);
    $stmt->bindParam(':DateMelange', $date);

    // Exécuter la requête
    if ($stmt->execute()) {
                ?>
            <script>
                document.location.href = "../SortieMelange.php?date=<?=$date ?>";
            </script>
<?php
        exit();
    } else {
        echo "Erreur lors de l'insertion des données.";
    }
} else {
    echo "Aucune donnée soumise.";
}
?>
