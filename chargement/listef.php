<?php
require('../db.php');
$id_sortie = $_GET["num"];
//$selection = $db->prepare("SELECT id_poisson, SUM(sac) AS total_sac, SUM(qtt) AS total_qtt FROM detailfilaosortie WHERE id_sortie=$id_sortie GROUP BY id_poisson ORDER BY id_poisson DESC");
$selection = $db->prepare("SELECT id_poisson, SUM(sac) AS total_sac, SUM(qtt) AS total_qtt FROM detailfilaosortie WHERE id_sortie=$id_sortie GROUP BY id_poisson ORDER BY id_poisson DESC");
$selection->execute();
$fetchAll = $selection->fetchAll();

function getNomPoisson($id_selector)
{
    require('../db.php');
    $getBy = $db->prepare("SELECT nomFilao FROM poisson WHERE id=$id_selector");
    $getBy->execute();
    $fetchBy = $getBy->fetch();
    return $fetchBy["nomFilao"];
}

foreach ($fetchAll as $fetch) {
    $id_poisson = getNomPoisson($fetch['id_poisson']);
    $qtt_poisson = $fetch['total_qtt'];
    $nombre_sac = $fetch['total_sac'];

?>

    <tr>
        <td><i class="fab fa-angular fa-lg text-danger me-3"></i> <strong><?= $id_poisson ?></strong></td>
        <td><?= $qtt_poisson ?></td>
        <td>
            <?= $nombre_sac ?>
        </td>
    </tr>

<?php
}
?>
</table>