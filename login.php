<div id="login">

<?php

/* er is net uitgelogd */
if(isset($_GET['logout'])){

	session_destroy();
	
}

/* er is net ingelogd */
if(isset($_POST['username']) && isset($_POST['password']) && !empty($_POST['username']) && !empty($_POST['password'])){
  dbconnect();
  $res = dbquery("SELECT * FROM users 
                  WHERE username=:username",
                  array('username'=>$_POST['username']));
  $user = $res->fetchObject();
  if($user && password_verify($_POST['password'], $user->passwd)) {
    $_SESSION['user'] = $user;
  } else {
    echo "Wrong username or password.";
  }
}

/* er is ingelogd */
if(isset($_SESSION['user'])){


	echo '<br /><br />Welcome <b>' . $_SESSION['user']->username . '</b>!<br /><br />';
	echo '<a href="?logout=0">Log uit</a>';

}
/* er is niet ingelogd */
else { ?>

<br />
<form method="post">
<input type="text" name="username" /> <br />
<input type="password" name="password" /> <br />
<a href="#">Forgot password?</a><br />
<a href="index.php?page=registration">Register</a>
<div class="buttons">
	<button type="submit" value="submit">Submit</button>
</div>
</form>

<?php } ?>


</div>




