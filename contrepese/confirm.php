<?php
    require('../db.php');

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
     
        $id_poisson = $_POST["id_poisson"];
        $num_facture = $_POST['num'];
       
        $sql = "INSERT INTO `confirmentrer`(`idfilao`, `id_poisson`, `NumFac`) VALUES ($id_poisson, $id_poisson, $num_facture)";
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

