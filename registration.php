<?php
function test_input($data) {
    $data = trim($data, "\t\n\r\0\x0B");
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

function checkError($error) {
    foreach (func_get_args() as $error) {
        if (empty($error))
            continue;
        else {
            return false;
        }          
    }
    return true;
}

$username = $email = $passwd = $dob = $sex = "";
$usernameError = $emailError = $passwordError = $dobError = $sexError = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    /* TEST USERNAME */
    if (empty($_POST['username'])) {
        $usernameError = "A username is required.";   
    }
    elseif (strlen($_POST['username']) < 6) {
        $usernameError = "The username you entered is too short.";
    }   
    elseif (strlen($_POST['username']) > 24) {
        $usernameError = "The username you entered is too long.";   
    }
    elseif ((preg_match("/^[a-zA-Z0-9]+$/", $_POST['username'])) == 0) {
        $usernameError = "The username you entered contains illegal characters.";   
    }
    else {
        $username = $_POST['username'];   
    }
    /* ^NEED TO ADD CHECK FOR DATABASE*/
    
    /* TEST E-MAIL ADDRESS */
    if (empty($_POST['email'])) {
        $emailError = "An e-mail address is required.";   
    } 
    elseif ($_POST['email'] != $_POST['email_confirmation']) {
        $passwordError = "The e-mails you entered do not match each other.";   
    }
    else {
        $email = $_POST['email'];   
    }
    /* ^NEED TO ADD CHECK FOR DATABASE*/
    
    /* TEST PASSWORD */
    if (empty($_POST['password'])) {
        $passwordError = "A password is required.";
    }
    elseif (strlen($_POST['password']) < 6) {
        $passwordError = "The password you entered is too short.";   
    }
    elseif (strlen($_POST['password']) > 40) {
        $passwordError = "The password you entered is too long.";   
    }
    elseif ($_POST['password'] != $_POST['password_confirmation']) {
        $passwordError = "The passwords you entered do not match each other.";   
    }
    else {
        $passwd = $_POST['password'];   
    }
    
    /* TEST DATE OF BIRTH */
    if (empty($_POST['dob'])) {
        $dobError = "A date of birth is required.";   
    }
    else {
        $dob = $_POST['dob'];   
    }
    
    if (empty($_POST['sex'])) {
        $sexError = "A gender is required";   
    }
    else {
        $sex = $_POST['sex'];   
    }
    
    if (checkError($usernameError, $emailError, $passwordError, $dobError, $sexError)) {
        dbconnect();
        $hash = password_hash($passwd, PASSWORD_DEFAULT);
        $res = dbquery("INSERT INTO users (username, email, passwd, dob, sex)
        VALUES (:username, :email, :passwd, :dob, :sex);",
        array('username'=>$_POST['username'],
                 'email'=>$_POST['email'],
                'passwd'=>$hash,
                   'dob'=>$_POST['dob'],
                   'sex'=>$_POST['sex']));
    
    if($res) {
        echo "Thank you for registering. A verification e-mail has been sent to " . $email . ". If you haven't received an email within a few seconds, then please check your spam folder. Otherwise contact the admin for further assistance.";
        
        $to = $email;
        $subject = "Duke's Herald - E-mail verification";
        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "From: admin@dukesherald.com \r\n";
        $headers .= "Reply-To: admin@dukesherald.com \r\n";
        $headers .= "Content-Type:text/html;charset=UTF-8" . "\r\n";
        
        $message = "
        <html>
        <head>
        <title>E-mail Verification></title>
        </head>
        <body>
        <div>
        <h1>E-mail Verification</h1>
        <div>
        <p>Hello $username, thank you for registering! Click <a href='#'>here</a> to verify your Duke's Herald account.</p>
        </div>
        </div>
        </body>
        </html>
        ";
        
        mail($to, $subject, $message, $headers);
    } 
    else {
        echo "Registration has failed, please try again.";
    }  
    }
} 
?>


<div id="registration">
	<form method="POST" action="index.php?page=registration">
		<fieldset>
			<legend>Registration</legend>
			<div>
				<label for="username"><b>Username:</b></label>
				<input type="text" name="username" id="username" class="txt"/>
                <span class="error"> * <?php echo $usernameError;?></span>
                <br>
                <span class="correct">Must be between 6 <br /> and 24 characters.</span>
			</div>

			<div>
				<label for="email"><b>E-mail address:</b></label>
				<input type="text" name="email" id="email" class="txt"/>
                <span class="error"> * <?php echo $emailError;?></span>
			</div>

			<div>
				<label for="email_confirmation"><b>Confirm your e-mail address:</b></label>
				<input type="text" name="email_confirmation" id="email_confirmation" class="txt"/>
			</div>

			<div>
				<label for="password"><b>Password:</b></label>
				<input type="password" name="password" id="password" class="txt"/>
                <span class="error"> * <?php echo $passwordError;?></span>
                <br>
                <span class="correct">Must be between 6 <br /> and 40 characters.</span>
			</div>

			<div>
				<label for="password_confirmation"><b>Confirm your password:</b></label>
				<input type="password" name="password_confirmation" id="password_confirmation" class="txt"/>
			</div>
                
            <div>
                <label for="dob"><b>Date of birth:</b></label>
                <input type="date" name="dob" id="dob" max="2015-01-31" min="1900-01-01" class="txt"/>
                <span class="error"> * <?php echo $dobError;?></span>
            </div>

            <div>
                <label for="sex"><b>Gender:</b></label>
				<input type="radio" name="sex" value="man" >Male
				<input type="radio" name="sex" value="vrouw" >Female
                <span class="error"> * <?php echo $sexError;?></span>
            </div> 
		</fieldset>

		<fieldset>
			<legend>Confirmation of registration</legend>
			<p>To prevent automated registrations this forum requires you to complete this captcha. If you can't read the captcha or if you are visually impaired, please contact the <a href="#">administrator</a>.</p>

			<label for="captcha"><b>Confirmation code:</b></label>
		</fieldset>
	<div class="center">
		<div class="buttons">
			<button type="submit" class="small" value="Submit" >Submit</button>
			<button type="reset" class="small" value="Reset">Reset</button>
		</div>
	</div>
	</form>
</div>
