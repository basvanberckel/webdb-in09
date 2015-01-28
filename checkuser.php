<?php
    require('dbconfig.php');
    dbconnect();
    if (isset($_GET['username'])) {
        $username = $_GET['username'];
        $res = dbquery("SELECT username FROM users WHERE username='$username'");
        
        if ($res->rowCount() > 0) {
            echo "UNAVAILABLE";   
        }
        else {
            echo "AVAILABLE";   
        }
    }
?>