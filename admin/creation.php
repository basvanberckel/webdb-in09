<div class="content" id="creation-form">

<?php
	dbconnect();

	if(isset($_POST['submit'])) {
		$title = $_POST['title'];
		$descr = $_POST['descr'];
		if($_POST['mod'] == "Yes") {
			$moderated = 1;
		} else {
			$moderated = 0;
		}
		$cid = $_POST['cat'];
		$pos = $_POST['pos'];
		echo "$title, $descr, $moderated, $cid, $pos";
		if(!(empty($title) || empty($descr) || empty($cid) ||empty($pos))) {
			if(is_numeric($cid) && is_numeric($pos)) {
				$res = dbquery("INSERT INTO forums (title, description, moderated, parent_id, main, position)
								VALUES (:title, :descr, :moderated, :cid, 1, :pos);", 
								array('title'=>$title,
									  'descr'=>$descr,
									  'moderated'=>$moderated,
									  'cid'=>$cid,
									  'pos'=>$pos));
			}
			else {
				echo "Position needs to be a number. <br />";
			}

		}
		else {
			echo "You have to fill out the entire form. <br />";
		}
	}
	$res = dbquery("SELECT cid, title
					FROM categories;");
	echo "  Create a new forum:
			<br /><br />
			<form method='post'>
				<div class='form-header'>Forum title:</div>
				<input type='text' name='title' id='forum-title'>
				<div class='form-header'>Forum description:</div>
				<textarea name='descr' id='forum-descr' cols='50' rows='10'></textarea>
				<br /><br />
				<span class='form-header'>Forum moderation:</span>
				<input type='checkbox' name='mod' id='forum-mod' value='Yes'>
				<div class='form-header'>Forum category:</div>
				<input type='text' name='cat' id='forum-cat'>
				<div class='form-header'>Forum position:</div>
				<input type='text' name='pos' id='forum-pos'>
				<div class='buttons'>
					<button type='submit' name='submit' id='submit'>Submit</button>
				</div>
			</form>";

 ?>
	