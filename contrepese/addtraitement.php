<?php
// Database connection

try {
    require('../db.php');

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Check if the record with the same id_poisson, poidTraite, and date already exists
        $checkStmt = $db->prepare("SELECT COUNT(*) FROM traitement WHERE id_poisson = :id_poisson AND poidTraite = :poidTraite AND date = :date");
        $checkStmt->bindParam(':id_poisson', $_POST['id_poisson']);
        $checkStmt->bindParam(':poidTraite', $_POST['poidTraite']);
        $checkStmt->bindParam(':date', $_POST['date']);
        $checkStmt->execute();
        $recordExists = $checkStmt->fetchColumn();

        if ($recordExists > 0) {
            // Update the existing record
            $updateStmt = $db->prepare("UPDATE traitement SET EntrerFillet = :EntrerFillet, EntrerTTSqlt = :EntrerTTSqlt, EntrerSae = :EntrerSae, EntrerAutre = :EntrerAutre, Pdecise = :Pdecise WHERE id_poisson = :id_poisson AND poidTraite = :poidTraite AND date = :date");

            $updateStmt->bindParam(':id_poisson', $_POST['id_poisson']);
            $updateStmt->bindParam(':poidTraite', $_POST['poidTraite']);
            $updateStmt->bindParam(':EntrerFillet', $_POST['EntrerFillet']);
            $updateStmt->bindParam(':EntrerTTSqlt', $_POST['EntrerTTSqlt']);
            $updateStmt->bindParam(':EntrerSae', $_POST['EntrerSae']);
            $updateStmt->bindParam(':EntrerAutre', $_POST['EntrerAutre']);
            $updateStmt->bindParam(':Pdecise', $_POST['Pdecise']);
            $updateStmt->bindParam(':date', $_POST['date']);
            $updateStmt->execute();
        } else {
            // Insert a new record
            $insertStmt = $db->prepare("INSERT INTO traitement (id_poisson, poidTraite, EntrerFillet, EntrerTTSqlt, EntrerSae, EntrerAutre, Pdecise, date) VALUES (:id_poisson, :poidTraite, :EntrerFillet, :EntrerTTSqlt, :EntrerSae, :EntrerAutre, :Pdecise, :date)");

            $insertStmt->bindParam(':id_poisson', $_POST['id_poisson']);
            $insertStmt->bindParam(':poidTraite', $_POST['poidTraite']);
            $insertStmt->bindParam(':EntrerFillet', $_POST['EntrerFillet']);
            $insertStmt->bindParam(':EntrerTTSqlt', $_POST['EntrerTTSqlt']);
            $insertStmt->bindParam(':EntrerSae', $_POST['EntrerSae']);
            $insertStmt->bindParam(':EntrerAutre', $_POST['EntrerAutre']);
            $insertStmt->bindParam(':Pdecise', $_POST['Pdecise']);
            $insertStmt->bindParam(':date', $_POST['date']);
            $insertStmt->execute();
        }
        ?>
        <script>
            document.location.href = "TraitetParDate.php?date=<?= $_POST['date']?>";
        </script>
        <?php
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
