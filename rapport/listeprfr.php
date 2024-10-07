<?php
require('../db.php');
require('../facture/prix_one_facture.php');
require('../facture/poid_one_facture.php');

// Function to get the supplier name
function get_namepr($id_to_get) {
    require('../db.php');
    $new_sql = "SELECT * FROM fournisseur WHERE id = :id";
    $new_st = $db->prepare($new_sql);
    $new_st->bindParam(':id', $id_to_get, PDO::PARAM_INT);
    $new_st->execute();
    $fetch_name = $new_st->fetch();
    return $fetch_name["nomfournisseur"];
}

// Get the date range and selected month from the form submission
$start_date = isset($_POST['start_date']) ? $_POST['start_date'] : '';
$end_date = isset($_POST['end_date']) ? $_POST['end_date'] : '';
$selected_month = isset($_POST['month']) ? $_POST['month'] : '';

// Adjust the query based on the provided date range and month
$sql = "SELECT * FROM facture WHERE 1=1";
if ($start_date && $end_date) {
    $sql .= " AND date BETWEEN :start_date AND :end_date";
}
if ($selected_month) {
    $sql .= " AND MONTH(date) = :selected_month";
}
$sql .= " ORDER BY id DESC";

$stmt = $db->prepare($sql);

if ($start_date && $end_date) {
    $stmt->bindParam(':start_date', $start_date);
    $stmt->bindParam(':end_date', $end_date);
}
if ($selected_month) {
    $stmt->bindParam(':selected_month', $selected_month);
}

$stmt->execute();
$all_facture = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Group the data by supplier and sum the weights
$supplier_data = [];
foreach ($all_facture as $facture) {
    $supplier_id = $facture['id_fou'];
    $supplier_name = get_namepr($supplier_id);
    $weight = poid_total($facture['id']);
    $nbr = nbr_total($facture['id']);
    if (!isset($supplier_data[$supplier_id])) {
        $supplier_data[$supplier_id] = [
            'name' => $supplier_name,
            'total_weight' => 0,
            'total_nbr' => 0,
            'latest_date' => $facture['date']
        ];
    }
    $supplier_data[$supplier_id]['total_weight'] += $weight;
    $supplier_data[$supplier_id]['total_nbr'] += $nbr;
    if ($facture['date'] > $supplier_data[$supplier_id]['latest_date']) {
        $supplier_data[$supplier_id]['latest_date'] = $facture['date'];
    }
}
?>

<div class="container mt-5">
    <!-- Form -->
    <form method="POST" action="">
        <div class="form-group">
            <label for="start_date">Start Date:</label>
            <input type="date" name="start_date" class="form-control" value="<?= $start_date ?>">
        </div>
        <div class="form-group">
            <label for="end_date">End Date:</label>
            <input type="date" name="end_date" class="form-control" value="<?= $end_date ?>">
        </div>
        <div class="form-group">
            <label for="month">Select Month:</label>
            <select name="month" class="form-control">
                <option value="">All</option>
                <?php for ($i = 1; $i <= 12; $i++): ?>
                    <option value="<?= str_pad($i, 2, '0', STR_PAD_LEFT) ?>" <?= (isset($_POST['month']) && $_POST['month'] == str_pad($i, 2, '0', STR_PAD_LEFT)) ? 'selected' : '' ?>>
                        <?= date("F", mktime(0, 0, 0, $i, 1)) ?>
                    </option>
                <?php endfor; ?>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Filter</button>
    </form>

    <!-- Table -->
    <table class="table table-bordered mt-5">
        <thead class="thead-dark">
            <tr>
                <th scope="col">Nom Fournisseur</th>
                <th scope="col">Poids Total</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($supplier_data as $supplier_id => $data): ?>
                <tr>
                    <td><?= $data['name'] ?></td>
                    <td><?= $data['total_weight'] ?> KG</td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
