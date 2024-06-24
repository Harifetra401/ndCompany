<?php
require('../db.php');

// Assuming $ville is defined or passed into the script. Example:
// $ville = 'SomeVille';
if (!isset($ville)) {
    $ville = 'DefaultVille'; // Or fetch it from request parameters or another source
}

$sql_personnel = "SELECT * FROM personnel WHERE poste=:ville ORDER BY id ASC";
$stmt_personnel = $db->prepare($sql_personnel);
$stmt_personnel->execute(['ville' => $ville]);
$stmt_personnel_pre = $stmt_personnel->fetchAll(PDO::FETCH_ASSOC);

// Check if the is_present function is already defined before defining it
if (!function_exists('is_present')) {
    function is_present($id_selector)
    {
        global $db;
        $stmt = $db->prepare("SELECT * FROM present WHERE id_personnel = :id_personnel AND DATE(date) = CURDATE()");
        $stmt->execute(['id_personnel' => $id_selector]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}

?>

<div class="container-fluid flex-grow-1 container-p-y col-md-8 col-lg-12 order-2 mb-12">
    <div class="card">
        <h5 class="card-header">Fiche de presence <?= htmlspecialchars($ville) ?></h5>
        <div class="table-responsive text-nowrap">
            <a href="abs<?= htmlspecialchars($ville) ?>.php" class="btn btn-primary">Suivie de presence</a>
            <table class="table">
                <thead>
                    <tr class="text-nowrap">
                        <th>Nom</th>
                        <th>Debut</th>
                        <th>Fin</th>
                        <th>Presence</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($stmt_personnel_pre as $get_per_pre) : ?>
                        <?php $presence = is_present($get_per_pre['id']); ?>
                        <tr class="tr">
                            <td><?= htmlspecialchars($get_per_pre['nom']) ?></td>
                            <?php if (!$presence) : ?>
                                <form action="present.php" method="post">
                                    <td>
                                        <input type="hidden" name="id" value="<?= htmlspecialchars($get_per_pre['id']) ?>" />
                                        <input type="time" name="debut" required />
                                    </td>
                                    <td>
                                        <input type="time" name="fin" required />
                                    </td>
                                    <td>
                                        <input type="date" name="daty" id="">
                                    </td>
                                    <td>
                                        <button type="submit" class="btn btn-success" title="Marquer <?= htmlspecialchars($get_per_pre['nom']) ?> comme present">
                                            Absent
                                        </button>
                                    </td>
                                </form>
                            <?php else : ?>
                                <td><?= htmlspecialchars($presence["debut"]) ?></td>
                                <td><?= htmlspecialchars($presence["fin"]) ?></td>
                                <td>OK</td>
                                <td>
                                    <a class="btn btn-primary" title="Marquer <?= htmlspecialchars($get_per_pre['nom']) ?> comme absent" href="absent.php?id=<?= htmlspecialchars($get_per_pre['id']) ?>">
                                        Present
                                    </a>
                                </td>
                            <?php endif; ?>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
    <!--/ Layout Demo -->
</div>
