<?php


        function getNomPoisson($id_selector) {
          require('../db.php');
          $getBy = $db -> prepare("SELECT nomFilao FROM poisson WHERE id=$id_selector");
          $getBy -> execute();
            $fetchBy = $getBy -> fetch();
            return $fetchBy["nomFilao"];
          }
          
          function liste($param, $query, $ordre) {
          require('../db.php');
          $sql = "SELECT * FROM stock $param ORDER BY $query $ordre";
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

                  </tbody>
                </table>
              </div>
            </div>
            <!--/ Layout Demo -->
          </div>

          <?php
}

if(isset($_POST["btn_search"])){
  if($_POST["search"]=="date"){
    $new_date = $_POST["date"];
    if(!empty($new_date)) {
    // echo "WHERE date(`date`)=$new_date id ".$_POST['try'];
    liste("WHERE date(`date`)='".$new_date."'", "id", $_POST["try"]);
    }else{
      liste("WHERE date(`date`)=CURDATE()", "id", $_POST["try"]);
    }
  }
  if($_POST["search"]=="id"){
    echo "<i>Auccun numero a trier!</i>";
  }
  if($_POST["search"]=="id_fou"){
    liste("", "id_poisson", $_POST["try"]);
  }
}else{
  liste("", "id", "DESC");
}
?>