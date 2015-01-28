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
			if(isset($_POST['closed'])) {
				$closed = 1;
			} else {
				$closed = 0;
			}
			if(isset($_POST['locked'])) {
				$locked = 1;
			} else {
				$locked = 0;
			}
			if(isset($_POST['moderated'])) {
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
			echo   "<div class='forum draggable' id=$fid-forum>
						<div class='forum-manage'>
							<div class='title' id=$fid-title><h3>$title</h3></div>
							<div class='desc' id=$fid-desc><p>$desc</p></div>
						</div>
						<div class='forum-options'>
							<ul>
							<li>
								<input onclick='updateDB(\"$fid-closed\", $fid, \"closed\")' name='closed' id=$fid-closed class='css-checkbox' type='checkbox' value='Yes' $closed />
								<label for=$fid-closed class='css-label'>Closed</label>
							</li>
							<li>
								<input onclick='updateDB(\"$fid-locked\", $fid, \"locked\")' name='locked' id=$fid-locked class='css-checkbox' type='checkbox' value='Yes' $locked />
								<label for=$fid-locked class='css-label'>Locked</label>
							</li>
							<li>
								<input onclick='updateDB(\"$fid-moderated\", $fid, \"moderated\")' name='moderated' id=$fid-moderated class='css-checkbox' type='checkbox' value='Yes' $moderated />
								<label for=$fid-moderated class='css-label'>Moderated</label>
							</li>
							</ul>
						</div>
						<div class='forum-buttons buttons'>
							<button onclick='updateDB(\"$fid-forum\", $fid, \"delete\")' name='submit' id=$fid-delete value='Delete'>
								Delete
							</button>
						</div>

					</div>
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
				echo   "<div class='forum subforum draggable' id=$fid-forum>
						<div class='forum-manage'>
							<h3>$title</h3>
							<p>$desc</p>
						</div>
						<div class='forum-options'>
							<ul>
							<li>
								<input onclick='updateDB(\"$fid-closed\", $fid, \"closed\")' name='closed' id=$fid-closed class='css-checkbox' type='checkbox' value='Yes' $closed />
								<label for=$fid-closed class='css-label'>Closed</label>
							</li>
							<li>
								<input onclick='updateDB(\"$fid-locked\", $fid, \"locked\")' name='locked' id=$fid-locked class='css-checkbox' type='checkbox' value='Yes' $locked />
								<label for=$fid-locked class='css-label'>Locked</label>
							</li>
							<li>
								<input onclick='updateDB(\"$fid-moderated\", $fid, \"moderated\")' name='moderated' id=$fid-moderated class='css-checkbox' type='checkbox' value='Yes' $moderated />
								<label for=$fid-moderated class='css-label'>Moderated</label>
							</li>
							</ul>
						</div>
						<div class='forum-buttons buttons'>
							<button onclick='updateDB(\"$fid-forum\", $fid, \"delete\")' name='submit' id=$fid-delete>
								Delete
							</button>
						</div>

					</div>
				   ";
			}
		}
		echo "</div>";
	}
	
?> 

<script>
function updateDB(divid, forum, act) {
	console.log(divid);
	console.log(forum);
	console.log(act);
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
	xmlhttp.open('GET','action.php?fid='+forum+'&action='+act,true);
	xmlhttp.send();
}
</script>
</div>