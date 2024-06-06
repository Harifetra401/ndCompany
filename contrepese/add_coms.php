<?php
    require('../db.php');
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
      $num_fact = $_POST["num_fact"];
      $coms = $_POST["coms"];
      
      $supr = "DELETE FROM `traitement_coms` WHERE num_fact=$num_fact";
      $del = $db->prepare($supr);
      $del -> execute();
      
      
      $sql = "INSERT INTO traitement_coms(`num_fact`, `text`) VALUES ($num_fact, '".$coms."')";
        $stmt = $db->prepare($sql);

        if ($stmt->execute()) {
            ?>
                <script>
                    document.location.href = "traitement.php?num=<?=$num_fact?>";
                </script>
           <?php
        } else {
            echo " $sql Erreur lors de l'insertion des datail filao.";
        }
    
    }
?>