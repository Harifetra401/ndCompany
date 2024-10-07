<?php
require('../db.php');

if (!isset($_GET["id"])) {
    echo "ID not provided.";
    exit();
}

if (!isset($_GET["qtt"])) {
    echo "Quantity not provided.";
    exit();
}

if (!isset($_GET["id_poisson"])) {
    echo "Poisson ID not provided.";
    exit();
}

$id = $_GET["id"];
$qttdel = $_GET["qtt"];
$id_poissondel = $_GET["id_poisson"];
$numeroFacture = 100;
$daty = date("Y-m-d H:i:s");

// Ensure $id is an integer and $qttdel is a double
if (!filter_var($id, FILTER_VALIDATE_INT) || !is_numeric($qttdel)) {
    echo "Invalid ID or quantity.";
    exit();
}

try {
    // Delete from stock
   
    
    // Update quantity in chbr table
    $stmt02 = $db ->prepare("INSERT INTO chbr (numeroFacture, idPoisson, poissonType, qtt, created_at) VALUES (:numeroFacture, :idPoisson, :poissonType, :poidd, :daty)");
    
        $stmt02->bindParam(':numeroFacture', $numeroFacture);
        $stmt02->bindParam(':idPoisson', $id_poissondel);
        $stmt02->bindParam(':poissonType', $id_poissondel);
        $stmt02->bindParam(':poidd', $qttdel);
        $stmt02->bindParam(':daty', $daty);
    
    if ($stmt02->execute()) {
        echo "Stock item with ID $id has been successfully deleted. Quantity updated for poisson ID $id_poissondel.";
    } else {
        echo "Failed to update quantity for poisson ID $id_poissondel.";
    }
     $sql = "DELETE FROM `stock` WHERE id = :id";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
} catch (PDOException $e) {
    echo "Error during stock deletion: " . $e->getMessage();
}
?>
