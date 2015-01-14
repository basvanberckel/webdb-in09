<div class="content" id="creation-form">
	Create a new forum:
	<br /><br />
	<form action="create_forum.php">
		<div class="form-header">Forum title:</div>
		<input type="text" name="forum-title" id="forum-title">
		<div class="form-header">Forum description:</div>
		<textarea name="forum-descr" id="forum-descr" cols="50" rows="10"></textarea>
		<br /><br />
		<span class="form-header">Forum moderation:</span>
		<input type="checkbox" name="forum-mod" id="forum-mod" value="1">
		<div class="form-header">Forum category:</div>
		<input type="text" name="forum-cat" id="forum-cat">
		<div class="form-header">Forum position:</div>
		<input type="text" name="forum-pos" id="forum-pos">
		<div class="buttons">
			<button type="submit" name="submit" id="submit">Sumbit</button>
		</div>
		
	</form>
</div>