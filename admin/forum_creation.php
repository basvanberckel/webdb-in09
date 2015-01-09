
<form action="create_forum.php" method="post">
	<div class="form-header">Forum title:</div>
	<input type="text" name="forum-title" id="forum-title">
	<div class="form-header">Forum description:</div>
	<textarea name="forum-descr" id="forum-descr" cols="40" rows="2"></textarea>
	<br />
	<div class="form-header">Forum moderation:</div>
	<input type="checkbox" name= forum-mod" id="forum-mod" value="1">
	<input type="text" name="forum-cat" id="forum-cat">
	<input type="text" name="forum-pos" id="forum-pos">
	<input type="submit" name="submit" id="submit">
</form>
