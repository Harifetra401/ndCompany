<?php
    require('../db.php');
    $numeroFacture = $_GET["num"];
    $selection = $db -> prepare("SELECT * FROM detailfilao WHERE NumFac=$numeroFacture");
    $selection -> execute();
    $fetchAll = $selection -> fetchAll();

    function getNomPoisson($id_selector) {
        require('../db.php');
        $getBy = $db -> prepare("SELECT nomFilao FROM poisson WHERE id=$id_selector");
        $getBy -> execute();
        $fetchBy = $getBy -> fetch();
        return $fetchBy["nomFilao"];
    }
$total = 0;
    foreach($fetchAll as $fetch){
        $id_poisson = getNomPoisson($fetch['id_poisson']);
        $qtt_poisson = $fetch['qtt'];
        $prix_poisson = $fetch['prixUnit'];
        $total += ($qtt_poisson * $prix_poisson);

        ?>

<tr>
                                  <td><i class="fab fa-angular fa-lg text-danger me-3"></i> <strong><?=$id_poisson?>
                                    </strong></td>
                                  <td><?=$qtt_poisson?></td>
                                  <td>
                                  <?=$prix_poisson?>
                                  </td>
                                  <td><?=($qtt_poisson * $prix_poisson)?></td>
                                  
                                </tr>

        <?php

    }
    ?>