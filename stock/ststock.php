<?php
require('../db.php');
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $poisson = $_POST["poisson"];
    $id_sortie = $_POST["id_sortie"];
    $qtt = $_POST["qtt"];
    $sac = $_POST["sac"];
    $place = 1;

    $selection = $db->prepare("SELECT * FROM stockf WHERE id = $poisson");
    $selection->execute();
    $fetchAll = $selection->fetch();
    if ($fetchAll['qtt'] - $qtt < 0) {
?>
        <script>
            alert ('stock insuffisant pour<?= $fetchAll['nomfilao'] ?>');
        </script>
        <script>
            document.location.href = "../chargement?id=<?= $id_sortie ?>";
        </script>
        <?php
    } else {
        $sql01 = $db->prepare("UPDATE stockf SET qtt = qtt - $qtt WHERE id = $poisson");
        $sql01->execute();


       

        ?>
            <script>
                document.location.href = "../chargement?id=<?= $id_sortie ?>";
            </script>
<?php
        } 
    }

?>