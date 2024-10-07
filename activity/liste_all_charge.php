<?php
    require('../db.php');
    $num = $_GET["num"];
    $selection = $db -> prepare("SELECT * FROM detailfilaosortie WHERE id_sortie = :num");
    $selection -> execute(['num' => $num]);
    $fetchAll = $selection -> fetchAll();

    function getNomPoisson($id_selector) {
        require('../db.php');
        $getBy = $db -> prepare("SELECT nomFilao FROM poisson WHERE id = :id_selector");
        $getBy -> execute(['id_selector' => $id_selector]);
        $fetchBy = $getBy -> fetch();
        
        // Check if fetchBy returned a valid result
        if ($fetchBy) {
            return $fetchBy["nomFilao"];
        } else {
            return "Unknown";  // Return a default value if no match is found
        }
    }

    $total = 0;
    $totalColis = 0;

    foreach ($fetchAll as $fetch) {
        $id_poisson = $fetch['id_poisson'];
        $qtt_poisson = $fetch['qtt'];
        $sac_poisson = $fetch['sac'];
        $typ = $fetch['typ'];  // assuming there's a 'typ' column
        $place_poisson = $fetch['place'];

        $total += $qtt_poisson;
        $totalSac += ($typ == 1) ? $sac_poisson: 0;
        $totalCarton += ($typ == 2) ? $sac_poisson: 0;
        $totalbac += ($typ == 3) ? $sac_poisson: 0;
        // Conditionally display sac_poisson or carton_poisson
         $displayValue = ($typ == 1) ? $sac_poisson."&nbsp;&nbsp;&nbsp;(Sac)" : 
               (($typ == 2) ? $sac_poisson."&nbsp;&nbsp;&nbsp;(Carton)" : 
               $sac_poisson."&nbsp;&nbsp;&nbsp;(Bac)");

        ?>
        <tr>
            <td></td>
            <td><i class="fab fa-angular fa-lg text-danger me-3"></i> <strong><?= $id_poisson ?></strong></td>
            <td><?= $displayValue ?></td>
            <td><?= $qtt_poisson ?></td>
            <td></td>
        </tr>
        <?php
    }
?>
