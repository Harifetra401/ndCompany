<?php

require ('../db.php');
// $range = !empty($_SESSION["emplacement"]) ? ($_SESSION["emplacement"] == "eto" ? 1 : 2) : 1;

// $selection1 = $db->prepare("SELECT SUM(nombre_sac)  AS total_sac,SUM(qtt) AS total_qtt FROM stock WHERE date(`date`)=CURDATE()");
// $selection1->execute();
// $fetchAll1 = $selection1->fetchAll();


$selection = $db->prepare("SELECT id_poisson, SUM(nombre_sac) AS total_sac, SUM(qtt) AS total_qtt, type AS tp FROM stock WHERE date(`date`)=CURDATE()  GROUP BY id_poisson ORDER BY id_poisson DESC");
$selection->execute();
$fetchAll = $selection->fetchAll();

// selection du total poid au jourd'hui
$selection_poid_all = $db->prepare("SELECT id_poisson, SUM(qtt) AS total_qtt_all FROM stock WHERE date(`date`)=CURDATE()");
$selection_poid_all -> execute();
$fetchAll_poid_all = $selection_poid_all -> fetchAll();
$total_poid_all = $fetchAll_poid_all[0]['total_qtt_all'];

// selection du sac (type=0) au jourd'hui
$selection_sac_all = $db->prepare("SELECT id_poisson, SUM(nombre_sac) AS total_sac FROM stock WHERE date(`date`)=CURDATE() AND type=1");
$selection_sac_all -> execute();
$fetchAll_sac_all = $selection_sac_all -> fetchAll();
$total_sac_all = $fetchAll_sac_all[0]['total_sac'];

// selection du carton (type=2) au jourd'hui
$selection_carton_all = $db->prepare("SELECT id_poisson, SUM(nombre_sac) AS total_carton FROM stock WHERE date(`date`)=CURDATE() AND type=2");
$selection_carton_all -> execute();
$fetchAll_carton_all = $selection_carton_all -> fetchAll();
$total_carton_all = $fetchAll_carton_all[0]['total_carton'];


foreach ($fetchAll as $fetch) {
  $id_poisson = getNomPoisson($fetch['id_poisson']);
  $qtt_poisson = $fetch['total_qtt'];
  // $id = $fetch['id'];
  $nombre_sac = $fetch['total_sac'];
  // $place = $fetch['place'];
  $type = $fetch['tp'];


?>

  <tr>
    <td><i class="fab fa-angular fa-lg text-danger me-3"></i> <strong><?= $id_poisson ?>
      </strong></td>
    <td><?= $qtt_poisson ?></td>
    <td>
      <?php
        if ($type==1) {
          ?>
           <?= $nombre_sac ?> <?= '(Sac)' ?>
           <?php
        }elseif ($type==2) {
          ?>
           <?= $nombre_sac ?> <?= '(Carton)' ?>
           <?php
        }
      ?>
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

   