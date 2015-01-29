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
$msg = $captchaError = $emailError = "";

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

// Gets Google's response
if (isset($_POST["g-recaptcha-response"])) {
    $resp = $reCaptcha->verifyResponse(
        $_SERVER["REMOTE_ADDR"],
        $_POST["g-recaptcha-response"]
    );
}
    
/**
 * Checks if the entered e-mail address is actually attached to an account,
 * and if so, it generates a new password and sends this, including the
 * username attached to the e-mail address, to the entered e-mail address.
 */
if (isset($_POST['email']) && checkError($captchaError, $emailError)) {
    dbconnect();
    $email = $_POST['email'];
    $res = dbquery("SELECT email FROM users WHERE email='$email'");
    
    // Checks if entered e-mail address is attached to an account.
    if ($res->rowCount() < 1) {
        $emailError = "The entered e-mail address does not have an account attached to it.";  
    }
    else {
        $emailError = "";   
    }
    
    // Gets the username that is attached to the entered e-mail address.
    $res = dbquery("SELECT username FROM users 
                  WHERE email='$email'");
    while($row = $res->fetch(PDO::FETCH_ASSOC)) {
        $username = $row['username'];
    }
    
    // Checks for the reCAPTCHA
    if ($resp != null && $resp->success) {
        $captchaError = "";   
    }
    else {
        $captchaError = "Please complete the captcha to register.";   
    }

    /**
     * If there are no errors, then send email to user, and confirm
     * that an e-mail has been sent.
     */
    if ($_POST['email'] && checkError($captchaError, $emailError)) {
        $msg = "An email has been sent to your email.";
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
    
    // Hash the newly generated password and update the user's password.
    $hash = password_hash($password, PASSWORD_DEFAULT);
    $res = dbquery("UPDATE users SET passwd='$hash' WHERE email='$email'");
    }
    else {
        $msg = "Something has gone wrong, please try again.";   
    }
}
else {
}
?>

<script>
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
</script>

<!-- Basic recovery form where the user can enter the e-mail address they registered with.
     Implemented reCAPTCHA to prevent someone's e-mail address being spammed. -->
<div id="registration">
    <form method="POST" action="index.php?page=recovery">
        <fieldset>
            <legend>Account Recovery</legend>
            <p><?php echo $msg;?></p>
            <p>If you have forgotten your username or password, you can enter the e-mail address you used to sign up with below, and we'll then send you your username and a new password. <br /> <br />
                If you also can't remember the e-mail address you used to sign up with, then there isn't anything we can do, unfortunately - but account registration is free, so if you want, you can always create a new account instead. <br /><br /></p>
            
            <div>
				<label for="email"><b>E-mail address:</b></label>
				<input type="text" name="email" id="email" class="txt" onkeyup="emailValidation()" required/>
                <span class="error" id="emailValidation"><?php echo $emailError;?></span>
			</div>
                
            <p>To prevent someone's e-mail address being spam this forum requires you to complete this captcha. If the captcha isn't appearing for you or if you are visually impaired, please contact the <a href="#">administrator</a>.</p>

			<div class="g-recaptcha" data-sitekey="6LeT8wATAAAAAI1sD5y5FkAyUAkEfyB_CYFZxNnD"></div>
            <span class="error"><?php echo $captchaError;?></span>
            <div class="center">
		         <div class="buttons">
			     <button type="submit" class="small" value="Submit" >Submit</button>
			     <button type="reset" class="small" value="Reset">Reset</button>
		         </div>
	        </div>
        </fieldset>
    </form>
</div>