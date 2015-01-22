<?php
if(isset($_POST['email'])) {
    dbconnect();
    $email=$_POST['email']; 
    $res = dbquery("SELECT username FROM users 
                  WHERE email='$email';");
    while($row = $res->fetch(PDO::FETCH_ASSOC)) {
        $username = $row['username'];
    }

    if($_POST['email']) {
        function newPassword($length) {
        $characters = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%*()_+{}|<>?/.,;[]\=-";
        return substr(str_shuffle($characters), 0, $length);
    }
    $password = newPassword(10);
    $to = $email;
    $subject = "Duke's Herald - Account Recovery";
    $headers = "MIME-Version: 1.0" . "\r\n";
    $headers .= "From: admin@dukesherald.com \r\n";
    $headers .= "Reply-To: admin@dukesherald.com \r\n";
    $headers .= "Content-Type:text/html;charset=UTF-8" . "\r\n";

    $message = "
    <html>
    <head>
    <title>Account Recovery></title>
    </head>
    <body>
    <div>
    <h1>Account Recovery</h1>
    <div>
    <p>Hello  $username, someone has requested the login info of your Duke's Herald account.<br /> <br />
    Username: $username<br /><br />
    Password: $password</p>
    </div>
    </div>
    </body>
    </html>
    ";

    mail($to, $subject, $message, $headers);
        
    $hash = password_hash($password, PASSWORD_DEFAULT);
    $res = dbquery("UPDATE users SET passwd='$hash' WHERE email='$email'");
    }
}
else { ?>

<div id="registration">
    <form method="POST">
        <fieldset>
            <legend>Account Recovery</legend>
            <p>If you have forgotten your username or password, you can enter the e-mail address you used to sign up with below, and we'll then send you your username and a new password. <br /> <br />
                If you also can't remember the e-mail address you used to sign up with, then there isn't anything we can do, unfortunately - but account registration is free, so if you want, you can always create a new account instead. <br /><br /></p>
            
            <div>
				<label for="email"><b>E-mail address:</b></label>
				<input type="text" name="email" id="email" class="txt" required/>
			</div>
                
            <p>To prevent someone's e-mail address being spam this forum requires you to complete this captcha. If you can't read the captcha or if you are visually impaired, please contact the <a href="#">administrator</a>.</p>

			<label for="captcha"><b>Confirmation code:</b></label>
            
            <div class="center">
		         <div class="buttons">
			     <button type="submit" class="small" value="Submit" >Submit</button>
			     <button type="reset" class="small" value="Reset">Reset</button>
		         </div>
	        </div>
        </fieldset>
    </form>
</div>
<?php } ?>