<?php
    $fact_num = $_GET['num'];
    $get_text = $db -> prepare("SELECT * FROM facture WHERE id=$fact_num");
    $get_text -> execute();
    $fetch_text = $get_text -> fetch();
    if ($fetch_text["text"]=='non'){
?>
<a class="btn btn-success" href="payer.php?id=<?=$_GET['num']?>">
                            Marquer comme payer
                            </a>
                            <?php
    } else {
    ?>
                            <a class="btn btn-primary" href="non_payer.php?id=<?=$_GET['num']?>">
                            Marquer comme non payer
</a>
<?php
}
?>