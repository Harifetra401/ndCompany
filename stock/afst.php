<?php
// display.php

// Assuming you have a database connection file called db_connect.php
require('../db.php');

// Prepare SQL query to fetch data from the table
$sql = "SELECT * FROM testStock";
$stmt = $db->prepare($sql);
$stmt->execute();

// Fetch all records
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Display Data</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 8px;
            text-align: left;
        }
    </style>
</head>
<body>
    <h2>Stock Data</h2>
    <table>
        <tr>
            <th>Article</th>
            <th>Retour Hier</th>
            <th>PEnter</th>
            <th>Total</th>
            <th>Poids</th>
            <th>Type</th>
            <th>Sac</th>
            <th>Retour</th>
            <th>Sortie</th>
            <th>Desication</th>
            <th>Enter Date</th>
        </tr>
        <?php foreach ($results as $row): ?>
        <tr>
            <td><?php echo htmlspecialchars($row['nom_poisson']); ?></td>
            <td><?php echo htmlspecialchars($row['retourhiere']); ?></td>
            <td><?php echo htmlspecialchars($row['PEnter']); ?></td>
            <td><?php echo htmlspecialchars($row['PEnter']) + htmlspecialchars($row['retourhiere']); ?></td>
            <td><?php echo htmlspecialchars($row['qtt']); ?></td>
            <td><?php if (htmlspecialchars($row['type']) == 1){echo 'Sac';} else if  (htmlspecialchars($row['type']) == 2){echo 'Carton';}; ?></td>
            <td><?php echo htmlspecialchars($row['sac']); ?></td>
            <td><?php echo htmlspecialchars($row['retour']); ?></td>
            <td><?php echo htmlspecialchars($row['sortie']); ?></td>
            <td><?php echo 100 - ((100 * htmlspecialchars($row['qtt']))/((htmlspecialchars($row['PEnter']) + htmlspecialchars($row['retourhiere'])) - (htmlspecialchars($row['retour'])+htmlspecialchars($row['sortie'])))); ?> %</td>
            <td><?php echo htmlspecialchars($row['EnterDate']); ?></td>
        </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>

<?php
// Close the connection
$stmt = null;
$db = null;
?>
