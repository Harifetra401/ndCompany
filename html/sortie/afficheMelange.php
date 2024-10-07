

<?php
// Inclure la connexion à la base de données
require('../../db.php'); 

// Vérifiez que la date est définie
if (isset($_GET['date'])) {
    $date = $_GET['date'];

    $sql = "SELECT * FROM testStock WHERE EnterDate = :date AND traiteTyp ='Melange'";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':date', $date);
    $stmt->execute();
    $stocks = $stmt->fetchAll(PDO::FETCH_ASSOC);
} else {
    $stocks = [];
}
$TotalEnter = 0;
?>





        <table class="table table-bordered mt-3">
            <thead>
                <tr>
                                            <th>Articles</th>
                                            <th>Ret Hier</th>
                                            <th>Entrer</th>
                                            <th>Poids (kg)</th>
                                            <th>Colis type</th>
                                            <th>Nbr colis</th>
                                            <th>Retour</th>
                                            <th>Sortie</th>
                    
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($stocks)): ?>
                
                    <?php foreach ($stocks as $stock):
                        $id = (float) htmlspecialchars($stock['id']);
                        $retourhiere = (float) htmlspecialchars($stock['retourhiere']);
                        $PEnter = (float) htmlspecialchars($stock['PEnter']);
                        $sortie = (float) htmlspecialchars($stock['sortie']);
                        $retour = (float) htmlspecialchars($stock['retour']);
                        $qtt = (float) htmlspecialchars($stock['qtt']);
                        $Type = (float) htmlspecialchars($stock['type']);
                        $TotalEnter += $qtt;
                        $TotalColis += $stock['sac'];
                       
                        ?>
                        <tr>
                                                    <form action="../../stock/update.php" method="POST">
                                                        <td>
                                                            <?= htmlspecialchars($stock['nom_poisson']) ?>
                                                            <input type="hidden" class="form-control w-50" value="<?=$id?>" name="id">
                                                            <input type="hidden" class="form-control w-50" value="<?= htmlspecialchars($stock['nom_poisson']) ?>" name="nom_poisson">
                                                        </td>
                                                        
                                                        <td><input type="text" class="ntrol w-100" value='<?= number_format((float)$retourhiere, 2) ?>' name="retHier"></td>
                                                        <td><input type="text" class="form-cntrol w-100" value="<?= number_format((float)$PEnter, 2) ?>" name="enter"></td>
                                                        <td>
                                                            <input type="hidden" class="form-cotrol w-100" value="0" name="poisson">
                                                            <input type="text" class="form-conrol w-100" value='<?= number_format((float)$qtt, 2) ?>' name="qtt">
                                                        </td>
                                                        <td><select name="type" class="form-control">
                                                                <?php if(($stock['type']) == 1) {
                                                                    ?>
                                                                    <option value="1">en Sac</option>
                                                                    <option value="2">en Carton</option>
                                                                    <?php
                                                               
                                                                } else if (($stock['type']) == 2){
                                                                ?>
                                                                    <option value="2">en Carton</option>
                                                                    <option value="1">en Sac</option>
                                                                   
                                                                    <?php
                                                                }?>
                                                                
                                                            </select>
                                                        </td>
                                                      
                                                        <td><input type="text" class="form-cotrol w-100" value='<?= htmlspecialchars($stock['sac']) ?>' name="sac"></td>
                                                        <td><input type="text" class="form-cotrol w-100" name="retour" value='<?= number_format((float)$retour, 2) ?>'></td>
                                                        <td><input type="text" class="form-cotrol w-100" name="sortie" value='<?= number_format((float)$sortie, 2) ?>'></td>
                                                        <td>
                                                            <input type="hidden" class="form-control w-50" value="<?=$date?>" name="EnterDate">
                                                            <input type="submit" value="OK" class="form-control d-none btn-success">
                                                            <a href='delete.php?id=<?= htmlspecialchars($id, ENT_QUOTES, 'UTF-8') ?>&date=<?= htmlspecialchars($_GET['date'], ENT_QUOTES, 'UTF-8') ?>'>supprimer</a>
                                                        </td>
                                                    </form>
                        </tr>
                        
                                                    

                    <?php endforeach; ?>
                    
                <?php else: ?>
                    <tr>
                        <td colspan="11">Aucun enregistrement trouvé.</td>
                    </tr>
                <?php endif; ?>

            </tbody>
        
       