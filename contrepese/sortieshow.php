<?php
$id_sortie = $get_fact["id"];
require ('../db.php');
$num = $_GET['num'];
$selection_obs = $db->prepare("SELECT * FROM sortie WHERE id_sortie=$id_sortie");
$selection_obs->execute();
$fetch_obs = $selection_obs->fetch();
?>

<td id="sortiefilao">
    <?php
    if (empty($fetch_obs["sortieqtt"])) {
        $sortie = 0
            ?>
        <!-- Improved Modal -->
        <div class="modal fade" id="basicModl" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel1">Sortie</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="sortie.php" method="post">
                            <input type="hidden" name="num" value="<?= $numeroFacture ?>">
                            <input type="hidden" value="<?= $id_sortie ?>" name="id_sortie" />
                            <div class="mb-3">
                                <label for="sortieqtt" class="form-label">Quantité Sortie</label>
                                <input type="text" class="form-control" id="sortieqtt" name="sortieqtt" autocomplete="off"
                                    placeholder="Entrez la quantité">
                            </div>
                            <button type="submit" class="btn btn-primary">Valider</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Improved Button -->
        <button type="button" class="btn btn-secondary d-grid w-100" data-bs-toggle="modal" data-bs-target="#basicModl">
            Sortie
        </button>

        <?php
    } else {
        $sortie = $fetch_obs["sortieqtt"];
        ?>
        <?= $sortie ?>

        <?php
    }
    ?>

</td>