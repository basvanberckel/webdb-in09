<?php
	require('../dbconfig.php');
	dbconnect();
	$action = $_GET['action'];
	if(isset($_GET['fid'])) {
		$fid = $_GET['fid'];
		if($action == 'delete') {
			$res = dbquery("DELETE FROM forums
							WHERE fid = :fid;",
						   array('fid'=>$fid));
		} else {
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
	}
	elseif(isset($_GET['uid'])) {
		$uid = $_GET['uid'];
		if($action == 'verified') {
			$res = dbquery("SELECT $action
							FROM users
							WHERE uid = :uid;",
						   array('uid'=>$uid));
			while($row = $res->fetch(PDO::FETCH_ASSOC)) {
				if($row[$action] == 0) {
					$update = 1;
				} else {
					$update = 0;
				}
				$res = dbquery("UPDATE users
								SET $action = :update
								WHERE uid = :uid;",
							   array('update'=>$update,
									 'uid'=>$uid));
			}
		}
		elseif($action == 'admin') {
			$res = dbquery("SELECT role
							FROM users
							WHERE uid = :uid;",
						   array('uid'=>$uid));
			while($row = $res->fetch(PDO::FETCH_ASSOC)) {
				if($row['role'] == 10) {
					$update = 1;
				} else {
					$update = 10;
				}
				$res = dbquery("UPDATE users
								SET role = :update
								WHERE uid = :uid;",
							   array('update'=>$update,
									 'uid'=>$uid));
			}
		}
			
	}
 ?>