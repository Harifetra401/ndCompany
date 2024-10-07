<?php
// Connection to the database
require '../../db.php'; // Adjust path as necessary

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_poisson = $_POST['id_poisson'];
    $poisson =$_POST['poiss'];
    $date = $_POST['date'];
    $enterTranche = $_POST['enterTranche'];
    $Tranchecolis = $_POST['Tranchecolis'];
    $emballage = $_POST['emballage'];
    $TeteTranche = $_POST['TeteTranche'];
        // If no record exists, insert a new one
        $insertQuery = "INSERT INTO tranche (id_poisson, poisson, date, enterTranche, Tranchecolis, emballage, TeteTranche)
                        VALUES (:id_poisson, :poisson, :date, :enterTranche, :Tranchecolis, :emballage, :TeteTranche)";
        $insertStmt = $db->prepare($insertQuery);
        $insertStmt->execute([
            ':id_poisson' => $id_poisson,
            ':poisson' => $poisson,
            ':date' => $date,
            ':enterTranche' => $enterTranche,
            ':Tranchecolis' => $Tranchecolis,
            ':emballage' => $emballage,
            ':TeteTranche' => $TeteTranche
        ]);
        

    // Redirect or display a success message
    header('Location: success.php');
    exit();
}
?>
