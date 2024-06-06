<?php
require('../db.php');
$selection = $db->prepare("SELECT * FROM detailavant WHERE qtt!=0 ORDER BY id DESC");
$selection->execute();
$fetchAll = $selection->fetchAll();

// function getNomPoisson($id_selector)
// {
//     require('../db.php');
//     $getBy = $db->prepare("SELECT nomFilao FROM poisson WHERE id=$id_selector");
//     $getBy->execute();
//     $fetchBy = $getBy->fetch();
//     return $fetchBy["nomFilao"];
// }

foreach ($fetchAll as $fetch) {
    $id_poisson = getNomPoisson($fetch['idfilao']);
    $nom_poisson = getNomPoisson($fetch['id_poisson']);

    $qtt_poisson = $fetch['lanja'];
    $qttclic = $fetch['qtt'];
    $id = $fetch['id'];


?>

    <tr>
        <td><i class="fab fa-angular fa-lg text-danger me-3"></i> <strong><?= $id_poisson ?>
            </strong></td>
        <td><?= $nom_poisson ?></td>

        <?php
        if ($qttclic != 0) {
        ?>

            <td>
                <form action="updatefilao.php" method="post">
                    <input type="hidden" name="qttf" value="<?= $qtt_poisson ?>">
                    <input type="hidden" name="idf" value="<?= $id ?>">
                    <select name="newid" class="form-control" id="">
                        <?= require("../poisson/liste.php"); ?>
                    </select>
            </td>
            <td>
                <input class="btn btn-primary" onclick="disableButton()" id="<?= $id . $qtt_poisson ?>" type="submit" value="ok">
                </form>
                <script>
                    // function disableButton(){
                    //     document.getElementById("").disabled =true;
                    // }
                </script>
            <td><?php
            } else {
                ?>
            <td> 
                <input class="btn btn-danger" disabled id="<?= $id . $qtt_poisson ?>" type="submit" value="ok">
            </td>
            <td></td>

        <?php
            }
        ?>

        </td>
    </tr>
<?php

}
?>
</table>