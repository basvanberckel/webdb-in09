<div class="content" id="users">

<?php
$res = dbquery("SELECT *
				FROM users 
				ORDER BY username");
while ($user = $res->fetchObject()) {
	$uid      = $user->uid;
	$verified = '';
	$admin = '';
	if($user->verified == 1) {
		$verified = 'checked';
	}
	if($user->role == 10) {
		$admin = 'checked';
	}
	echo "	<div class='user'>
				<div class='username'>
					<a href='index.php?page=profile&uid=$uid'>{$user->username}</a>
				</div>
				<div class='user-options'>
					<input onclick='updateUsers(\"$uid-verified\", $uid, \"verified\")' name='verified' id=$uid-verified class='css-checkbox' type='checkbox' value='Yes' $verified />
					<label for=$uid-verified class='css-label'>Verified</label>
					<input onclick='updateUsers(\"$uid-admin\", $uid, \"admin\")' name='admin' id=$uid-admin class='css-checkbox' type='checkbox' value='Yes' $admin />
					<label for=$uid-admin class='css-label'>Admin</label>
				</div>
			</div>
			<br />";
}
?>
</div>
<script>
function updateUsers(divid, user, act) {
	var xmlhttp;
	if (window.XMLHttpRequest) {
		xmlhttp=new XMLHttpRequest();
	} else {
		xmlhttp=new ActiveXObject('Microsoft.XMLHTTP');
	}
	xmlhttp.onreadystatechange=function() {
		if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
			document.getElementById(divid).innerHTML=xmlhttp.responseText;
		}
	  }
	xmlhttp.open('GET','admin/action.php?uid='+user+'&action='+act,true);
	xmlhttp.send();
}
</script>