<?php
if ($_POST) {
    dbconnect();
    $res = dbquery("INSERT INTO posts (pid, uid, title, content, date, tid, approved)
                    VALUES ( , , 'dbtest', 'blablabla', CURRENT_TIMESTAMP, , )");
}

?>
<h1>New Discussion</h1>

<!-- Temporary link to profile, should link to thread page -->
<form method="POST">
<fieldset>
             
    <div>Discussion Title:</div> <input type="text" name="title"><br>
    <div>Comment:</div> <textarea type="text" name="comment" cols=50 rows=10></textarea>
    <div><input type="submit" value="Post Discussion"></div>
	  			
</fieldset>
</form>