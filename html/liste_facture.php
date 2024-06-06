<?php

        function get_name($id_to_get) {
            require('../db.php');
        $new_sql = "SELECT * FROM fournisseur WHERE id = $id_to_get";
        $new_st = $db->prepare($new_sql);
        $new_st->execute();
        $fetch_name = $new_st -> fetch();
        return $fetch_name["nomfournisseur"];
        }

        require('../db.php');
        require('../facture/prix_one_facture.php');
        require('../facture/poid_one_facture.php');
        $sql = "SELECT * FROM facture ORDER BY id DESC";
        $stmt = $db->prepare($sql);
        $stmt->execute();
    
        $all_facture = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
?>
<div class="container-fluid flex-grow-1 container-p-y col-md-8 col-lg-8 order-3 mb-8">
    <div class="card">
              <h5 class="card-header"> Liste des Stocks Effectué</h5>
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
                  <?php foreach ($all_facture as $get_fact) : 
                          if(poid_total($get_fact['id']) >0 ){
                              ?>
                      <tr>
                          <th scope="row"><?=$get_fact['id']?></th>
                          <td><?=get_name($get_fact['id_fou'])?></td>
                          <td><?=poid_total($get_fact['id'])?> KG</td>
                          <td><?=$get_fact['date']?></td>
                          <td>Ar  <?=nbr_total($get_fact['id'])?> </td>
                          <td>
                              <a class="btn btn-success" href="../activity/facture.php?num=<?=$get_fact['id']?>">
                                                  Consulter
                                              </a>
                          </td>
                      </tr>
                      <?php } endforeach; ?>   

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