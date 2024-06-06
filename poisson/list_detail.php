    <?php
    require('../db.php');
    $numeroFacture = $_GET["numFact"];
    $selection = $db->prepare("SELECT * FROM detailfilao WHERE NumFac=$numeroFacture");
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
    $total = 0;
    $total_poid = 0;
    foreach ($fetchAll as $fetch) {
      $id_poisson = getNomPoisson($fetch['id_poisson']);
      $qtt_poisson = $fetch['qtt'];
      $id = $fetch['id'];
      $prix_poisson = $fetch['prixUnit'];
      $total += ($qtt_poisson * $prix_poisson);
      $total_poid += $qtt_poisson;
    ?>

      <tr>
        <td><i class="fab fa-angular fa-lg text-danger me-3"></i> <strong><?= $id_poisson ?>
          </strong></td>
        <td><?= $qtt_poisson ?></td>
        <td>
          <?= $prix_poisson ?>
        </td>
        <td><?= ($qtt_poisson * $prix_poisson) ?></td>
        <td>
          <div class="dropdown">
            <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
              <i class="bx bx-dots-vertical-rounded"></i>
            </button>
            <div class="dropdown-menu">
              <a class="dropdown-item" href="delete.php?id=<?= $id ?>&numFact=<?= $_GET['numFact'] ?>&id_fournisseur=<?= $_GET['id_fournisseur'] ?>"><i class="bx bx-trash me-1"></i>
                Suprimer</a>
            </div>
          </div>
        </td>
      </tr>

    <?php

    }
    ?>
    </table>