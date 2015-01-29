<?php
/* Admin header */
echo "
<div id='admin-header'>
	<div class='buttons'>
		<form>
			<a href='../index.php' id='back'>
				<img src='../images/return.gif' height='16' width='16' alt='' />
				Back to forums
			</a>
			<button type='submit' name='page' class='creation' value='creation'>
				Forum Creation
			</button>
			<button type='submit' name='page' class='management' value='management'>
				Forum Management
			</button>
			<button type='submit' name='page' class='moderation' value='moderation'>
				Moderation Queue
			</button>
			<button type='submit' name='page' class='creation' value='users'>
				User Management
			</button>
    	</form>
	</div>
</div>";
 ?>