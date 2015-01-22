<?php
if(isset($_POST['username'])) {
    dbconnect();
    $passwd = $_POST['password'];
    $dob = $_POST['dob'];
    $sex = $_POST['sex'];
    $hash = password_hash($passwd, PASSWORD_DEFAULT);
    $email = $_POST['email'];
    $username = $_POST['username'];
    $res = dbquery("INSERT INTO users (username, email, passwd, dob, sex)
        VALUES (:username, :email, :passwd, :dob, :sex);",
        array('username'=>$_POST['username'],
                 'email'=>$_POST['email'],
                'passwd'=>$hash,
                   'dob'=>$_POST['dob'],
                   'sex'=>$_POST['sex']));
    
    $userLength = strlen($username);
    $pswdLength = strlen($passwd);
    
    
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
else { ?>

<div id="registration">
	<form method="POST">
		<fieldset>
			<legend>Registration</legend>
			<div>
				<label for="username"><b>Username:</b></label>
				<input type="text" name="username" id="username" class="txt" required/>
                <span class="error"> * </span> <span class="required">* = required</span>
                <br>
                <span class="correct">Must be between 6 <br /> and 24 characters.</span>
			</div>

			<div>
				<label for="email"><b>E-mail address:</b></label>
				<input type="text" name="email" id="email" class="txt" required/>
                <span class="error"> * </span>
			</div>

			<div>
				<label for="email_confirmation"><b>Confirm your e-mail address:</b></label>
				<input type="text" name="email_confirmation" id="email_confirmation" class="txt" required/>
                <span class="error"> * </span>
			</div>

			<div>
				<label for="password"><b>Password:</b></label>
				<input type="password" name="password" id="password" class="txt" required/>
                <span class="error"> * </span>
                <br>
                <span class="correct">Must be between 6 <br /> and 40 characters.</span>
			</div>

			<div>
				<label for="password_confirmation"><b>Confirm your password:</b></label>
				<input type="password" name="password_confirmation" id="password_confirmation" class="txt" required/>
                <span class="error"> * </span>
			</div>
                
            <div>
                <label for="dob"><b>Date of birth:</b></label>
                <input type="date" name="dob" id="dob" max="2015-01-31" min="1900-01-01" class="txt"/>
            </div>

            <div>
                <label for="sex"><b>Sex:</b></label>
				<input type="radio" name="sex" value="man" >Male
				<input type="radio" name="sex" value="vrouw" >Female
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
<?php } ?>
