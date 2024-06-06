<?php
        require('../db.php');
        $sql = "INSERT stockfinal";
        $stmt = $db->prepare($sql);
    
        if ($stmt->execute()) {
            ?>
                <script>
                    document.location.href = "../stock";
                </script>
           <?php
        } else {
            echo " $sql Erreur lors de supression des stock filao.";
        }
?>