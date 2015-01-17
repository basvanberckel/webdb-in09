<?php
if(isset($_POST['username'])) {
  dbconnect();
  $passwd = $_POST['password'];
  $hash = password_hash($passwd, PASSWORD_DEFAULT);
  var_dump(array('username'=>$_POST['username'],
                        'email'=>$_POST['email'],
                        'passwd'=>$hash));
  $res = dbquery("INSERT INTO users (username, email, passwd)
                  VALUES (:username, :email, :passwd);",
                  array('username'=>$_POST['username'],
                        'email'=>$_POST['email'],
                        'passwd'=>$hash));
  var_dump($res);
  if($res) {
    echo "registration successful!";
  } else {
    echo "registration failed!";
  }
  
} else { ?>

<div id="registration">
	<form method="POST">
		<fieldset>
			<legend>Registration</legend>
			<div>
				<label for="username"><b>Username:</b></label>
				<input type="text" name="username" id="username" class="txt"/>
			</div>

			<div>
				<label for="email"><b>E-mail address:</b></label>
				<input type="text" name="email" id="email" class="txt"/>
			</div>

			<div>
				<label for="email_confirmation"><b>Confirm your e-mail address:</b></label>
				<input type="text" name="email_confirmation" id="email_confirmation" class="txt"/>
			</div>

			<div>
				<label for="password"><b>Password:</b></label>
				<input type="text" name="password" id="password" class="txt"/>
			</div>

			<div>
				<label for="password_confirmation"><b>Confirm your password:</b></label>
				<input type="text" name="password_confirmation" id="password_confirmation" class="txt"/>
			</div>

			<div>
				<label for="language"><b>Language:</b></label>
				<select name="language" id="language">
					<option title="English [UK]" value="english_uk">English [UK]</option>
				</select>
			</div>

			<div>
				<label for="timezone"><b>Timezone:</b></label>
				<select name="timezone" id="timezone" tabindex="7" class="autowidth"><option title="[UTC - 12] Baker Island Time" value="-12">[UTC - 12] Baker Island Time</option><option title="[UTC - 11] Niue Time, Samoa Standard Time" value="-11">[UTC - 11] Niue Time, Samoa Standard Time</option><option title="[UTC - 10] Hawaii-Aleutian Standard Time, Cook Island Time" value="-10">[UTC - 10] Hawaii-Aleutian Standard Time, Cook Island Time</option><option title="[UTC - 9:30] Marquesas Islands Time" value="-9.5">[UTC - 9:30] Marquesas Islands Time</option><option title="[UTC - 9] Alaska Standard Time, Gambier Island Time" value="-9">[UTC - 9] Alaska Standard Time, Gambier Island Time</option><option title="[UTC - 8] Pacific Standard Time" value="-8">[UTC - 8] Pacific Standard Time</option><option title="[UTC - 7] Mountain Standard Time" value="-7">[UTC - 7] Mountain Standard Time</option><option title="[UTC - 6] Central Standard Time" value="-6">[UTC - 6] Central Standard Time</option><option title="[UTC - 5] Eastern Standard Time" value="-5">[UTC - 5] Eastern Standard Time</option><option title="[UTC - 4:30] Venezuelan Standard Time" value="-4.5">[UTC - 4:30] Venezuelan Standard Time</option><option title="[UTC - 4] Atlantic Standard Time" value="-4">[UTC - 4] Atlantic Standard Time</option><option title="[UTC - 3:30] Newfoundland Standard Time" value="-3.5">[UTC - 3:30] Newfoundland Standard Time</option><option title="[UTC - 3] Amazon Standard Time, Central Greenland Time" value="-3">[UTC - 3] Amazon Standard Time, Central Greenland Time</option><option title="[UTC - 2] Fernando de Noronha Time, South Georgia &amp; the South Sandwich Islands Time" value="-2">[UTC - 2] Fernando de Noronha Time, South Georgia &amp; the South Sandwich Islands Time</option><option title="[UTC - 1] Azores Standard Time, Cape Verde Time, Eastern Greenland Time" value="-1">[UTC - 1] Azores Standard Time, Cape Verde Time, Eastern Greenland Time</option><option title="[UTC] Western European Time, Greenwich Mean Time" value="0" selected="selected">[UTC] Western European Time, Greenwich Mean Time</option><option title="[UTC + 1] Central European Time, West African Time" value="1">[UTC + 1] Central European Time, West African Time</option><option title="[UTC + 2] Eastern European Time, Central African Time" value="2">[UTC + 2] Eastern European Time, Central African Time</option><option title="[UTC + 3] Moscow Standard Time, Eastern African Time" value="3">[UTC + 3] Moscow Standard Time, Eastern African Time</option><option title="[UTC + 3:30] Iran Standard Time" value="3.5">[UTC + 3:30] Iran Standard Time</option><option title="[UTC + 4] Gulf Standard Time, Samara Standard Time" value="4">[UTC + 4] Gulf Standard Time, Samara Standard Time</option><option title="[UTC + 4:30] Afghanistan Time" value="4.5">[UTC + 4:30] Afghanistan Time</option><option title="[UTC + 5] Pakistan Standard Time, Yekaterinburg Standard Time" value="5">[UTC + 5] Pakistan Standard Time, Yekaterinburg Standard Time</option><option title="[UTC + 5:30] Indian Standard Time, Sri Lanka Time" value="5.5">[UTC + 5:30] Indian Standard Time, Sri Lanka Time</option><option title="[UTC + 5:45] Nepal Time" value="5.75">[UTC + 5:45] Nepal Time</option><option title="[UTC + 6] Bangladesh Time, Bhutan Time, Novosibirsk Standard Time" value="6">[UTC + 6] Bangladesh Time, Bhutan Time, Novosibirsk Standard Time</option><option title="[UTC + 6:30] Cocos Islands Time, Myanmar Time" value="6.5">[UTC + 6:30] Cocos Islands Time, Myanmar Time</option><option title="[UTC + 7] Indochina Time, Krasnoyarsk Standard Time" value="7">[UTC + 7] Indochina Time, Krasnoyarsk Standard Time</option><option title="[UTC + 8] Chinese Standard Time, Australian Western Standard Time, Irkutsk Standard Time" value="8">[UTC + 8] Chinese Standard Time, Australian Western Standard Time, Irkutsk Standard Time</option><option title="[UTC + 8:45] Southeastern Western Australia Standard Time" value="8.75">[UTC + 8:45] Southeastern Western Australia Standard Time</option><option title="[UTC + 9] Japan Standard Time, Korea Standard Time, Chita Standard Time" value="9">[UTC + 9] Japan Standard Time, Korea Standard Time, Chita Standard Time</option><option title="[UTC + 9:30] Australian Central Standard Time" value="9.5">[UTC + 9:30] Australian Central Standard Time</option><option title="[UTC + 10] Australian Eastern Standard Time, Vladivostok Standard Time" value="10">[UTC + 10] Australian Eastern Standard Time, Vladivostok Standard Time</option><option title="[UTC + 10:30] Lord Howe Standard Time" value="10.5">[UTC + 10:30] Lord Howe Standard Time</option><option title="[UTC + 11] Solomon Island Time, Magadan Standard Time" value="11">[UTC + 11] Solomon Island Time, Magadan Standard Time</option><option title="[UTC + 11:30] Norfolk Island Time" value="11.5">[UTC + 11:30] Norfolk Island Time</option><option title="[UTC + 12] New Zealand Time, Fiji Time, Kamchatka Standard Time" value="12">[UTC + 12] New Zealand Time, Fiji Time, Kamchatka Standard Time</option><option title="[UTC + 12:45] Chatham Islands Time" value="12.75">[UTC + 12:45] Chatham Islands Time</option><option title="[UTC + 13] Tonga Time, Phoenix Islands Time" value="13">[UTC + 13] Tonga Time, Phoenix Islands Time</option><option title="[UTC + 14] Line Island Time" value="14">[UTC + 14] Line Island Time</option></select>
			</div>
		</fieldset>

		<fieldset>
			<legend>Confirmation of registration</legend>
			<p>To prevent automated registrations this forum requires you to complete this captcha. If you can't read the captcha or if you are visually impaired, please contact the <a href="#">administrator</a>.</p>

			<label for="captcha"><b>Confirmation code:</b></label>
		</fieldset>
	<div class="center">
		<div class="buttons">
			<button type="submit" value="Submit" >Submit</button>
			<button type="reset" value="Reset">Reset</button>
		</div>
	</div>
	</form>
</div>
<?php } ?>
