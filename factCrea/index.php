<?php
require('../db.php');

$sql = "SELECT id, nomfilao FROM poisson";
$stmt = $db->prepare($sql);
$stmt->execute();

$filaos = $stmt->fetchAll(PDO::FETCH_ASSOC);

if (isset($_GET['id'])) {
    $fournisseurId = $_GET['id'];
    $sql = "SELECT id, nomfournisseur, Adress, contact FROM fournisseur WHERE id = :fournisseurId";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(":fournisseurId", $fournisseurId, PDO::PARAM_INT);
    $stmt->execute();

    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($row) {
        echo "<h1>Détails du Fournisseur</h1>";
   
        ?>
        <?php echo $row['id']?>
            <form action="back.php" method="post">
                <input type='hidden' name='idFournisseur' value='<?php echo $row['id']?>'>
                <input type="number" name="NumFac" id=""><br>
                <label for="filao">Sélectionnez un filao :</label>
                <select id="poisson updateDiv"  name="poisson">
                    
                    <?php foreach ($filaos as $filao) : ?>
                        <option value="<?= $filao['id'] ?>"><?= $filao['nomfilao'] ?> <br></option>
                    <?php endforeach; ?>
                </select><br>
                <input type="text" id="Qtt" name="qtt"><br>
                <input type="text" id="Pu" name="pu"><br>
                <input type='hidden' name='prixtotal' value=''>

                <input type="submit" value="Ajouter">
                </form>   
                
            </form>
        <?php
    }


    
}
?>