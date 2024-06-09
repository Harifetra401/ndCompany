<?php
require('../db.php');
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $poisson = $_POST["poisson"];

    $qtt = $_POST["qtt"];
    $sac = $_POST["sac"];
    $place = 1;

    $selection = $db->prepare("SELECT * FROM stockf WHERE id = $poisson");
    $selection->execute();
    $fetchAll = $selection->fetch();
    if ($fetchAll['qtt'] - $qtt < 0) {
?>
        <script>
            alert('stock insuffisant pour<?= $fetchAll['nomfilao'] ?>');
        </script>
        <script>
            document.location.href = "../sortieStock.php";
        </script>
        <?php
    } else {
        $sql01 = $db->prepare("UPDATE stock SET qtt = qtt - $qtt WHERE id = $poisson");
        // $sql01->execute();


        // $sql = "INSERT INTO detailfilaosortie(`id_poisson`, `sac`, `qtt`, `id_sortie`, `place`) VALUES ($poisson, $sac, $qtt, $id_sortie, $place)";
        // $stmt = $db->prepare($sql);

        if ($sql01->execute()) {
        ?>
            <script>
                alert('ghdfghsfgh')
            </script>
<?php
        } else {
            echo " Erreur lors de l'insertion des datail filao.";
        }
    }
}
?>