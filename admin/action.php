<?php
	require('../dbconfig.php');
	dbconnect();
	$fid = $_GET['fid'];
	$action = $_GET['action'];
	echo "<html><body>";
	echo "$fid, $action, ";

	$res = dbquery("SELECT $action
					FROM forums
					WHERE fid = :fid;",
				   array('fid'=>$fid));
	while($row = $res->fetch(PDO::FETCH_ASSOC)) {
		print_r(array_values($row));
		if($row[$action] == 0) {
			$update = 1;
		} else {
			$update = 0;
		}
		echo ", $update";
		$res = dbquery("UPDATE forums
					SET $action = :update
					WHERE fid = :fid;",
				   array('update'=>$update,
						 'fid'=>$fid));
	}
	
	echo "</body></html>";
 ?>