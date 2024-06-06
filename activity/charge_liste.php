<?php
        function liste($param, $query, $ordre) {
        require('../db.php');
        $sql = "SELECT * FROM facturesortie $param ORDER BY $query $ordre";
        $stmt = $db->prepare($sql);
        $stmt->execute();
    
        $all_facture = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
?>


<div class="container-fluid flex-grow-1 container-p-y ">
    <div class="card">
              <div class="table-responsive text-nowrap">
                <table class="table">
                  <thead>
                    <tr class="text-nowrap">
                      <th>Numéro</th>
                      <th>Destination</th>
                      <th>Date</th>
                      
                    </tr>
                </thead>
                <tbody>
                    <!-- selection des facture aujourd'hui -->
                    
                    
                    <?php foreach ($all_facture as $get_fact) : ?>
                        <tr>
                            <th scope="row"><?=$get_fact['id']?></th>
                            <td><?=($get_fact['destination'])?></td>
                            <td><?=$get_fact['date']?></td>
                            <td>
                            <a href="../activity/charge_one.php?num=<?=$get_fact['id']?>">
                                Consulter >
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
    liste("", "id", $_POST["try"]);
  }
  if($_POST["search"]=="id_fou"){
    liste("", "destination", $_POST["try"]);
  }
}else{
  liste("", "id", "DESC");
}
?>