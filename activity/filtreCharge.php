<?php
    require('../db.php');
    $num = $_GET["num"];
    $month = $_GET["month"];  // Mois sélectionné
    $year = $_GET["year"];    // Année sélectionnée

    // Préparer la requête pour vérifier si l'id_sortie existe dans facturesortie avec le mois et l'année sélectionnés
    $selection = $db->prepare("
        SELECT dfs.*, fs.date 
        FROM detailfilaosortie dfs
        JOIN facturesortie fs ON dfs.id_sortie = fs.id_sortie
        WHERE dfs.id_sortie = :num
        AND MONTH(fs.date) = :month
        AND YEAR(fs.date) = :year
    ");
    $selection->execute(['num' => $num, 'month' => $month, 'year' => $year]);
    $fetchAll = $selection->fetchAll();

    function getNomPoisson($id_selector) {
        require('../db.php');
        $getBy = $db->prepare("SELECT nomFilao FROM poisson WHERE id = :id_selector");
        $getBy->execute(['id_selector' => $id_selector]);
        $fetchBy = $getBy->fetch();
        
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
        $totalSac += ($typ == 1) ? $sac_poisson : 0;
        $totalCarton += ($typ == 2) ? $sac_poisson : 0;
        $totalbac += ($typ == 3) ? $sac_poisson : 0;
        
        // Conditionally display sac_poisson or carton_poisson
        $displayValue = ($typ == 1) ? $sac_poisson . "&nbsp;&nbsp;&nbsp;(Sac)" : 
            (($typ == 2) ? $sac_poisson . "&nbsp;&nbsp;&nbsp;(Carton)" : 
            $sac_poisson . "&nbsp;&nbsp;&nbsp;(Bac)");

        ?>
        <tr>
            <td></td>
            <td><i class="fab fa-angular fa-lg text-danger me-3"></i> <strong><?= getNomPoisson($id_poisson) ?></strong></td>
            <td><?= $displayValue ?></td>
            <td><?= $qtt_poisson ?></td>
            <td></td>
        </tr>
        <?php
    }
?>
