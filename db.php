<?php
try{
    $db=new PDO("mysql:host=localhost;dbname=filao","root","");
}
catch(PDOException $e){
    echo "error $e";
}
?>