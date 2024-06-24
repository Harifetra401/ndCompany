<?php
require('../db.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $poisson = $_POST["poisson"];
    $qtt = $_POST["qtt"];
    $sac = $_POST["sac"];
    $typ = $_POST["typ"];
    $daty = $_POST['daty'];
    $place = 1;

    // Use prepared statements to prevent SQL injection
    $selection = $db->prepare("SELECT * FROM stockf WHERE id = ?");
    $selection->execute([$poisson]);
    $fetchAll = $selection->fetch();

    if ($fetchAll['qtt'] - $qtt < 0) {
        ?>
        <script>
            alert('Stock insuffisant pour <?= htmlspecialchars($fetchAll['nomfilao']) ?>');
            document.location.href = "../stock";
        </script>
        <?php
    } else {
        // Use prepared statements for the update and insert queries
        $sql01 = $db->prepare("UPDATE stockf SET qtt = qtt - ? WHERE id = ?");
        $sql01->execute([$qtt, $poisson]);

        $sql = "INSERT INTO detailfilaosortieStock(`id_poisson`, `sac`, `qtt`, `typ`, `place`, `date`) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $db->prepare($sql);

        if ($stmt->execute([$poisson, $sac, $qtt, $typ, $place,  $daty])) {
            ?>
            <script>
                document.location.href = "../stock/sortieStock.php";
            </script>
            <?php
        } else {
            echo "Erreur lors de l'insertion des détails de filao.";
        }
    }
}
?>
