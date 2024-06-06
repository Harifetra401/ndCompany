<?php

        require('../db.php');
        $sql = "SELECT id, nomfournisseur FROM fournisseur ORDER BY nomfournisseur";
        $stmt = $db->prepare($sql);
        $stmt->execute();
    
        $fournisseurs = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
?>
 <?php foreach ($fournisseurs as $fournisseur) : ?>
       <option value="<?= $fournisseur['id'] ?>"><?= $fournisseur['nomfournisseur'] ?> <br></option>
 <?php endforeach; ?>