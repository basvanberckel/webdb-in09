<div class="content" id="users">

<?php
$res = dbquery("SELECT *
				FROM users 
				ORDER BY username");
while ($user = $res->fetchObject()) {
	$uid = $user->uid;
	echo "	<div class='user'>
				<div class='username'>
					<a href='index.php?page=profile&uid=$uid'>{$user->username}</a>
				</div>
				<div class='user-options'>
					<input onclick='updateUsers(\"$uid-verified\", $uid, \"verified\")' name='closed' id=$uid-verified class='css-checkbox' type='checkbox' value='Yes' $verified />
					<label for=$uid-verified class='css-label'>Verified</label>
					<input onclick='updateUsers(\"$uid-admin\", $uid, \"admin\")' name='closed' id=$fid-closed class='css-checkbox' type='checkbox' value='Yes' $admin />
					<label for=$fid-admin class='css-label'>Admin</label>
				</div>
			</div>
			<br />";
}
?>
</div>
<script>
	
</script>