<?php
    require('../db.php');

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
        $sql_old = "SELECT MAX(id) AS idprec FROM factmj";
        $exe = $db->prepare($sql_old);
        $exe->execute();
        $resul = $exe -> fetch(); 
        if ($resul["idprec"]) {
            $idnews = $resul["idprec"] + 1;
        }else{
            $idnews = 1;
        }
        

        $sql = "INSERT INTO factmj(`id`) VALUES ('$idnews')";
        $stmt = $db->prepare($sql);

        if ($stmt->execute()) {
            $sql_new = "SELECT MAX(id) AS id FROM factmj";
            $execute = $db->prepare($sql_new);
            $execute->execute();
            $resultat = $execute -> fetch(); 
            if ($resultat["id"]) {
                $newNumFact = $resultat["id"];
            } else {
                $newNumFact = 1;
            }
            ?>
            <script>
                window.document.location.href = "../particulier?id=<?=$newNumFact?>";
            </script>
            <?php
        } else {
            echo "$sql Erreur lors de l'insertion des données.";
        }
    }

?>