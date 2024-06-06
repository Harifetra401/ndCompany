<?php
require('../db.php');
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST["id"];
    $poisson = $_POST["poisson"];
    $qtt = $_POST["qtt"];
    $pu = $_POST["pu"]* $qtt;

    //select apres charge
    $selection = $db->prepare("SELECT * FROM ventetana WHERE id = $poisson");
    $selection->execute();
    $fetchAll = $selection->fetch();
    if ($fetchAll['qtt'] - $qtt < 0) {
        ?>
                <script>
                    alert('stock insuffisant pour<?= $fetchAll['nomfilao'] ?>');
                </script>
                <script>
                    document.location.href = "../ventetana/?id=<?=$id?>";
                </script>
                <?php
            } else {
                $sql01 = $db->prepare("UPDATE ventetana SET qtt = qtt - $qtt WHERE id = $poisson");
                $sql01->execute();
                $sql = "INSERT INTO filaolafo(`id`,`id_poisson`, `qtt`, `prix`) VALUES ($id, $poisson, $qtt, $pu)";
                $stmt = $db->prepare($sql);
        
                if ($stmt->execute()) {
                ?>
                    <script>
                        document.location.href = "../ventetana/?id=<?=$id?>";
                    </script>
        <?php
                } else {
                    echo " $sql Erreur lors de l'insertion des datail filao.";
                }
            }}