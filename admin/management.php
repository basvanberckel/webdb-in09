<div class="content" id="management">

<?php
	dbconnect();

	if(isset($_POST['submit'])) {
		$submit = $_POST['submit'];
		$fid    = $_POST['fid'];
		/* This sets the closed, locked, and moderated values to the ones that were
		 * filled in
		 */
		if($submit == 'Submit') {
			if($_POST['closed'] == 'Yes') {
				$closed = 1;
			} else {
				$closed = 0;
			}
			if($_POST['locked'] == 'Yes') {
				$locked = 1;
			} else {
				$locked = 0;
			}
			if($_POST['moderated'] == 'Yes') {
				$moderated = 1;
			} else {
				$moderated = 0;
			}
			$pos = $_POST['pos'];
			if(is_numeric($pos)) {
				$res = dbquery("UPDATE forums
								SET closed = :closed, locked = :locked, moderated = :moderated, position = :pos
								WHERE fid = :fid;",
							   array('closed'=>$closed,
									 'locked'=>$locked,
									 'moderated'=>$moderated,
									 'pos'=>$pos,
									 'fid'=>$fid));
			}
			else {
				echo "Position needs to be a number. <br />";
			}
		}
		elseif($submit == 'Delete') {
			$res = dbquery("DELETE FROM forums
							WHERE fid = :fid;",
						   array('fid'=>$fid));
		}
	}

	$res = dbquery("SELECT * FROM categories 
					ORDER BY position;");
	while($row = $res->fetch(PDO::FETCH_ASSOC)) {
		$title = $row['title'];
		$cid   = $row['cid'];
		echo "
			<div class='category'>
			<h2>$title</h2>
			 ";
		$fres = dbquery("SELECT * FROM forums 
						 WHERE parent_id=:cid AND main=1
						 ORDER BY position;",
					    array('cid'=>$cid));
		while($frow = $fres->fetch(PDO::FETCH_ASSOC)) {
			$closed    = '';
			$locked    = '';
			$moderated = '';
			if($frow['closed'] == 1) {
				$closed = 'checked';
			}
			if($frow['locked'] == 1) {
				$locked = 'checked';
			}
			if($frow['moderated'] == 1) {
				$moderated = 'checked';
			}
			$fid     = $frow['fid'];
			$title   = $frow['title'];
			$desc    = $frow['description'];
			$pos     = $frow['position'];
			$posts   = $frow['posts'];
			$threads = $frow['threads'];
			echo   "<div class='forum'>
						<div class='forum-data'>
							<h3>$title</h3>
							<p>$desc</p>
						</div>
						<div class='forum-activity'>
							<p>Posts: $posts</p>
							<p>Topics: $threads</p>
						</div>
					</div>
					<form method='post'>
						<div class='options'>
							<input type='hidden' name='fid' value=$fid />
							<input name='closed' id=$fid-closed class='css-checkbox' type='checkbox' value='Yes' $closed />
							<label for=$fid-closed class='css-label'>Closed</label>
							<input name='locked' id=$fid-locked class='css-checkbox' type='checkbox' value='Yes' $locked />
							<label for=$fid-locked class='css-label'>Locked</label>
							<input name='moderated' id=$fid-moderated class='css-checkbox' type='checkbox' value='Yes' $moderated />
							<label for=$fid-moderated class='css-label'>Moderated</label>
							<br />
							Position: <input type='text' name='pos' id=$fid-position value=$pos />
							

							<div class='buttons mngbtns'>

								<button type='submit' name='submit' id='submit' value='Submit'>
									Submit
								</button>

								<button type='submit' name='submit' id='delete' value='Delete'>
									Delete
								</button>

							</div>
						</div>
					</form>
				   ";
			$sfres = dbquery("SELECT * FROM forums
							  WHERE parent_id=:fid AND main=0
							  ORDER BY position;",
							 array('fid'=>$fid));
			while($sfrow = $sfres->fetch(PDO::FETCH_ASSOC)) {
				$closed = '';
				$locked = '';
				$moderated = '';
				if($sfrow['closed'] == 1) {
					$closed = 'checked';
				}
				if($sfrow['locked'] == 1) {
					$locked = 'checked';
				}
				if($sfrow['moderated'] == 1) {
					$moderated = 'checked';
				}
				$fid     = $sfrow['fid'];
				$title   = $sfrow['title'];
				$desc    = $sfrow['description'];
				$pos     = $sfrow['position'];
				$posts   = $sfrow['posts'];
				$threads = $sfrow['threads'];
				echo   "<div class='forum subforum'>
							<div class='forum-data'>
								<h3>$title</h3>
								<p>$desc</p>
							</div>
							<div class='forum-activity'>
								<p>Posts: $posts</p>
								<p>Topics: $threads</p>
							</div>
						</div>
						<form method='post'>
							<div class='suboptions'>
								<input type='hidden' name='fid' value=$fid />
								Closed:<input type='checkbox' name='closed' value='Yes' $closed />
								Locked:<input type='checkbox' name='locked' value='Yes' $locked />
								Moderated:<input type='checkbox' name='moderated' value='Yes' $moderated />
								Position: <input type='text' name='pos' id='pos' value=$pos />

								<div class='buttons mngbtns'>

									<button type='submit' name='submit' id='submit' value='Submit'>
										Submit
									</button>

									<button type='submit' name='submit' id='delete' value='Delete'>
										Delete
									</button>

								</div>
							</div>
						</form>
					   ";
			}
		}
		echo "</div>";
	}
?> 

</div>