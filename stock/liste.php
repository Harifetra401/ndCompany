<?php

require ('../db.php');

function getNomPoisson($db, $id_selector)
{
    $getBy = $db->prepare("SELECT nomFilao FROM poisson WHERE id = :id");
    $getBy->bindParam(':id', $id_selector, PDO::PARAM_INT);
    $getBy->execute();
    $fetchBy = $getBy->fetch(PDO::FETCH_ASSOC);
    return $fetchBy["nomFilao"] ?? null;
}

try {
    // Fetch stock grouped by id
    $selection = $db->prepare("
        SELECT id, id_poisson, SUM(nombre_sac) AS total_sac, SUM(qtt) AS total_qtt, `type` AS tp 
        FROM stock 
        WHERE date(`date`) = CURDATE() 
        GROUP BY id 
        ORDER BY id DESC
    ");
    $selection->execute();
    $fetchAll = $selection->fetchAll(PDO::FETCH_ASSOC);

    // Selection of total weight today
    $selection_poid_all = $db->prepare("
        SELECT SUM(qtt) AS total_qtt_all 
        FROM stock 
        WHERE date(`date`) = CURDATE()
    ");
    $selection_poid_all->execute();
    $fetchAll_poid_all = $selection_poid_all->fetch(PDO::FETCH_ASSOC);
    $total_poid_all = $fetchAll_poid_all['total_qtt_all'] ?? 0;

    // Selection of sac (type=1) today
    $selection_sac_all = $db->prepare("
        SELECT SUM(nombre_sac) AS total_sac 
        FROM stock 
        WHERE date(`date`) = CURDATE() AND `type` = 1
    ");
    $selection_sac_all->execute();
    $fetchAll_sac_all = $selection_sac_all->fetch(PDO::FETCH_ASSOC);
    $total_sac_all = $fetchAll_sac_all['total_sac'] ?? 0;

    // Selection of carton (type=2) today
    $selection_carton_all = $db->prepare("
        SELECT SUM(nombre_sac) AS total_carton 
        FROM stock 
        WHERE date(`date`) = CURDATE() AND `type` = 2
    ");
    $selection_carton_all->execute();
    $fetchAll_carton_all = $selection_carton_all->fetch(PDO::FETCH_ASSOC);
    $total_carton_all = $fetchAll_carton_all['total_carton'] ?? 0;

    foreach ($fetchAll as $fetch) {
        $id_poisson1 = getNomPoisson($db, $fetch['id_poisson']);
        $qtt_poisson1 = $fetch['total_qtt'];
        $id = $fetch['id'];
        $nombre_sac = $fetch['total_sac'];
        $type = $fetch['tp'];

?>

  <tr>
    <td><i class="fab fa-angular fa-lg text-danger me-3"></i> <strong><?= htmlspecialchars($id_poisson1, ENT_QUOTES, 'UTF-8') ?></strong></td>
    <td><?= htmlspecialchars($qtt_poisson1, ENT_QUOTES, 'UTF-8') ?></td>
    <td>
      <?php if ($type == 1): ?>
        <?= htmlspecialchars($nombre_sac, ENT_QUOTES, 'UTF-8') ?> (Sac)
      <?php elseif ($type == 2): ?>
        <?= htmlspecialchars($nombre_sac, ENT_QUOTES, 'UTF-8') ?> (Carton)
      <?php endif; ?>
    </td>
    <td>
      <div class="dropdown">
        <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
          <i class="bx bx-dots-vertical-rounded"></i>
        </button>
        <div class="dropdown-u">
          <a class="dropdown-item" href="../stock/delete.php?id=<?= urlencode($id) ?>&qtt=<?= urlencode($qtt_poisson1) ?>&id_poisson=<?= urlencode($fetch['id_poisson']) ?>"><i class="bx bx-trash me-1"></i> Supprimer</a>
        </div>
      </div>
    </td>
  </tr>

<?php
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
