<?php 
require('../db.php');

        $sql = "SELECT id, nomfilao FROM poisson ORDER BY nomfilao";
        $stmt = $db->prepare($sql);
        $stmt->execute();
    
        $filaos = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($filaos as $filao) : ?>
            <option value="<?= $filao['nomfilao'] ?>"><?= $filao['nomfilao'] ?></option>
          <?php endforeach; ?>