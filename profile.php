<h1>Account Details</h1>
<?php 
    include 'dbconfig.php';
    dbconnect();
    $res = dbquery("SELECT uid, username, email, password, dob FROM users");
    

    print '<table border="1"';
    while($row = $res->fetch_array()) {
        print '<tr>';
        print '<td>'.$row["uid"].'</td>';
        print '<td>'.$row["username"].'</td>';
        print '<td>'.$row["email"].'</td>';
        print '<td>'.$row["password"].'</td>';
        print '<td>'.$row["dob"].'</td>';
        print '</tr>';
    }

print '</table>';

// Frees the memory associated with a result
$res->free();
// close connection
$mysqli->close();
?>

>
<form method="get">

	<fieldset>
		<legend>Credentials</legend>
		<div>Username:</div> 
        <input readonly="readonly" type="text" value="John Doe" name="username"><br>
		<div>Password:</div> 
        <input readonly="readonly" type="password" value="Password" name="password"><br>
		<div>E-mail:</div> 
        <input readonly="readonly" type="email" value="john.doe@gmail.com" name="email"><br>
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