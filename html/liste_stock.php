
<?php

        require('../db.php');
        $sql = "SELECT * FROM stock ORDER BY id DESC LIMIT 7";
        $stmt = $db->prepare($sql);
        $stmt->execute();
    
        $all_facture = $stmt->fetchAll(PDO::FETCH_ASSOC);

        function getNomPoisson($id_selector) {
            require('../db.php');
            $getBy = $db -> prepare("SELECT nomFilao FROM poisson WHERE id=$id_selector");
            $getBy -> execute();
            $fetchBy = $getBy -> fetch();
            return $fetchBy["nomFilao"];
        }
    
?>


<div class="container-fluid flex-grow-1 container-p-y col-md-8 col-lg-8 order-3 mb-8">
    <div class="card">
              <h5 class="card-header"> Liste des Stocks Effectué</h5>
              <div class="table-responsive text-nowrap">
                <table class="table">
                  <thead>
                    <tr class="text-nowrap">
                      <th>Nom poisson</th>
                      <th>Poid</th>
                      <th>Nombre du sac</th>
                      <th>Date</th>
                      
                    </tr>
                </thead>
                <tbody>
                    <!-- selection des facture aujourd'hui -->
                    
                    
                    <?php foreach ($all_facture as $get_fact) : ?>
                        <tr>
                            <th scope="row"><?=getNomPoisson($get_fact['id_poisson'])?></th>
                            <td><?=($get_fact['qtt'])?></td>
                            <td><?=($get_fact['nombre_sac'])?></td>
                            <td><?=$get_fact['date']?></td>
                    </tr>
                    <?php endforeach; ?>

                        <tr>
                            <td colspan="4">
                            <center>
                                    <a href="../activity/all_stock.php">Voir tout ></a>
                                </center>
                            </td>
                        </tr>
                  </tbody>
                </table>
              </div>
            </div>
            <!--/ Layout Demo -->
          </div>