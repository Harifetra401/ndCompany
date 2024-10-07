<?php

require ('../db.php');

$sql = "SELECT * FROM particulier ORDER BY id DESC";
$stmt = $db->prepare($sql);
$stmt->execute();

$all_facture = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>
<div class="container-fluid flex-grow-1 container-p-y col-md-8 col-lg-8 order-3 mb-8">
  <div class="card">
    <h5 class="card-header"> Liste Achats Effectué</h5>
    <div class="table-responsive text-nowrap">
      <table class="table">
        <thead>
          <tr class="text-nowrap">
            <th>Num Fact</th>
            <th>fournisseur</th>
            <th>Poid</th>
            <th>Date</th>
            <th>Somme</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($all_facture as $get_fact):
            if (poid_total($get_fact['id']) > 0) {
              ?>
              <tr>
                <th scope="row"><?= $get_fact['id'] ?></th>
                <td><?= $get_fact['client'] ?></td>
                
                <td><?= $get_fact['date'] ?></td>
                <td> </td>
                <td>
                  <a class="btn btn-success" href="../activity/facture.php?num=<?= $get_fact['id'] ?>">
                    Consulter
                  </a>
                </td>
              </tr>
            <?php }endforeach; ?>

          <tr>
            <td colspan="4">
              <center>
                <a href="../activity/">Voir tout ></a>
              </center>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
  <!--/ Layout Demo -->
</div>