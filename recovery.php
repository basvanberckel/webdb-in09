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


$msg = "";
$captchaError = "";

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

if (isset($_POST["g-recaptcha-response"])) {
    $resp = $reCaptcha->verifyResponse(
        $_SERVER["REMOTE_ADDR"],
        $_POST["g-recaptcha-response"]
    );
    }
    
if ($resp != null && $resp->success) {
    $captchaError = "";   
}
else {
    $captchaError = "Please complete the captcha to register.";   
}

if (isset($_POST['email']) && $captchaError == "") {
    dbconnect();
    $email=$_POST['email']; 
    $res = dbquery("SELECT username FROM users 
                  WHERE email='$email';");
    while($row = $res->fetch(PDO::FETCH_ASSOC)) {
        $username = $row['username'];
    }

    if($_POST['email'] && $captchaError == "") {
        function newPassword($length) {
        $characters = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%*()_+{}|<>?/.,;[]\=-";
        $msg = "An email has been sent to $email.";
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
    else {
        $msg = "Something has gone wrong, please try again.";   
    }
}
else {
}
?>

<div id="registration">
    <form method="POST">
        <fieldset>
            <legend>Account Recovery</legend>
            <p><?php echo $msg;?></p>
            <p>If you have forgotten your username or password, you can enter the e-mail address you used to sign up with below, and we'll then send you your username and a new password. <br /> <br />
                If you also can't remember the e-mail address you used to sign up with, then there isn't anything we can do, unfortunately - but account registration is free, so if you want, you can always create a new account instead. <br /><br /></p>
            
            <div>
				<label for="email"><b>E-mail address:</b></label>
				<input type="text" name="email" id="email" class="txt" required/>
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