<?php

require ('../db.php');
// $range = !empty($_SESSION["emplacement"]) ? ($_SESSION["emplacement"] == "eto" ? 1 : 2) : 1;

// $selection1 = $db->prepare("SELECT SUM(nombre_sac)  AS total_sac,SUM(qtt) AS total_qtt FROM stock WHERE date(`date`)=CURDATE()");
// $selection1->execute();
// $fetchAll1 = $selection1->fetchAll();


$selection = $db->prepare("SELECT id_poisson, SUM(nombre_sac) AS total_sac, SUM(qtt) AS total_qtt FROM stock WHERE date(`date`)=CURDATE()  GROUP BY id_poisson ORDER BY id_poisson DESC");
$selection->execute();
$fetchAll = $selection->fetchAll();



foreach ($fetchAll as $fetch) {
  $id_poisson = getNomPoisson($fetch['id_poisson']);
  $qtt_poisson = $fetch['total_qtt'];
  // $id = $fetch['id'];
  $nombre_sac = $fetch['total_sac'];
  // $place = $fetch['place'];


?>

  <tr>
    <td><i class="fab fa-angular fa-lg text-danger me-3"></i> <strong><?= $id_poisson ?>
      </strong></td>
    <td><?= $qtt_poisson ?></td>
    <td>
      <?= $nombre_sac ?>
    </td>
    <td>
      <div class="dropdown">
        <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
          <i class="bx bx-dots-vertical-rounded"></i>
        </button>
        <div class="dropdown-menu">
          <a class="dropdown-item" href="delete.php?id=<?= $id ?>"><i class="bx bx-trash me-1"></i>
            Suprimer</a>
        </div>
      </div>
    </td>
  </tr>

<?php

}
?>

   