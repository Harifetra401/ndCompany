<?php
require ('../db.php');
$selection = $db->prepare("SELECT * FROM depence WHERE date(`date`)=CURDATE()");
$selection->execute();
$fetchAll = $selection->fetchAll();


function poid_total($date) {
  require('../db.php');
  $total = 0;
  $selection = $db -> prepare("SELECT cout FROM depence WHERE date(`date`)=CURDATE()");
  $selection -> execute();
  $fetchAl = $selection -> fetchAll();

  foreach($fetchAl as $fetch){
      $qtt_poisson = $fetch['cout'];
      $total += ($qtt_poisson);
  }
  return $total;
}

foreach ($fetchAll as $fetch) {
  $id = $fetch['id'];
  $libelle = $fetch['libelle'];
  $cout = $fetch['cout'];
  $description = $fetch['description'];
  ?>

  <tr>
    <?php 
      if ($libelle == 1) {
        echo '<td>Depenses administratives</td>';
      } else if ($libelle == 2) {
        echo '<td>Depenses operationnelles</td>';
      } else if ($libelle == 3) {
        echo '<td>Depenses  approvisionnelles</td>';
      }
?>
    
    <td>
      <?= $cout ?> AR
    </td>
    <td><?= ($description) ?></td>
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
</table>
<h1>
  <?=poid_total($date['date'])?>
</h1>
