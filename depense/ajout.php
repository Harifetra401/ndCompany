<?php
require ('../db.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $libelle = $_POST["libelle"];
    $cout = $_POST["cout"];
    $desc = $_POST["desc"];
    $daty = $_POST["daty"];
    $class = 3;
    
    // if ($libelle == "dpsprsls" || $libelle == "fraisdeplacement" || $libelle == "amenagement" || $libelle == "loyer" || $libelle == "autorite" || $libelle == "compte_immobilisation" || $libelle == "commission" || $libelle == "autres_depenses") {
    //     $class = 1;
    // } elseif ($libelle == "enlevement_produits" || $libelle == "conservation_produits" || $libelle == "cout_traitements" || $libelle == "materiels_approvisionnements" || $libelle == "emballage_produits" || $libelle == "depenses_diverses") {
    //     $class = 2;
    // } elseif ($libelle == "tl" || $libelle == "livraisontana") {
    //     ;
    // } else {
    //     ?>
    //     <script>
    //         alert('Merci de bien verifier votre libelle');
    //         document.location.href = "../depense";
    //     </script>
    //     <?php
    //     exit;
    // }
    
    // Préparer la requête SQL avec des placeholders
    $sql = "INSERT INTO depence(`libelle`, `cout`, `description`, `class`, `date`) VALUES (:libelle, :cout, :desc, :class, :daty)";
    $stmt = $db->prepare($sql);
    
    // Lier les valeurs aux placeholders
    $stmt->bindParam(':libelle', $libelle);
    $stmt->bindParam(':cout', $cout);
    $stmt->bindParam(':desc', $desc);
    $stmt->bindParam(':class', $class);
    $stmt->bindParam(':daty', $daty);
    
    // Exécuter la requête
    if ($stmt->execute()) {
        ?>
        <script>
            document.location.href = "../depense";
        </script>
        <?php
    } else {
        echo "Erreur lors de l'insertion des depense.";
    }
}
?>
