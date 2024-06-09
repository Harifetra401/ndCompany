<?php
try{
    $db=new PDO("mysql:host=localhost;dbname=filaoo","root","");
}
catch(PDOException $e){
    echo "error $e";
}
?>