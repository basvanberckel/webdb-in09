<div class="content" id="creation-form">

<?php
	dbconnect();

	if(isset($_POST['submit'])) {
		$submit = $_POST['submit'];
		if($submit == 'category') {
			$title = $_POST['title'];
			if(!(empty($title))) {
				$res = dbquery("SELECT MAX(position) 
								FROM categories;");
				if($row = $res->fetch(PDO::FETCH_ASSOC)) {
					$pos = $row['MAX(position)'] + 1;
					$res = dbquery("INSERT INTO categories (title, position)
									VALUES (:title, :pos);", 
									array('title'=>$title,
										  'pos'=>$pos));
					if($res) {
						echo "Category was succesfully created. <br />";
					}
				}
			}
			else {
				echo "You have to fill out the entire form. <br />";
			}
		}
		elseif($submit == 'forum') {
			$title = $_POST['title'];
			$descr = $_POST['descr'];
			if(isset($_POST['mod'])) {
				$moderated = 1;
			} else {
				$moderated = 0;
			}
			$pid = $_POST['parent'];
			if(!(empty($title) || empty($descr) || empty($pid))) {
				$res = dbquery("SELECT MAX(position) 
								FROM forums;");
				if($row = $res->fetch(PDO::FETCH_ASSOC)) {
					$pos = $row['MAX(position)'] + 1;
					$res = dbquery("INSERT INTO forums (title, description, moderated, parent_id, main, position)
									VALUES (:title, :descr, :moderated, :pid, 1, :pos);", 
									array('title'=>$title,
										  'descr'=>$descr,
										  'moderated'=>$moderated,
										  'pid'=>$pid,
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
		elseif($submit == 'subforum') {
			$title = $_POST['title'];
			$descr = $_POST['descr'];
			if(isset($_POST['mod'])) {
				$moderated = 1;
			} else {
				$moderated = 0;
			}
			$pid = $_POST['parent'];
			if(!(empty($title) || empty($descr) || empty($pid))) {
				$res = dbquery("SELECT MAX(position) 
								FROM forums
								WHERE parent_id = :pid AND main = 0;",
							   array('pid'=>$$pid));
				if($row = $res->fetch(PDO::FETCH_ASSOC)) {
					$pos = $row['MAX(position)'] + 1;
					$res = dbquery("INSERT INTO forums (title, description, moderated, parent_id, main, position)
									VALUES (:title, :descr, :moderated, :pid, 0, :pos);", 
									array('title'=>$title,
										  'descr'=>$descr,
										  'moderated'=>$moderated,
										  'pid'=>$pid,
										  'pos'=>$pos));
					if($res) {
						echo "Subforum was succesfully created. <br />";
					}
				}

			}
			else {
				echo "You have to fill out the entire form. <br />";
			}
		}
		
	}
	echo "  <select onchange='select(this.value)'>
				<option value='category'>Category</option>
				<option value='forum' selected='selected'>Forum</option>
				<option value='subforum'>Subforum</option>
			</select>
			<div id='creation'>";
	if(isset($_GET['selection'])) {
		$selection = $_GET['selection'];
	}
	
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

	echo "		</select>
				<div class='buttons'>
					<button type='submit' name='submit' value='forum'>Submit</button>
				</div>
			</form>";
	echo "	</div>";

 ?>
 
</div>

<script>
function select(selection) {
	if (window.XMLHttpRequest) {
		// code for IE7+, Firefox, Chrome, Opera, Safari
		xmlhttp = new XMLHttpRequest();
	} else {
		// code for IE6, IE5
		xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttp.onreadystatechange = function() {
		if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
			document.getElementById('creation').innerHTML = xmlhttp.responseText;
		}
	}
	xmlhttp.open("GET","admin/select.php?selection="+selection,true);
	xmlhttp.send();
}
</script>
