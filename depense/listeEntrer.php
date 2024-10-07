<?php
require ('../db.php');

// Récupérer le mois sélectionné à partir du formulaire
$selected_month = isset($_GET['month']) ? htmlspecialchars($_GET['month']) : date('Y-m');

// Préparation et exécution de la sélection des dépenses pour le mois sélectionné
$selection = $db->prepare("SELECT * FROM entrer WHERE DATE_FORMAT(date, '%Y-%m') = :selected_month");
$selection->bindParam(':selected_month', $selected_month, PDO::PARAM_STR);
$selection->execute();
$fetchAll = $selection->fetchAll();

// Fonction pour calculer le coût total des dépenses pour le mois sélectionné
function poid_total1($selected_month) {
    require('../db.php');
    $total = 0;
    $selection = $db->prepare("SELECT cout FROM entrer WHERE DATE_FORMAT(date, '%Y-%m') = :selected_month");
    $selection->bindParam(':selected_month', $selected_month, PDO::PARAM_STR);
    $selection->execute();
    $fetchAll = $selection->fetchAll();

    foreach ($fetchAll as $fetch) {
        $total += $fetch['cout'];
    }
    return $total;
}
?>

<!-- Formulaire de filtre par mois -->
<div class="container mt-4">
    <form method="GET" action="" class="row g-3 align-items-center mb-4">
        <div class="col-auto">
            <label for="month" class="col-form-label">Sélectionner le mois :</label>
        </div>
        <div class="col-auto">
            <input type="month" id="month" name="month" class="form-control" value="<?= $selected_month ?>">
        </div>
        <div class="col-auto">
            <button type="submit" class="btn btn-primary">Filtrer</button>
        </div>
    </form>
</div>

<!-- Affichage des dépenses filtrées -->
<div class="container mt-4">
    <div class="alert alert-info text-center">
        <h6>Coût Total pour <?= $selected_month ?> :</h6> 
        <strong><?= number_format(poid_total1($selected_month), 2, ',', ' ') ?> AR</strong>
    </div>
</div>
<div class="container">
    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>Libellé</th>
                <th>Coût</th>
                <th>Description</th>
                <th>Date</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
        <?php if ($fetchAll): ?>
            <?php foreach ($fetchAll as $fetch): ?>
                <tr>
                    <td><?= htmlspecialchars($fetch['libelle']) ?></td>
                    <td><?= number_format($fetch['cout'], 2, ',', ' ') ?> AR</td>
                    <td><?= htmlspecialchars($fetch['description']) ?></td>
                    <td><?= htmlspecialchars($fetch['date']) ?></td>
                    <td>
                        <div class="dropdown">
                            <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                <i class="bx bx-dots-vertical-rounded"></i>
                            </button>
                            <div class="dropdown-menu">
                                <a class="dropdown-item" href="delete.php?id=<?= $fetch['id'] ?>"><i class="bx bx-trash me-1"></i> Supprimer</a>
                            </div>
                        </div>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="5" class="text-center">Aucune dépense trouvée pour ce mois.</td>
            </tr>
        <?php endif; ?>
        </tbody>
    </table>
</div>

<!-- Affichage du coût total -->

