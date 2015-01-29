<!-- Was going to be used to show the user if the username they entered
was available or not, but unfortunately there were still some errors
and so we decided to not use it. -->

<?php
    /**
     * Checks if username is already taken and provides feedback to the user.
     */
    require('dbconfig.php');
    dbconnect();
    if (isset($_GET['username'])) {
        $username = $_GET['username'];
        if (strlen($username) > 6 && strlen($username) < 24) {
        $res = dbquery("SELECT username FROM users WHERE username='$username'");
        
        if ($res->rowCount() > 0) {
            echo "UNAVAILABLE";   
        }
        else {
            echo "AVAILABLE";   
        }
        }
    }
?>