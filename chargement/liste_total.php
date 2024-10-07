<?php
require ('../db.php');
    $id_sortie = $_GET['id'];

    $sql = "SELECT * FROM detailfilaosortie WHERE id_sortie = :id_sortie";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':id_sortie', $id_sortie);
    $stmt->execute();
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);


foreach ($results as $row) {


    ?>

    <tr>
        <td><i class="fab fa-angular fa-lg text-danger me-3"></i> <strong><?= htmlspecialchars($row['id_poisson']) ?></strong></td>
        <td><?= htmlspecialchars($row['qtt']) ?></td>
        <td><?= htmlspecialchars($row['sac']) ?> <?= htmlspecialchars($row['typ']) ?></td>
      
    </tr>

    <?php
}
?>
</table>


