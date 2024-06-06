<?php
    require('../db.php');

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $poisson = $_POST["poisson"];
        $cat = $_POST["cat"];
        $class= 1;
        $qtt = $_POST["qtt"];
        $pu = $_POST["pu"];
        $fournisseur = $_POST["id_fournisseur"];
        $numFact = $_POST["numFact"];
        // echo " $poisson $qtt $pu $fournisseur $numFact";
        
        
        $sql = "INSERT INTO detailfilao(`id_poisson`,`catgr`,  `classe`, `qtt`, `prixUnit`, `NumFac`, `idFournisseur`) VALUES ($poisson, $cat, $class, $qtt, $pu, $numFact, $fournisseur)";
        $stmt = $db->prepare($sql);

        if ($stmt->execute()) {
            ?>
                <script>
                    document.location.href = "../html/FactureAchat.php?id_fournisseur=<?=$fournisseur?>&numFact=<?=$numFact?>";
                </script>
           <?php
        } else {
            echo " $sql Erreur lors de l'insertion des datail filao.";
        }
    
    }
?>