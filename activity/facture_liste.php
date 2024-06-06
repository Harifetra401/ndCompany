<?php

        function get_name($id_to_get) {
            require('../db.php');
        $new_sql = "SELECT * FROM fournisseur WHERE id = $id_to_get";
        $new_st = $db->prepare($new_sql);
        $new_st->execute();
        $fetch_name = $new_st -> fetch();
        return $fetch_name["nomfournisseur"];
        }

        function liste($param, $query, $ordre) {

        require('../db.php');
        $sql = "SELECT * FROM facture $param ORDER BY $query $ordre";
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
                      <th>NumFact</th>
                      <th>Fournisseur</th>
                      <th>Total a Payer</th>
                      <th>Payer</th>
                      <th>Reste</th>
                      <th>Date</th>
                      
                    </tr>
                </thead>
                <tbody>
                    <!-- selection des facture aujourd'hui -->
                    
                    
                    <?php foreach ($all_facture as $get_fact) : ?>
                        <tr>
                            <th scope="row"><?=$get_fact['id']?></th>
                            <td><?=get_name($get_fact['id_fou'])?></td>
                            <td><?=$get_fact['payee'] + $get_fact['restapayer'] ?></td>
                            <td><?=$get_fact['payee']?></td>
                            <td><?=$get_fact['restapayer']?></td>
                            <td><?=$get_fact['date']?></td>
                            <td>
                            <a href="../activity/facture.php?num=<?=$get_fact['id']?>">
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
    liste("", "id_fou", $_POST["try"]);
  }
}else{
  liste("", "id", "DESC");
}
?>