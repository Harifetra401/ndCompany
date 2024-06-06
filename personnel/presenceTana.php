<?php

function is_present($id_selector)
{
  require('../db.php');
  $getBy = $db->prepare("SELECT * FROM present WHERE id_personnel=$id_selector AND date(`date`)=CURDATE()");
  $getBy->execute();
  $fetchBy = $getBy->fetch();
  return ($fetchBy);
}

require('../db.php');
$sql_personnel = "SELECT * FROM personnel WHERE poste='Antananarivo' ORDER BY nom ASC";
$stmt_personnel = $db->prepare($sql_personnel);
$stmt_personnel->execute();

$stmt_personnel_pre = $stmt_personnel->fetchAll(PDO::FETCH_ASSOC);

?>


<!-- <div class="container-fluid flex-grow-1 container-p-y col-md-8 col-lg-12 order-2 mb-12"> -->

  <div class="card">
    <h5 class="card-header">Fiche de presence</h5>
    <div class="table-responsive text-nowrap">
      <table class="table">
        <thead>
          <tr class="text-nowrap">
            <th>Nom</th>
            <th>Debut</th>
            <th>Fin</th>
            <!-- <th>H. Supplementaire</th> -->
            <th>Presence</th>

          </tr>
        </thead>
        <tbody>
          <!-- selection des facture aujourd'hui -->


          <?php foreach ($stmt_personnel_pre as $get_per_pre) : ?>
            <tr class="tr">
              <td><?= ($get_per_pre['nom']) ?></td>
              <?php
              if (!is_present($get_per_pre['id'])["id"]) {
              ?>
                <form action="present.php" method="post">
                  <td>
                    <input type="hidden" name="id" value="<?= $get_per_pre['id'] ?>" />
                    <input type="time" name="debut" required />
                  </td>
                  <td>
                    <input type="time" name="fin" required />
                  </td>
                  <!-- <td>
                    <input type="time" name="suple" /> H
                  </td> -->
                  <td>
                    <button type="submit" class="btn btn-success" title="Marquer <?= ($get_per_pre['nom']) ?> comme present">
                      Absent
                    </button>
                  </td>
                </form>
              <?php
              } else {
              ?>
                <td><?= (is_present($get_per_pre['id'])["debut"]) ?></td>
                <td><?= (is_present($get_per_pre['id'])["fin"]) ?></td>
                <td>OK</td>
                <td> </td>
                <td>
                  <a class="btn btn-primary" title="Marquer <?= ($get_per_pre['nom']) ?> comme absent" href="absent.php?id=<?= $get_per_pre['id'] ?>">
                    Present
                  </a>
                </td>
              <?php
              }
              ?>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>
  <!--/ Layout Demo -->
</div>


</div>