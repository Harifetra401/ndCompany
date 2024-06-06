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
        // require('prix_one_facture.php');
        // require('poid_one_facture.php');
        $sql = "SELECT * FROM facturesortie ORDER BY id DESC";
        $stmt = $db->prepare($sql);
        $stmt->execute();
    
        $all_facture = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
?>
 <?php foreach ($all_facture as $get_fact) : 
            ?>
    <tr>
        <th scope="row"><?=$get_fact['id']?></th>
        <td><?=$get_fact['date']?> </td>
        <td>
            <a class="btn btn-success" href="contrepese.php?num=<?=$get_fact['id']?>">
                Traiter
            </a>
        </td>
    </tr>
    <?php endforeach; ?>   