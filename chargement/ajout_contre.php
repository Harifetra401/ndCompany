<?php
require('../db.php');
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $num = $_POST["num"];
    $poisson = $_POST["id_poisson"];
    $qtt = $_POST["qtt"];


    $sql01 = $db->prepare("UPDATE ventetana SET qtt = qtt + $qtt WHERE id = $poisson");
    $sql01->execute();

    $sql = "INSERT INTO apres_charge(`num`, `id_poisson`,`qtt`) VALUES ($num, $poisson, $qtt)";
    // echo $sql;
    $stmt = $db->prepare($sql);

    if ($stmt->execute()) {
?>
        <script>
            document.location.href = "contrepese.php?num=<?= $num ?>";
        </script>
<?php
    } else {
        echo " $sql Erreur lors de l'insertion des datail filao.";
    }
}
?>