<?php 
require('../db.php');

        $sql = "SELECT id, nomfilao FROM ventetana";
        $stmt = $db->prepare($sql);
        $stmt->execute();
    
        $filaos = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($filaos as $filao) : ?>
            <option value="<?= $filao['id'] ?>"><?= $filao['nomfilao'] ?></option>
          <?php endforeach; ?>