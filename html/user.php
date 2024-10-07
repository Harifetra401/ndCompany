<?php
    function get_name($id_user) {
        require('../db.php');
        $select=$db->prepare("select * from user where id='$id_user'");
        $select->execute();
        $fetch=$select->fetch();
        return $fetch["username"];
    }
?>