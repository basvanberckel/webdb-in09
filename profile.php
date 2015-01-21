<h1>Account Details</h1>
<?php
    dbconnect();
    $res = dbquery("SELECT * FROM users");
    
    //print '<table border="1"';
    //while($row = $res->fetch(PDO::FETCH_ASSOC)) {
    //    print '<tr>';
    //    print '<td>'.$row["uid"].'</td>';
    //    print '<td>'.$row["username"].'</td>';
    //    print '<td>'.$row["email"].'</td>';
    //    print '<td>'.$row["dob"].'</td>';
    //    print '</tr>';
    //}

//print '</table>';
?>
<div id="profile">
	<form method="POST">
		<fieldset>
			<legend>Credentials</legend>
			<div>
				<label for="username"><b>Username:</b></label>
				<input type="text" name="username" id="username" class="txt"/>
			</div>

			<div>
				<label for="email"><b>E-mail address:</b></label>
				<input type="text" name="email" id="email" class="txt"/>
			</div>

			<div>
				<label for="password"><b>Password:</b></label>
				<input type="password" name="password" id="password" class="txt"/>
			</div>
                
            <div>
                <label for="dob"><b>Date of birth:</b></label>
                <input type="date" name="dob" id="dob" max="2015-01-31" min="1900-01-01" class="txt"/>
            </div>

            <div>
                <label for="sex"><b>Sex:</b></label>
				<input type="radio" name="sex" value="man" checked>Male
				<input type="radio" name="sex" value="vrouw" >Female
            </div> 
		</fieldset>

	<div class="center">
		<div class="buttons">
			<button type="submit" class="small" value="Submit" >Submit</button>
			<button type="reset" class="small" value="Reset">Reset</button>
		</div>
	</div>
	</form>
</div>

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