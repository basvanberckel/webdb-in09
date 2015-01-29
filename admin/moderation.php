<div class="content" id="moderation">

<?php
function updateStats($tid, $uid, $date, $newThread) {
  $fid = getParent($tid);
  dbquery("UPDATE threads SET posts=posts+1, lastpost_uid=:uid, 
          lastpost_date=FROM_UNIXTIME(:date) WHERE tid=:tid;",
          array("uid"=>$uid, "date"=>$date, "tid"=>$tid));
  if ($newThread) {
    $query = "UPDATE forums SET posts=posts+1, threads=threads+1 WHERE fid=:fid;";
  } else {
    $query = "UPDATE forums SET posts=posts+1 WHERE fid=:fid;";
  }
  dbquery($query, array("fid"=>$fid));
}
	dbconnect();
	/* If a choice is made, it will be processed here */
	if(isset($_POST['submit'])) {
		$submit = $_POST['submit'];
		$pid    = $_POST['pid'];
		$tid    = $_POST['tid'];
		$uid    = $_POST['uid'];
		
		if($submit == 'Approve') {
			$res = dbquery("UPDATE posts
							SET approved = 1
							WHERE pid = $pid;");
			$date = time();
			updateStats($tid, $uid, $date, false, 1);
		}
		elseif($submit == 'Decline') {
			$res = dbquery("DELETE FROM posts
					 		WHERE pid = $pid;");
		}
	}
	
	echo "These messages await your approval:";
	/* Selecting all posts that aren't approved */
	$res = dbquery("SELECT * FROM posts, users
					WHERE approved = 0 AND posts.uid = users.uid
					ORDER BY date;");
	
	while($row = $res->fetch(PDO::FETCH_ASSOC)) {
		$title    = $row['title'];
		$content  = $row['content'];
		$date     = $row['date'];
		$username = $row['username'];
		$pid      = $row['pid'];
		$tid      = $row['tid'];
		$uid      = $row['uid'];
		
		echo " <div class='post'>
				   <div class='post-content'>
						<h3>$title</h3>
						<p>$content</p>
					</div>
					<div class='post-data'>
						<p>$username</p>
						<p>$date</p>
					</div>
				</div>";
		echo " <form method='post'>
					<input type='hidden' name='pid' value=$pid>
					<input type='hidden' name='tid' value=$tid>
					<input type='hidden' name='uid' value=$uid>
					<div class='buttons mngbtns options'>
						<button type='submit' name='submit' id='approve' value='Approve'>
							Approve
						</button>
						<button type='submit' name='submit' id='decline' value='Decline'>
							Decline
						</button>
					</div>
				</form>";
	}
 ?>	
</div>