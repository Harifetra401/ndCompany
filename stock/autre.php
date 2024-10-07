<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    require('../db.php');

    // Sanitize and validate inputs
    $poisson = filter_input(INPUT_POST, 'poisson', FILTER_DEFAULT);
    $qtt = filter_input(INPUT_POST, 'qtt', FILTER_VALIDATE_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
    $sac = 0;
    $type = 5;
    $place = 1;

    session_start();
    $_SESSION['emplacement'] = $place == 1 ? "eto" : "any";

    try {
        $db->beginTransaction();

        // Fetch current quantity from 'chbr' table
        $sql01 = "SELECT qtt FROM chbr WHERE poissonType = :poisson";
        $stmt01 = $db->prepare($sql01);
        $stmt01->bindParam(':poisson', $poisson, PDO::PARAM_INT);
        $stmt01->execute();
        $current_chbr = $stmt01->fetch(PDO::FETCH_ASSOC);

        if ($current_chbr) {
            $current_quantity = $current_chbr['qtt'];

            // Calculate new quantity
            

            // Insert into 'stock' table
            $sql03 = "INSERT INTO StockParticulier (id_poisson, qtt, nombre_sac, type, place) VALUES (:poisson, :qtt, :sac, :type, :place)";
            $stmt03 = $db->prepare($sql03);
            $stmt03->bindParam(':poisson', $poisson, PDO::PARAM_INT);
            $stmt03->bindParam(':qtt', $qtt);
            $stmt03->bindParam(':sac', $sac, PDO::PARAM_INT);
            $stmt03->bindParam(':type', $type, PDO::PARAM_INT);
            $stmt03->bindParam(':place', $place, PDO::PARAM_INT);

            if ($stmt03->execute()) {
                $db->commit();
                 $sql02 = "DELETE FROM chbr WHERE poissonType = :poisson";
                $stmt02 = $db->prepare($sql02);
             
                $stmt02->bindParam(':poisson', $poisson, PDO::PARAM_INT);
                $stmt02->execute();
                echo "<script>
                        window.location.href = '../stock';
                      </script>";
            } else {
                throw new Exception("Erreur lors de l'insertion des détails filao.");
            }
        } else {
            throw new Exception("Poisson non trouvé dans la table chbr.");
        }
    } catch (Exception $e) {
        $db->rollBack();
        echo $e->getMessage();
    }
}
?>




