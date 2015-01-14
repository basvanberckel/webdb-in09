<?php
    include 'header.php';
?>

<h1>Account Details</h1>
    <link rel="stylesheet" type="text/css" href="styles/all.css">


 <form method="get">

	<fieldset>
		<legend>Credentials</legend>
		<div>Username:</div> <input readonly="readonly" type="text" value="John Doe" name="username"><br>
		<div>Password:</div> <input readonly="readonly" type="password" value="Password" name="password"><br>
		<div>E-mail:</div> <input readonly="readonly" type="email" value="john.doe@gmail.com" name="email"><br>
	</fieldset>

	<fieldset>
		<legend>Settings</legend>
		<div>Date of birth:</div> <input readonly="readonly" type="text" value="01-01-1970" name="birthdate"><br>
	</fieldset>

</form> 

<button onclick="edit()">Edit</button>
<button onclick="save()">Save</button>

<script>
	function edit() {
		document.getElementsByTagName("INPUT")[0].removeAttribute("readonly");
		document.getElementsByTagName("INPUT")[1].removeAttribute("readonly");
		document.getElementsByTagName("INPUT")[2].removeAttribute("readonly");
		document.getElementsByTagName("INPUT")[3].removeAttribute("readonly");
	}

	function save() {
		document.getElementsByTagName("INPUT")[0].setAttribute("readonly", "readonly");
		document.getElementsByTagName("INPUT")[1].setAttribute("readonly", "readonly");
		document.getElementsByTagName("INPUT")[2].setAttribute("readonly", "readonly");
		document.getElementsByTagName("INPUT")[3].setAttribute("readonly", "readonly");
	}
</script>

<?php
    include 'footer.php';
?>
