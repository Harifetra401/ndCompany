<?php
    require('../db.php');

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
        $sql_old = "SELECT MAX(id) AS idprec FROM facturetana";
        $exe = $db->prepare($sql_old);
        $exe->execute();
        $resul = $exe -> fetch(); 
        if ($resul["idprec"]) {
            $idnews = $resul["idprec"] + 1;
        }else{
            $idnews = 1;
        }
        

        $sql = "INSERT INTO facturetana(`id`) VALUES ('$idnews')";
        $stmt = $db->prepare($sql);

        if ($stmt->execute()) {
            $sql_new = "SELECT MAX(id) AS id FROM facturetana";
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
                window.document.location.href = "../ventetana?id=<?=$newNumFact?>";
            </script>
            <?php
        } else {
            echo "$sql Erreur lors de l'insertion des données.";
        }
    }

?>