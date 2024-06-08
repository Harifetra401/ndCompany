<?php
require('../db.php');



function getNomPoisson($id_selector) {
    require('../db.php');
    $getBy = $db->prepare("SELECT nomFilao FROM poisson WHERE id = :id_selector");
    $getBy->bindParam(':id_selector', $id_selector, PDO::PARAM_INT);
    $getBy->execute();
    $fetchBy = $getBy->fetch();
    return $fetchBy["nomFilao"];
}

$total = 0;
$total_poid = 0;
?>



<?php
foreach ($fetchAll as $fetch) {
    $id_poisson = getNomPoisson($fetch['id_poisson']);
    $qtt_poisson = $fetch['qtt'];
    $nombre_sac = $fetch['prix'];
    $client = $fetch['client'];
    $id = $fetch['id'];
    $idc = $fetch['idc'];
    $total += ($qtt_poisson * $nombre_sac);
    $total_poid += $qtt_poisson;
?>

    <tr>
      <td><i class="fab fa-angular fa-lg text-danger me-3"></i> <strong><?= htmlspecialchars($id_poisson) ?></strong></td>
      <td><?= htmlspecialchars($qtt_poisson) ?></td>
      <td><?= htmlspecialchars($nombre_sac) ?></td>
      <td>
        <div class="dropdown">
          <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
            <i class="bx bx-dots-vertical-rounded"></i>
          </button>
          <div class="dropdown-menu">
            <a class="dropdown-item" href="delete.php?idc=<?= htmlspecialchars($idc) ?>&id=<?= htmlspecialchars($id) ?>"><i class="bx bx-trash me-1"></i> Supprimer</a>
          </div>
        </div>
      </td>
    </tr>

<?php
}
?>
  </tbody>
  
 
