<?php

        require('../db.php');
        $sql = "SELECT id, NOMS, PRENOMS, nomfournisseur FROM fournisseur ORDER BY nomfournisseur";
        $stmt = $db->prepare($sql);
        $stmt->execute();
    
        $fournisseurs = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
?>
 <?php foreach ($fournisseurs as $fournisseur) : ?>
       <option value="<?= $fournisseur['id'] ?>"><?= $fournisseur['NOMS'] ?> <?= $fournisseur['PRENOMS'] ?> (<?= $fournisseur['nomfournisseur'] ?>) <br></option>
 <?php endforeach; ?>