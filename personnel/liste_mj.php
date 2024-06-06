<?php

require('../db.php');
$sql = "SELECT * FROM personnel WHERE poste='$ville' ORDER BY nom ASC";
$stmt = $db->prepare($sql);
$stmt->execute();

$all_personne = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>


<div class="container-fluid flex-grow-1 container-p-y col-md-12 col-lg-12 order-2 mb-12">
  <div class="card">
    <h5 class="card-header"> Liste Des Personnel a <?= $ville ?></h5>
    <div class="table-responsive text-nowrap">
      <table class="table">
        <thead>
          <tr class="text-nowrap">
            <th>Nom</th>
            <th>Contact</th>

          </tr>
        </thead>
        <tbody>
          <!-- selection des facture aujourd'hui -->


          <?php foreach ($all_personne as $get_per) : ?>
            <tr class="tr">
              <td><?= ($get_per['nom']) ?></td>
              <td><?= $get_per['contact'] ?></td>
              <td>
                <a class="btn btn-danger sup" href="sup.php?id=<?= $get_per['id'] ?>">
                  Suprimer
                </a>
              </td>
              <td>
                <a class="btn btn-primary sup" href="profil.php?id=<?= $get_per['id'] ?>">
                  Détail
                </a>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>
  <!--/ Layout Demo -->
</div>