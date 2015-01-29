<?php
/**
 * Sample PHP code to use reCAPTCHA V2.
 *
 * @copyright Copyright (c) 2014, Google Inc.
 * @link      http://www.google.com/recaptcha
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 */
require_once "recaptchalib.php";
// Register API keys at https://www.google.com/recaptcha/admin
$siteKey = "6LeT8wATAAAAAI1sD5y5FkAyUAkEfyB_CYFZxNnD";
$secret = "6LeT8wATAAAAALXctrjgM0OOtT_8biCjSjvwvG5r";
// reCAPTCHA supported 40+ languages listed here: https://developers.google.com/recaptcha/docs/language
$lang = "en";
// The response from reCAPTCHA
$resp = null;
// The error code from reCAPTCHA, if any
$error = null;
$reCaptcha = new ReCaptcha($secret);
// Variables
$username = $email = $passwd = $dob = $sex = "";
$usernameError = $emailError = $passwordError = $dobError = $sexError = $captchaError = "";
$msg = "";

/**
 * Function that checks if strings are empty, if all the entered strings are empty 
 * it returns true, and otherwise false.
 */
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

// All the checks for when a form is submitted.
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    // Checks for entered username.
    $username = $_POST['username'];
    $res = dbquery("SELECT username FROM users WHERE username='$username'");
    
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
    elseif ($res->rowCount() > 0) {
        $usernameError = "The username you entered has already been taken.";   
    }
    else {
        $username = $_POST['username'];   
    }
    
    // Checks for entered e-mail address(es).
    $email = $_POST['email'];
    $res = dbquery("SELECT email FROM users WHERE email='$email'");
    
    if (empty($_POST['email'])) {
        $emailError = "An e-mail address is required.";   
    } 
    elseif ($_POST['email'] != $_POST['email2']) {
        $emailError = "The e-mail addresses you entered do not match each other.";   
    }
    elseif ($res->rowCount() > 0) {
        $emailError = "An account has already been registered with the e-mail address you entered.";
    }
    else {
        $email = $_POST['email'];   
    }
    
    // Checks for entered password(s).
    if (empty($_POST['password1'])) {
        $passwordError = "A password is required.";
    }
    elseif (strlen($_POST['password1']) < 6) {
        $passwordError = "The password you entered is too short.";   
    }
    elseif (strlen($_POST['password1']) > 40) {
        $passwordError = "The password you entered is too long.";   
    }
    elseif ($_POST['password1'] != $_POST['password2']) {
        $passwordError = "The passwords you entered do not match each other.";   
    }
    else {
        $passwd = $_POST['password1'];   
    }
    
    // Checks for entered date of birth.
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
    
    // Gets Google's response
    if (isset($_POST["g-recaptcha-response"])) {
    $resp = $reCaptcha->verifyResponse(
        $_SERVER["REMOTE_ADDR"],
        $_POST["g-recaptcha-response"]
    );
    }
    
    // Checks for the reCAPTCHA
    if ($resp != null && $resp->success) {
        $captchaError = "";   
    }
    else {
        $captchaError = "Please complete the captcha to register.";   
    }
    
    /**
     * If there are no errors, it then connects to the database, inserts the
     * user's details into the database and sends them a verification email.
     */
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
        
        // If the user's details have been entered successfully, then send him an e-mail.
        if($res) {
            $msg = "Thank you for registering, " . $username . ". A verification e-mail has been sent to " . $email . ". If you haven't received an email within a few seconds, then please check your spam folder. Otherwise contact the admin for further assistance.";

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
            <p>Hello $username, thank you for registering! Click <a href='in09.webdb.fnwi.uva.nl/index.php?page=verification&username=".$username."'>here</a> to verify your Duke's Herald account.</p>
            </div>
            </div>
            </body>
            </html>
            ";

            mail($to, $subject, $message, $headers);
        } 
        else {
            $msg = "Registration has failed, please try again.";
        }  
    }
} 
?>

