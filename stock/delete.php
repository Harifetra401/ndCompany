<?php
    require ('../db.php');
    
    if (!isset($_GET["id"])) {
        echo "ID not provided.";
        exit();
    }

    $id = $_GET["id"];

    // Ensure $id is an integer
    if (!filter_var($id, FILTER_VALIDATE_INT)) {
        echo "Invalid ID.";
        exit();
    }

    try {
        // Use prepared statements to prevent SQL injection
        $sql = "DELETE FROM `stock` WHERE id = :id";
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        echo "Stock item with ID $id has been successfully deleted.";
    } catch (PDOException $e) {
        echo "Error during stock deletion: " . $e->getMessage();
    }
?>
