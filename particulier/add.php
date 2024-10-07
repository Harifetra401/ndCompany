<?php
    require('../db.php');
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $id = $_POST["id"];
      $poisson = $_POST["poisson"];
      $qtt = $_POST["qtt"];
      $pu = $_POST["pu"]* $qtt;
        
        $sql = "INSERT INTO particulier(`id`,`id_poisson`, `qtt`, `prix`) VALUES ($id, $poisson, $qtt, $pu)";
        $stmt = $db->prepare($sql);

        if ($stmt->execute()){
            ?> 
                <script>
                    document.location.href = "../particulier/?id=<?=$id?>"; 
                </script>
           <?php
        } else {
            echo " $sql Erreur filao.";
        }
    
    }
?>