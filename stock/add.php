<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    require('../db.php');
    $poisson = $_POST["poisson"];
    $qtt = $_POST["qtt"];
    $sac = $_POST["sac"];
    $type = $_POST["type"];
    $place = 1;
    
    session_start();
    $_SESSION['emplacement'] = $place == 1 ? "eto" : "any";
    
    $sql01 = "SELECT id, nomfilao, qtt FROM froidf WHERE id = :poisson";
    $stmt01 = $db->prepare($sql01);
    $stmt01->bindParam(':poisson', $poisson, PDO::PARAM_INT);
    $stmt01->execute();
    $all_facture01 = $stmt01->fetchAll(PDO::FETCH_ASSOC);
    
    foreach ($all_facture01 as $get_fact01) {
        if ($qtt > $get_fact01['qtt']) {
            echo "<script>
                    alert('Merci de vérifier vos saisies.');
                    window.location.href = '../stock';
                  </script>";
        } else {
            $sql02 = "UPDATE froidf SET qtt = qtt - :qtt WHERE id = :poisson";
            $stmt02 = $db->prepare($sql02);
            $stmt02->bindParam(':qtt', $qtt, PDO::PARAM_INT);
            $stmt02->bindParam(':poisson', $poisson, PDO::PARAM_INT);
            $stmt02->execute();
            
            $sql03 = "UPDATE stockf SET qtt = qtt + :qtt WHERE id = :poisson";
            $stmt03 = $db->prepare($sql03);
            $stmt03->bindParam(':qtt', $qtt, PDO::PARAM_INT);
            $stmt03->bindParam(':poisson', $poisson, PDO::PARAM_INT);
            $stmt03->execute();
            
            $sql = "INSERT INTO stock (id_poisson, qtt, nombre_sac, type, place) VALUES (:poisson, :qtt, :sac, :type, :place)";
            $stmt = $db->prepare($sql);
            $stmt->bindParam(':poisson', $poisson, PDO::PARAM_INT);
            $stmt->bindParam(':qtt', $qtt, PDO::PARAM_INT);
            $stmt->bindParam(':sac', $sac, PDO::PARAM_INT);
            $stmt->bindParam(':type', $type, PDO::PARAM_INT);
            $stmt->bindParam(':place', $place, PDO::PARAM_INT);
            
            if ($stmt->execute()) {
                echo "<script>
                        window.location.href = '../stock';
                      </script>";
            } else {
                echo "Erreur lors de l'insertion des détails filao.";
            }
        }
    }
}
?>
