<?php
require('../db.php');


if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $poisson = htmlspecialchars($_POST['poisson']);
    $typ = (int)$_POST['typ'];
    $qtt = (float)$_POST['qtt'];
    $sac = (int)$_POST['sac'];

    $id_sortie = (int)$_POST['id_sortie'];

    $sql = "INSERT INTO detailfilaosortie (id_poisson, sac, qtt, typ, id_sortie)
            VALUES (:poisson, :sac, :qtt, :typ, :id_sortie)";

    $stmt = $db->prepare($sql);

    // Liaison des paramètres
    $stmt->bindParam(':poisson', $poisson);
    $stmt->bindParam(':typ', $typ);
    $stmt->bindParam(':qtt', $qtt);
    $stmt->bindParam(':sac', $sac);
    $stmt->bindParam(':id_sortie', $id_sortie);

    // Exécuter la requête
    if ($stmt->execute()) {
                ?>
            <script>
                document.location.href = "charge.php?id=<?= $id_sortie ?>";
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