<script>
/**
 * Function that shows the user if the entered username is too short, too long, 
 * or if it contains illegal characters.
 */
function usernameValidation() {
    var username = document.getElementById("username");
    var userValidation = document.getElementById("userValidation");
    var letters = /^[0-9a-zA-Z]+$/;
    var incorrect = "#df3030";
    var correct = "#56bc56";
    
    if (username.value.length < 6) {
        username.style.backgroundColor = incorrect;
        userValidation.style.color = incorrect;
        userValidation.innerHTML = "This username is too short.";   
    }
    else if (username.value.length > 24) {
        username.style.backgroundColor = incorrect;
        userValidation.style.color = incorrect;
        userValidation.innerHTML = "This username is too long.";   
    }
    else if (!(username.value.match(letters))) {
        username.style.backgroundColor = incorrect;
        userValidation.style.color = incorrect;
        userValidation.innerHTML = "This username contains illegal characters.";   
    }
    else {
        username.style.backgroundColor = correct;
        userValidation.style.color = correct;
        userValidation.innerHTML = "";   
    }
}
    
/**
 * Unused, if improved could be used for showing the user if their entered 
 * username is available or not.
 */
function usernameAvailability(string) {
    if (string == "") {
        document.getElementById("userValidation").innerHTML = "";
        return;
    }
    else {
        if (window.XMLHttpRequest) {
            xmlhttp = new XMLHttpRequest();   
        }
        else {
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");   
        }
        xmlhttp.onreadystatechange = function() {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200)
            {
                document.getElementById("userValidation").innerHTML = xmlhttp.responseText;
            }
        }
    }
    xmlhttp.open("GET", "checkuser.php?username="+string, true);
    xmlhttp.send();
}

/**
 * Function that shows the user if the two e-mail addresses they entered match 
 * each other.
 */
function emailMatch() {
    var email1 = document.getElementById("email");
    var email2 = document.getElementById("email2");
    var emailMatch = document.getElementById("emailMatch");
    var incorrect = "#df3030";
    var correct = "#56bc56";
    
    if (email1.value == email2.value) {
        email2.style.backgroundColor = correct;
        emailMatch.style.color = correct;
        emailMatch.innerHTML = "The e-mail addresses match.";  
    }
    else { 
        email2.style.backgroundColor = incorrect;
        emailMatch.style.color = incorrect;
        emailMatch.innerHTML = "The e-mail addresses do not match.";
    }
}
   
/**
 * Function that shows the user if the e-mail address they entered
 * has a valid format.
 */
function emailValidation() {
    var email = document.getElementById("email");
    var emailValidation = document.getElementById("emailValidation");
    var emailFormat = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
    var letters = /^[0-9a-zA-Z]+$/;
    var incorrect = "#df3030";
    var correct = "#56bc56";
    
    if (!(email.value.match(emailFormat))) {
        email.style.backgroundColor = incorrect;
        emailValidation.style.color = incorrect;
        emailValidation.innerHTML = "This e-mail address isn't valid.";  
    }
    else {
        email.style.backgroundColor = correct;
        emailValidation.style.color = correct;
        emailValidation.innerHTML = "";     
    }
}

/**
 * Function that shows the user if the entered passwords is too short or
 * too long.
 */
function passwordValidation() {
    var password1 = document.getElementById("password1");
    var passwordValidation = document.getElementById("passwordValidation");
    var incorrect = "#df3030";
    var correct = "#56bc56";
    
    if (password1.value.length < 6) {
        password1.style.backgroundColor = incorrect;
        passwordValidation.style.color = incorrect;
        passwordValidation.innerHTML = "The password is too short.";   
    }
    else if (password1.value.length > 40) {
        password1.style.backgroundColor = incorrect;
        passwordValidation.style.color = incorrect;
        passwordValidation.innerHTML = "The password is too long.";   
    }
    else {
        password1.style.backgroundColor = correct;
        passwordValidation.innerHTML = "";
    }
}

