<?php
require('../db.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $qtt = $_POST["qtt"];
    $id_poisson = $_POST["id_poisson"];
    $num_facture = $_POST['num'];
    $sortie = $_POST['sortieqtt'];
    $classpss = 8;
    $pdetail = 0;

    // Vérifier si l'enregistrement existe déjà
    $checkSql = "SELECT COUNT(*) FROM `detailavant` WHERE `id_poisson` = ? AND `NumFac` = ?";
    $checkStmt = $db->prepare($checkSql);
    $checkStmt->execute([$id_poisson, $num_facture]);
    $exists = $checkStmt->fetchColumn();

    if ($exists) {
        // Si l'enregistrement existe, faire un UPDATE
        $updateSql = "UPDATE `detailavant` SET `sortie` = ?, `qtt` = ?, `lanja` = ?, `class` = ?, `pdetail` = ? WHERE `id_poisson` = ? AND `NumFac` = ?";
        $updateStmt = $db->prepare($updateSql);
        $params = [$sortie, $qtt, $qtt, $classpss, $pdetail, $id_poisson, $num_facture];
        if ($updateStmt->execute($params)) {
            ?>
            <script>
                document.location.href = "traitement.php?num=<?= $num_facture ?>";
            </script><?php
        } else {
            echo "Erreur lors de la mise à jour des détails.";
        }
    } else {
        // Si l'enregistrement n'existe pas, faire un INSERT
        $insertSql = "INSERT INTO `detailavant`(`idfilao`, `id_poisson`, `NumFac`, `sortie`, `qtt`, `lanja`, `class`, `pdetail`) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $insertStmt = $db->prepare($insertSql);
        $params = [$id_poisson, $id_poisson, $num_facture, $sortie, $qtt, $qtt, $classpss, $pdetail];
        if ($insertStmt->execute($params)) {
            echo "Détails insérés avec succès.";
            ?>
            <script>
                document.location.href = "traitement.php?num=<?= $num_facture ?>";
            </script>
            <?php
        } else {
            echo "Erreur lors de l'insertion des détails.";
        }
    }
}
?>
