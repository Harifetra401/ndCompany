<?php
    $id_fournisseur = $_GET['id_fournisseur'];
    $fact_num = $_GET['numFact'];
    $get_text = $db -> prepare("SELECT * FROM facture WHERE id=$fact_num");
    $get_text -> execute();
    $fetch_text = $get_text -> fetch();
    if ($fetch_text["text"]!='oui'){
?>
<a class="btn btn-success" href="payement/payer.php?id_fournisseur=<?=$id_fournisseur?>&numFact=<?=$fact_num?>">
                            Marquer comme payer
                            </a>
                            <?php
    } else {
    ?>
                            <a class="btn btn-primary" href="payement/non_payer.php?id_fournisseur=<?=$id_fournisseur?>&numFact=<?=$fact_num?>">
                            Marquer comme non payer
</a>
<?php
}
?>