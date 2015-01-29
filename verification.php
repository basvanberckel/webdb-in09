<?php
    dbconnect();
    /**
     * Gets the username and sets verified to 1 so the user can log in.
     */
    if (isset($_GET['username'])) {
        $username = $_GET['username'];
        $res = dbquery("UPDATE users SET verified='1' WHERE username='$username'");
        
        if ($res) {
            $msg = "Thanks for registering, your account has been verified!";
        }
        else {
            $msg = "Something has gone wrong, please try again or contact the administrator.";    
        }
    }   
?>

<!-- Prints a message depending on if the verification succeeded or not, and provides
     a link back to the homepage. -->
<div id="registration">
    <fieldset>
        <legend>Verification</legend>
        <p><?php echo $msg; ?></p>
        <br />
        <a href="index.php">Click here to return to the home page.</a>
        </p>
    </fieldset>
</div>