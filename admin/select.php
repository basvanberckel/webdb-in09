<?php
	require('../dbconfig.php');
	dbconnect();
	if(isset($_GET['selection'])) {
		$selection = $_GET['selection'];
		if($selection == 'category') {
			echo "  Create a new category:
					<br /><br />
					<form method='post'>
						<div class='form-header'>Category title:</div>
						<input type='text' name='title'>
						<select class='hidden' name='parent'>";
		}
		elseif($selection == 'forum') {
			echo "  Create a new forum:
					<br /><br />
					<form method='post'>
						<div class='form-header'>Forum title:</div>
						<input type='text' name='title'>
						<div class='form-header'>Forum description:</div>
						<textarea name='descr' cols='50' rows='10'></textarea>
						<br /><br />
						<span class='form-header'>Forum moderation:</span>
						<input name='mod' class='css-checkbox' type='checkbox' value='Yes' />
						<label for='forum-mod' name='mod-lbl' class='css-label'></label>
						<div class='form-header'>Forum category:</div>
						<select name='parent'>";

			$res = dbquery("SELECT cid, title
							FROM categories;");
			while($row = $res->fetch(PDO::FETCH_ASSOC)) {
				$cid   = $row['cid'];
				$title = $row['title'];
				echo "  	<option value=$cid>$title</option>";
			}
		}
		elseif($selection == 'subforum') {
			echo "  Create a new subforum:
					<br /><br />
					<form method='post'>
						<div class='form-header'>Forum title:</div>
						<input type='text' name='title'>
						<div class='form-header'>Forum description:</div>
						<textarea name='descr' cols='50' rows='10'></textarea>
						<br /><br />
						<span class='form-header'>Forum moderation:</span>
						<input name='mod' class='css-checkbox' type='checkbox' value='Yes' />
						<label for='forum-mod' name='mod-lbl' class='css-label'></label>
						<div class='form-header'>Main forum:</div>
						<select name='parent'>";

			$res = dbquery("SELECT fid, title
							FROM forums
							WHERE main = 1;");
			while($row = $res->fetch(PDO::FETCH_ASSOC)) {
				$fid   = $row['fid'];
				$title = $row['title'];
				echo "  	<option value=$fid>$title</option>";
			}
		}

		echo "	</select>
				<div class='buttons'>
					<button type='submit' name='submit' id='submit' value=$selection>Submit</button>
				</div>
			</form>";
	}
 ?>