<?php
    require('../db.php');
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
      $num = $_POST["num"];
      $id_obs = $_POST["id_obs"];
      $obs = $_POST["obs"];
      
      $supr = "DELETE FROM `observation` WHERE id_obs=$id_obs";
      $del = $db->prepare($supr);
      $del -> execute();
      
      
      $sql = "INSERT INTO observation(`id_obs`, `obs`) VALUES ($id_obs, '".$obs."')";
        $stmt = $db->prepare($sql);

        if ($stmt->execute()) {
            ?>
                <script>
                    document.location.href = "traitement.php?num=<?=$num?>";
                </script>
           <?php
        } else {
            echo " $sql Erreur lors de l'insertion des observation filao.";
        }
    
    }
?>
