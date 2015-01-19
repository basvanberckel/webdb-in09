<div class="content" id="moderation">

<?php
	dbconnect();

	if(isset($_POST['submit'])) {
		$submit = $_POST['submit'];
		$pid    = $_POST['pid'];
		
		if($submit == 'Approve') {
			$res = dbquery("UPDATE posts
							SET approved = 1
							WHERE pid = $pid;");
		}
		elseif($submit == 'Decline') {
			$res = dbquery("DELETE FROM posts
					 		WHERE pid = $pid;");
		}
	}
	
	echo "These messages await your approval:";

	$res = dbquery("SELECT * FROM posts, users
					WHERE approved = 0 AND posts.uid = users.uid
					ORDER BY date;");
	
	while($row = $res->fetch(PDO::FETCH_ASSOC)) {
		$title    = $row['title'];
		$content  = $row['content'];
		$date     = $row['date'];
		$username = $row['username'];
		$pid      = $row['pid'];
		
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
					<div class='buttons'>
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