
<?php

        require('../db.php');
        $sql = "SELECT * FROM facturesortie ORDER BY id  DESC LIMIT 7";
        $stmt = $db->prepare($sql);
        $stmt->execute();
    
        $all_facture = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
?>


<div class="container-fluid flex-grow-1 container-p-y col-md-8 col-lg-8 order-3 mb-8">
    <div class="card">
              <h3 class="color-primary card-header"> Liste des Chargement Effectué</h3>
              <div class="table-responsive text-nowrap">
                <table class="table">
                  <thead>
                    <tr class="text-nowrap">
                      <th>   </th>
                      <th><strong>Numéro</strong></th>
                      <th><strong>Date</strong></th>
                      
                    </tr>
                </thead>
                <tbody>
                    <!-- selection des facture aujourd'hui -->
                    
                    
                    <?php foreach ($all_facture as $get_fact) : ?>
                        <tr>
                            <th>   </th>
                            <th scope="row"><?=$get_fact['id']?></th>
                            <td><?=$get_fact['date']?></td>
                            <td>
                            <a class="btn btn-success" href="../activity/charge_one.php?num=<?=$get_fact['id']?>">
                                Plus de détail
                            </a>
                        </td>
                    </tr>
                    <?php endforeach; ?>

                        <tr>
                            <td colspan="4">
                            <center>
                                    <a href="../activity/chargement.php">Voir plus ></a>
                                </center>
                            </td>
                        </tr>
                  </tbody>
                </table>
              </div>
            </div>
            <!--/ Layout Demo -->
          </div>