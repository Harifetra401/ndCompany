 <?php
    require('../db.php');

    $selection = $db->prepare("SELECT * FROM chbrfroid");
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
      $id_poisson = getNomPoisson($fetch['article']);
      $qtt_poisson = $fetch['qtt'];
      $id = $fetch['id'];

      $total_poid += $qtt_poisson;
    ?>

      <tr>
        <td><i class="fab fa-angular fa-lg text-danger me-3"></i> <strong><?= $id_poisson ?>
          </strong></td>
        <td><?= $qtt_poisson ?></td>

        
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
      <tr>
    <td colspan="3" align="right"><strong>Total :</strong></td>
    <td><strong><?= $total_poid ?></strong></td>
  </tr>
    </table>