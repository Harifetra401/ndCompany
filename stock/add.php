<?php
require('../db.php');
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $poisson = $_POST["poisson"];
    $qtt = $_POST["qtt"];
    $sac = $_POST["sac"];
    $place = 1;
    
    
    $_SESSION['emplacement'] = $place == 1 ? "eto" : "any";
    $sql01 = $db->prepare("UPDATE stockf SET qtt = qtt + $qtt WHERE id = $poisson");
    $sql01->execute();
    $sql = "INSERT INTO stock(`id_poisson`, `qtt`, `nombre_sac`, `place`) VALUES ($poisson, $qtt, $sac, $place)";
    $stmt = $db->prepare($sql);
    if ($stmt->execute()) {
    ?>
                <script>
                    document.location.href = "../stock";
                </script>
    <?php
    } else {
        echo " $sql Erreur lors de l'insertion des detail filao.";
    }
    }
        
   
?>