<?php

//including db

require('../db.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $password = $_POST["password"];
    $name = $_POST["name"];

// start a session
session_start();
$_SESSION['username'] = $name;

//selecting to db and count if it exist

$select=$db->prepare("select * from user where username='$name'");
$select->execute();
$nbrExist=$select->rowCount();
$fetch=$select->fetch();

//test if selected exist

if($nbrExist>0){

    $dbpassword=$fetch["password"];
    $dbname=$fetch["username"];
    
    if(($password == $dbpassword) && ($dbname == $name)  ) {
        $id = $fetch["id"];
        $username = $fetch["username"];
        $vente = $fetch["vente"];
        $achat = $fetch["achat"];
        $stock = $fetch["stock"];
        $lots = $fetch["lieukandra"];
        
        $_SESSION["id"] = true;
        $_SESSION["id"] = $id;
        $_SESSION["name"] = $username;
        $_SESSION["action"] = $vente;
        $_SESSION["action1"] = $achat;
        $_SESSION["action2"] = $stock;
        $_SESSION["lieukandra"] = $lots;        

        ?>
        <script>
            document.location.href = "../html/";
        </script>
        <?php
            }else{
                ?>
                <script>
                    alert('Identification Incorrect');
                    window.document.location.href = "../html/login.php";
                </script>
                <?php
            }
        }else{
            ?>
            <script>
                alert('Identification introuvable');
                window.document.location.href = "../html/login.php";
            </script>
            <?php

        }

    }

?>
