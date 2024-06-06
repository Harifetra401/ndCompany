<?php
    require('../db.php');
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
      $num = $_POST["num"];
      $id_sortie = $_POST["id_sortie"];
      $sortieqtt = $_POST["sortieqtt"];
      
      $supr = "DELETE FROM `sortie` WHERE id_sortie=$id_sortie";
      $del = $db->prepare($supr);
      $del -> execute();
      
      
      $sql = "INSERT INTO sortie(`id_sortie`, `sortieqtt`) VALUES ($id_sortie, '".$sortieqtt."')";
        $stmt = $db->prepare($sql);

        if ($stmt->execute()) {
            ?>
                <script>
                    document.location.href = "traitement.php?num=<?=$num?>";
                </script>
           <?php
        } else {
            echo " $sql Erreur lors de l'insertion des sortieqttervation filao.";
        }
    
    }
?>
