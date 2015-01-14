<div id="login">

<?php

/* er is net uitgelogd */
if(isset($_GET['logout'])){

	session_destroy();
	
}

/* er is net ingelogd */
if(isset($_POST['username']) && isset($_POST['password']) && !empty($_POST['username']) && !empty($_POST['password'])){



	/*$result = mysql_query("SELECT * FROM users WHERE username='" . $_POST["user_name"] . "' AND password = '" . $_POST["password"] . "'");
	$row = mysql_fetch_array($result);
	if(is_array($row)){
		$_SESSION['UID'] = $row['UID'];
		$_SESSION['username'] = $row['username'];
		//TODO adminrechten nog niet geimplementeerd in de database?

	}*/

	//voor nu even
	$_SESSION['uid'] = 666;
	$_SESSION['username'] = $_POST['username'];

}


/* er is ingelogd */
if(isset($_SESSION['uid'])){


	echo '<br /><br />Welkom <b>' . $_SESSION['username'] . '</b>!<br /><br />';
	echo '<a href="?logout=0">Log uit</a>';

}
/* er is niet ingelogd */
else { ?>

<br />
<form action="#" method="post">
<input type="text" name="username" /> <br />
<input type="password" name="password" /> <br />
<a href="#">Wachtwoord vergeten?</a><br />
<a href="index.php?page=registration">Registreren</a>
<div class="buttons">
	<button type="submit" value="submit">Submit</button>
</div>
</form>

<?php } ?>


</div>




