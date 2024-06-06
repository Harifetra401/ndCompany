<?php
    require('../db.php');
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
      $id_poisson = $_POST["poisson"];
      $qtt = $_POST["qtt"];
      $bac = $_POST["bac"];
      echo "$id_poisson $qtt $bac";
        
        $sql = "INSERT INTO chargement_bac(`id_poisson`, `qtt`, `bac`) VALUES ($id_poisson, $qtt, $bac)";
        $stmt = $db->prepare($sql);

        if ($stmt->execute()) {
            ?>
                <script>
                    document.location.href = "../chargement_bac";
                </script>
           <?php
        } else {
            echo " $sql Erreur lors de l'insertion des chargement bac filao.";
        }
    
    }
?>