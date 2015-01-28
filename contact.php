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

$msg = $captchaError = "";

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

if (isset($_POST['email'])) {
    $email = $_POST['email'];
    $message = $_POST['message'];
    $name = $_POST['name'];
    
    if ($resp != null && $resp->success) {
        $captchaError = "";   
    }
    else {
        $captchaError = "Please complete the captcha to register.";   
    }
    
    if($_POST['email'] && checkError($captchaError)) {
        $msg = "Your message has been sent.";
    }
    
    $to = "amos.bastian@student.uva.nl";
    $subject = "Duke's Herald - Message from '$name'";
    $headers = "MIME-Version: 1.0" . "\r\n";
    $headers = "From: '$email'\r\n";
    $headers .= "Reply-To: '$email' \r\n";
    $headers .= "Content-Type:text/html;charset=UTF-8" . "\r\n";

    mail($to, $subject, $message, $headers);
}
?>

<script>
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

<div id="registration">
    <form method="POST" action="index.php?page=contact">
    <fieldset>
        <legend>General</legend>
        <p><b>The Duke's Herald</b></p>
        <p>Science Park 402<br />1098 XH Amsterdam<br />The Netherlands</p>
    </fieldset>
    <fieldset>
        <legend>Contact Us</legend>
        <p><?php echo $msg;?></p>
        <p>If you have any questions, requests or concerns regarding our services, then please use the contact form below to send us an e-mail. <br /> We will hopefully respond to your messages within 48 hours.</p>
        
        <div>
            <label for="name"><b>Name:</b></label>
            <input type="text" name="name" id="name" class="txt" required/>
            <span class="error" id="userValidation"></span>
        </div>
        
        <div>
            <label for="email"><b>E-mail address:</b></label>
            <input type="text" name="email" id="email" class="txt" onkeyup="emailValidation()" required/>
            <span class="error" id="emailValidation"></span>
        </div>
        
        <div>
            <label for="message"><b>Message:</b></label>
            <textarea name="message" maxlength="999" cols="50" rows="10"></textarea>
        </div>
        
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