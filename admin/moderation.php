<div class="content" id="moderation">

<?php
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
							WHERE pid=:pid;", array('pid'=>$pid));
			$date = time();
			updateStats($tid, $uid, $date, false, 1);
			$res = dbquery("UPDATE threads SET approved = 1 WHERE tid=:tid;", array('tid'=>$tid));
		}
		elseif($submit == 'Decline') {
			deletePost($pid, $tid);
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
