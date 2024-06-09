<?php
require('../db.php');
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $poisson = $_POST["poisson"];
    $qtt = $_POST["qtt"];
    $sac = $_POST["sac"];
    $place = 1;
    session_start();
    $_SESSION['emplacement'] = $place == 1 ? "eto" : "any";
    $sql01 = "SELECT id , nomfilao, qtt FROM froidf WHERE id = $poisson ";
    $stmt01 = $db->prepare($sql01);
    $stmt01->execute();

    $all_facture01 = $stmt01->fetchAll(PDO::FETCH_ASSOC);
?>
    <?php foreach ($all_facture01 as $get_fact01) :
        if ($qtt > $get_fact01['qtt']) {
            ?>
            <script>
                document.location.href = "../stock";
                alert ('Mercie de verifier vos saisie')
            </script>
    <?php
        } else {
            $sql01 = $db->prepare("UPDATE froidf SET qtt = qtt - $qtt WHERE id = $poisson");
            $sql01->execute();

            $sql02 = $db->prepare("UPDATE stockf SET qtt = qtt + $qtt WHERE id = $poisson");
            $sql02->execute();

            $sql = "INSERT INTO stock(`id_poisson`, `qtt`, `nombre_sac`, `place`) VALUES ($poisson, $qtt, $sac, $place)";
            $stmt = $db->prepare($sql);

            if ($stmt->execute()) {
    ?>
                <script>
                    document.location.href = "../stock";
                </script>
        <?php
            } else {
                echo " $sql Erreur lors de l'insertion des datail filao.";
            }
        }
        ?>

<?php endforeach;
}
?>