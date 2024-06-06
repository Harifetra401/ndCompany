<?php
    require('../db.php');

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $actpassword = $_POST["actpassword"];
        $newpassword = $_POST['newpassword'];
        $iduser = $_POST['iduser'];
        
        // verifier si les mots de passe est correct
        $ver = $db -> prepare("SELECT `password` FROM user WHERE id=".$iduser);
        $ver -> execute();
        $ver_fetch = $ver -> fetch();
        $user_pswrd = $ver_fetch["password"];
        if($actpassword!=$user_pswrd) {
            ?>
            <script>
                alert('Mots de passe actuel incorrect, le modification ne peut etre effectuer, reessayer encore!');
                window.document.location.href = "../html/";
            </script>
            <?php
        }else{

        $update = "UPDATE `user` SET `password`='$newpassword' WHERE id=".$iduser;
        $stmt = $db->prepare($update);
        
        if ($stmt->execute()) {
            
            // header("location:../html/FactureAchat.php?id_fournisseur=".$num_fournisseur_one."&numFact=".$num_facture_one);
            ?>
            <script>
                window.document.location.href = "../html/";
            </script>
        <?php
                } else {
                    echo "Erreur lors de l'insertion des données au poisson.";
                }
            }
}
        
?>

