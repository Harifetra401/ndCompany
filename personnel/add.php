<?php
require('../db.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $contact = $_POST['contact'];
    $poste = $_POST['poste'];
    // $insert_cv = $db->prepare("INSERT INTO cv (`cv`) VALUES ('$name')");
    // $insert_cv->execute();
    // $insert_img = $db->prepare("INSERT INTO imgpers (`img`) VALUES ('$name')");
    // $insert_img->execute();
    $sql = "INSERT INTO personnel(`nom`, `contact`, `poste`) VALUES ('$name', '$contact', '$poste')";
    $stmt = $db->prepare($sql);

    if ($stmt->execute()) {

        // header("location:../html/FactureAchat.php?id_fournisseur=".$num_fournisseur_one."&numFact=".$num_facture_one);
?>
        <script>
            window.document.location.href = "../personnel";
        </script>
<?php
    } else {
        echo "Erreur lors de l'insertion des données au personnnel.";
    }
}

?>