/**
 * Function that shows the user if the two passwords they entered 
 * match each other.
 */
function passwordMatch() {
    var password1 = document.getElementById("password1");
    var password2 = document.getElementById("password2");
    var passwordMatch = document.getElementById("passwordMatch");
    var incorrect = "#df3030";
    var correct = "#56bc56";
    
    if (password1.value === password2.value) {
        password2.style.backgroundColor = correct;
        passwordMatch.style.color = correct;
        passwordMatch.innerHTML = "Passwords match.";
    }
    else {
        password2.style.backgroundColor = incorrect;
        passwordMatch.style.color = incorrect;
        passwordMatch.innerHTML = "Passwords do not match.";
    }
}
</script>

<div id="registration">
    <!-- Form for a user's username, e-mail address, password, date of birth and gender.
         Using the above JavaScript functions and PHP, it will either show the user if
         something is wrong instantly, or after they press the submit button. -->
	<form method="POST" action="index.php?page=registration">
		<fieldset>
			<legend>Registration</legend>
            <p><?php echo $msg;?></p>
			<div>
				<label for="username"><b>Username:</b></label>
				<input type="text" name="username" id="username" class="txt" onkeyup="usernameValidation();" required/>
                <span class="error" id="userValidation"><?php echo $usernameError;?></span>
                <br>
                <span class="correct">Must be between 6 <br /> and 24 characters.</span>
			</div>

			<div>
				<label for="email"><b>E-mail address:</b></label>
				<input type="text" name="email" id="email" class="txt" onkeyup="emailValidation()" required/>
                <span class="error" id="emailValidation"><?php echo $emailError;?></span>
			</div>

			<div>
				<label for="email2"><b>Confirm your e-mail address:</b></label>
				<input type="text" name="email2" id="email2" class="txt" onkeyup="emailMatch();" required/>
                <span class="emailMatch" id="emailMatch"></span>
			</div>

			<div>
				<label for="password1"><b>Password:</b></label>
				<input type="password" name="password1" id="password1" class="txt" onkeyup="passwordValidation()" required/>
                <span class="error" id="passwordValidation"><?php echo $passwordError;?></span>
                <br>
                <span class="correct">Must be between 6 <br /> and 40 characters.</span>
			</div>

			<div>
				<label for="password2"><b>Confirm your password:</b></label>
                <input type="password" name="password2" id="password2" class="txt" onkeyup="passwordMatch(); return false;" required/>
                <span id="passwordMatch" class="passwordMatch"></span>
			</div>
                
            <div>
                <label for="dob"><b>Date of birth:</b></label>
                <input type="date" name="dob" id="dob" max="2015-01-31" min="1900-01-01" class="txt" required/>
                <span class="error"><?php echo $dobError;?></span>
            </div>

            <div>
                <label for="sex"><b>Gender:</b></label>
				<input type="radio" name="sex" value="man"  required checked>Male
				<input type="radio" name="sex" value="vrouw"  required>Female
                <span class="error"><?php echo $sexError;?></span>
            </div> 
		</fieldset>
        
        <!-- Google's reCAPTCHA must be completed before a user can submit their details, this
             has been implemented to prevent bots from being able to create accounts -->
		<fieldset>
			<legend>Confirmation of registration</legend>
			<p>To prevent automated registrations this forum requires you to complete this captcha. If the captcha doesn't seem to appear or if you are visually impaired, please contact the <a href="#">administrator</a>.</p>
			<div class="g-recaptcha" data-sitekey="6LeT8wATAAAAAI1sD5y5FkAyUAkEfyB_CYFZxNnD"></div>
            <span class="error"><?php echo $captchaError;?></span>
		</fieldset>
        
        <div class="center">
            <div class="buttons">
                <button type="submit" class="small" value="Submit" >Submit</button>
                <button type="reset" class="small" value="Reset">Reset</button>
            </div>
        </div>
	</form>
</div>

