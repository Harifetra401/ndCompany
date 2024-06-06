<?php
    require('../db.php');

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $qtt = $_POST["qtt"];
        $id_poisson = $_POST["id_poisson"];
        $num_facture = $_POST['num'];
        $classpss = $_POST['classpss'];
        $pdetail = $_POST['pdetail'];
        // $anarana = $_POST['anarana'];
        // echo $qtt." / ".$id_poisson." / ".$num_facture;

        $sql = "INSERT INTO `detailavant`(`idfilao`, `id_poisson`, `NumFac`, `qtt`,`lanja`, `class`, `pdetail`) VALUES ($id_poisson, $id_poisson, $num_facture, $qtt, $qtt, $classpss, $pdetail)";
        $stmt = $db->prepare($sql);
        if ($stmt->execute()) {
            echo "Erreur lors de l'insertion des detail filao.";
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

