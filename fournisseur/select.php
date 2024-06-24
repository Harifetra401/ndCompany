<?php
    require('../db.php');

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $fournisseur = $_POST["fournisseur"];
        $date = $_POST["date"];

        $sql = "SELECT MAX(id) AS id FROM facture";
        $stmt = $db->prepare($sql);
        $stmt->execute();
        $resultat = $stmt -> fetch(); 
        if ($resultat["id"]) {
            $newNumFact = $resultat["id"]+1;
        } else {
            $newNumFact = 1;
        }


        
        $creatNewFact = "INSERT INTO facture(`id`, `id_fou`, `totalapayee`,`payee`,`restapayer`, `date`) VALUES ($newNumFact, $fournisseur, 0, 0 ,0, $date)";
        $validation = $db->prepare($creatNewFact);

        if ($validation->execute()) {
           ?>
                <script>
                   document.location.href = "../html/FactureAchat.php?id_fournisseur=<?=$fournisseur?>&numFact=<?=$newNumFact?>";
                </script>
           <?php
        } else {
            echo "Erreur a l'ajout de nouveau facture des données.";
        }
        
    }
?>