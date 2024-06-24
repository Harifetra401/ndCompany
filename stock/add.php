<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    require('../db.php');
    
    // Using filter_input to sanitize and validate inputs
    $poisson = filter_input(INPUT_POST, 'poisson', FILTER_VALIDATE_INT);
    $qtt = filter_input(INPUT_POST, 'qtt', FILTER_VALIDATE_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
    $sac = filter_input(INPUT_POST, 'sac', FILTER_VALIDATE_INT);
    $type = filter_input(INPUT_POST, 'type', FILTER_VALIDATE_INT);
    $place = 1;

    if ($poisson === false || $qtt === false || $sac === false || $type === false) {
        echo "Invalid input.";
        exit;
    }

    session_start();
    $_SESSION['emplacement'] = $place == 1 ? "eto" : "any";

    try {
        $db->beginTransaction();

        // Fetch current quantity from 'froidf' table
        $sql01 = "SELECT id, nomfilao, qtt FROM froidf WHERE id = :poisson";
        $stmt01 = $db->prepare($sql01);
        $stmt01->bindParam(':poisson', $poisson, PDO::PARAM_INT);
        $stmt01->execute();
        $all_facture01 = $stmt01->fetchAll(PDO::FETCH_ASSOC);

        if (count($all_facture01) > 0) {
            // Update 'froidf' table
            $sql02 = "UPDATE froidf SET qtt = qtt - :qtt WHERE id = :poisson";
            $stmt02 = $db->prepare($sql02);
            $stmt02->bindParam(':qtt', $qtt);
            $stmt02->bindParam(':poisson', $poisson, PDO::PARAM_INT);
            $stmt02->execute();

            // Update 'stockf' table
            $sql03 = "UPDATE stockf SET qtt = qtt + :qtt WHERE id = :poisson";
            $stmt03 = $db->prepare($sql03);
            $stmt03->bindParam(':qtt', $qtt);
            $stmt03->bindParam(':poisson', $poisson, PDO::PARAM_INT);
            $stmt03->execute();

            // Insert into 'stock' table
            $sql = "INSERT INTO stock (id_poisson, qtt, nombre_sac, type, place) VALUES (:poisson, :qtt, :sac, :type, :place)";
            $stmt = $db->prepare($sql);
            $stmt->bindParam(':poisson', $poisson, PDO::PARAM_INT);
            $stmt->bindParam(':qtt', $qtt);
            $stmt->bindParam(':sac', $sac, PDO::PARAM_INT);
            $stmt->bindParam(':type', $type, PDO::PARAM_INT);
            $stmt->bindParam(':place', $place, PDO::PARAM_INT);

            if ($stmt->execute()) {
                $db->commit();
                echo "<script>
                        window.location.href = '../stock';
                      </script>";
            } else {
                throw new Exception("Erreur lors de l'insertion des détails filao.");
            }
        } else {
            throw new Exception("Poisson not found.");
        }
    } catch (Exception $e) {
        $db->rollBack();
        echo $e->getMessage();
    }
}
?>
