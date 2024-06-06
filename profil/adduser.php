<?php
    require('../db.php');

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $username = $_POST["username"];
        $action = empty($_POST['action']) ? 0 : 1;
        $action1 = empty($_POST['action1']) ? 0 : 1;
        $action2 = empty($_POST['action2']) ? 0 : 1;
        $place = $_POST["place"];
        $sql = "INSERT INTO user(`username`, `vente`, `achat`, `stock`, `lieukandra`) VALUES ('$username', $action, $action1, $action2, '$place')";
        $stmt = $db->prepare($sql);

        if ($stmt->execute()) {
            ?>
            <script>
                window.document.location.href = "../html/";
            </script>
            <?php
        } else {
            echo "Erreur lors de l'insertion des données au user.";
        }
    }
?>
