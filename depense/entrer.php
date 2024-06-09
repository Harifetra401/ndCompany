<?php
require ('../db.php');
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $libelle = $_POST["libelle"];
    $cout = $_POST["cout"];
    $desc = $_POST["desc"];
    $sql = "INSERT INTO entrer(`libelle`, `cout`, `description`) VALUES ('$libelle', $cout, \"$desc\")";
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