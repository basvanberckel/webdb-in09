<div class="content" id="creation-form">

<?php
	dbconnect();

	if(isset($_POST['submit'])) {
		$title = $_POST['title'];
		$descr = $_POST['descr'];
		if(isset($_POST['mod'])) {
			$moderated = 1;
		} else {
			$moderated = 0;
		}
		$cid = $_POST['cat'];
		if(!(empty($title) || empty($descr) || empty($cid))) {
			$res = dbquery("SELECT MAX(position) 
							FROM forums;");
			if($row = $res->fetch(PDO::FETCH_ASSOC)) {
				$pos = $row['MAX(position)'] + 1;
				$res = dbquery("INSERT INTO forums (title, description, moderated, parent_id, main, position)
								VALUES (:title, :descr, :moderated, :cid, 1, :pos);", 
								array('title'=>$title,
									  'descr'=>$descr,
									  'moderated'=>$moderated,
									  'cid'=>$cid,
									  'pos'=>$pos));
				if($res) {
					echo "Forum was succesfully created. <br />";
				}
			}

		}
		else {
			echo "You have to fill out the entire form. <br />";
		}
	}
	
	echo "  Create a new forum:
			<br /><br />
			<form method='post'>
				<div class='form-header'>Forum title:</div>
				<input type='text' name='title' id='forum-title'>
				<div class='form-header'>Forum description:</div>
				<textarea name='descr' id='forum-descr' cols='50' rows='10'></textarea>
				<br /><br />
				<span class='form-header'>Forum moderation:</span>
				<input name='mod' id='forum-mod' class='css-checkbox' type='checkbox' value='Yes' />
				<label for='forum-mod' name='mod-lbl' class='css-label'></label>
				<div class='form-header'>Forum category:</div>
				<select name='cat' id='forum-cat'>";

	$res = dbquery("SELECT cid, title
					FROM categories;");
	while($row = $res->fetch(PDO::FETCH_ASSOC)) {
		$cid   = $row['cid'];
		$title = $row['title'];
		echo "  	<option value=$cid>$title</option>";
	}

	echo "		</select>
				<div class='buttons'>
					<button type='submit' name='submit' id='submit'>Submit</button>
				</div>
			</form>";

 ?>
</div>