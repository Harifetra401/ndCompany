<?php
    require('../db.php');

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $qtt = $_POST["qtt"];
        $id_poisson = $_POST["id_poisson"];
        $num_facture = $_POST['num'];
        echo $qtt." / ".$id_poisson." / ".$num_facture;

        $sql = "INSERT INTO detailfilaocontre(`id_poisson`, `NumFac`, `qtt`) VALUES ($id_poisson, $num_facture, $qtt)";
        $stmt = $db->prepare($sql);

        if ($stmt->execute()) {
            ?>
                <script>
                    document.location.href = "traitement.php?num=<?=$num_facture?>";
                </script>
           <?php
        } else {
            echo " $sql Erreur lors de l'insertion des datail filao.";
        }
    
    }
?>

