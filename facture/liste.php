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
        require('prix_one_facture.php');
        require('poid_one_facture.php');
        $sql = "SELECT * FROM facture ORDER BY id DESC";
        $stmt = $db->prepare($sql);
        $stmt->execute();
    
        $all_facture = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
?>
 <?php foreach ($all_facture as $get_fact) : 
        if(poid_total($get_fact['id']) >0 ){
            ?>
    <tr>
        <th scope="row"><?=$get_fact['id']?></th>
        <td><?=get_name($get_fact['id_fou'])?></td>
        <td><?=poid_total($get_fact['id'])?> KG</td>
        <td><?=$get_fact['date']?></td>
        <td><?=nbr_total($get_fact['id'])?></td>
        <td>
            <a class="btn btn-success" href="../contrepese/traitement.php?num=<?=$get_fact['id']?>">
                Traiter
            </a>
        </td>
    </tr>
    <?php } endforeach; ?>   