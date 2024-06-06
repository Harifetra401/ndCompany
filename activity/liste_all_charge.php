<?php
    require('../db.php');
    $num = $_GET["num"];
    $selection = $db -> prepare("SELECT * FROM detailfilaosortie WHERE id_sortie=$num");
    $selection -> execute();
    $fetchAll = $selection -> fetchAll();

    function getNomPoisson($id_selector) {
        require('../db.php');
        $getBy = $db -> prepare("SELECT nomFilao FROM poisson WHERE id=$id_selector");
        $getBy -> execute();
        $fetchBy = $getBy -> fetch();
        return $fetchBy["nomFilao"];
    }
    foreach($fetchAll as $fetch){
        $id_poisson = getNomPoisson($fetch['id_poisson']);
        $qtt_poisson = $fetch['qtt'];
        $sac_poisson = $fetch['sac'];
        $place_poisson = $fetch['place'];
        ?>

<tr>
                                  <td><i class="fab fa-angular fa-lg text-danger me-3"></i> <strong><?=$id_poisson?>
                                    </strong></td>
                                  <td><?=$qtt_poisson?></td>
                                  <td>
                                  <?=$sac_poisson?>
                                  </td>
                                  <td><?=($place_poisson==1?"interne":"externe")?></td>
                                  
                                </tr>

        <?php

    }
    ?>