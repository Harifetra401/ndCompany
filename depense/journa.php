<?php
if (isset($_POST['mois'])) {
    // Get the selected month
    $selectedMonth = $_POST['mois'];

    // Redirect to the new page with the selected month
    header("Location: journal.php?date=" . urlencode($selectedMonth));
    exit();
}
?>
