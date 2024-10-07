<?php
$id_sortie = $get_fact["id"];
require ('../db.php');
$num = $_GET['num'];
$selection_obs = $db->prepare("SELECT * FROM sortie WHERE id_sortie = :id_sortie");
$selection_obs->bindParam(':id_sortie', $id_sortie, PDO::PARAM_INT);
$selection_obs->execute();
$fetch_obs = $selection_obs->fetch();
?>

<td id="sortiefilao">
    <?php
    if ($fetch_obs === false || $fetch_obs["sortieqtt"] === null) {
    ?>
        <!-- Improved Modal -->
        

        <!-- Improved Button -->
         <form action="sortie.php" method="post">
                            <input type="hidden" name="num" value="<?= htmlspecialchars($numeroFacture) ?>">
                            <input type="hidden" value="<?= htmlspecialchars($id_sortie) ?>" name="id_sortie" />
                            <input type="hidden" name="" value="<?= htmlspecialchars($get_fact['qtt']) ?>" id="">
                            <div class="mb-3">
                                
                                <input type="text" value='0' class="form-control" id="sortieqtt" name="sortieqtt" autocomplete="off"
                                    placeholder="Entrez la quantité">
                            </div>
                           
                        </form>
    <?php
    } else {
        $sortie = $fetch_obs["sortieqtt"];
        echo htmlspecialchars($sortie);
    }
    ?>
</td>
