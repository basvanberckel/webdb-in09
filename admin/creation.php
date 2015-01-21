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
			
			$res = dbquery("INSERT INTO forums (title, description, moderated, parent_id, main, position)
							VALUES ($title, $descr, $moderated, $cid, 1, $pos);");
		}
	 ?>
	Create a new forum:
	<br /><br />
	<form method="post">
		<div class="form-header">Forum title:</div>
		<input type="text" name="title" id="forum-title">
		<div class="form-header">Forum description:</div>
		<textarea name="forum-descr" id="descr" cols="50" rows="10"></textarea>
		<br /><br />
		<span class="form-header">Forum moderation:</span>
		<input type="checkbox" name="mod" id="forum-mod" value="Yes">
		<div class="form-header">Forum category id:</div>
		<input type="text" name="cat" id="forum-cat">
		<div class="form-header">Forum position:</div>
		<input type="text" name="pos" id="forum-pos">
		<div class="buttons">
			<button type="submit" name="submit" id="submit">Sumbit</button>
		</div>
	</form>
</div>