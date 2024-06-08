<?php
require ('../db.php');
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $libelle = $_POST["libelle"];
    $cout = $_POST["cout"];
    $desc = $_POST["desc"];
    if ($libelle == "depense_personnel" || $libelle == "frais_deplacement" || $libelle == "amenagement" || $libelle == "loyer" || $libelle == "autorite" || $libelle == "compte_immobilisation" || $libelle == "commission" || $libelle == "autres_depenses") {
        $class = 1;
    } elseif ($libelle == "enlevement_produits" || $libelle == "conservation_produits" || $libelle == "cout_traitements" || $libelle == "materiels_approvisionnements" || $libelle == "emballage_produits" || $libelle == "depenses_diverses") {
        $class = 2;
    } elseif ($libelle == "transport_locale" || $libelle == "livraison_tana") {
        $class = 3;
    } else {
        ?>
        <script>
            alert('Merci de bien verifier votre libelle');
            document.location.href = "../depense";
        </script>
        <?php
    }
    $sql = "INSERT INTO depence(`libelle`, `cout`, `description`, `class`) VALUES ('$libelle', $cout, \"$desc\", $class)";
    //   echo("$sql");
    $stmt = $db->prepare($sql);

    if ($stmt->execute()) {
        ?>
        <script>
            document.location.href = "../depense";
        </script>
        <?php
    } else {
        echo " $sql Erreur lors de l'insertion des depense.";
    }

}
?>