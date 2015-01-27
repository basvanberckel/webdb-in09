<?php
	require('../dbconfig.php');
	dbconnect();
	$fid = $_GET['fid'];
	$action = $_GET['action'];
	
	if($action == 'delete') {
		$res = dbquery("DELETE FROM forums
						WHERE fid = :fid;",
					   array('fid'=>$fid));
		echo "<script> window.location.reload(); </script>";
	}
	elseif($action == 'moderated' || $action == 'locked'
		|| $action == 'closed') {

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
			$res = dbquery("UPDATE forums
							SET $action = :update
							WHERE fid = :fid;",
						   array('update'=>$update,
								 'fid'=>$fid));
		}
	}
 ?>