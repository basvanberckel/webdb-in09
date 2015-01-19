<?php
    dbconnect();
    $res = dbquery("INSERT INTO posts (title, comment)
                    VALUES (:title :comment)");
 

?>
<h1>New Discussion</h1>

<!-- Temporary link to profile, should link to thread page -->
<form action="index.php" method="post">
<fieldset>
             
    <div>Discussion Title:</div> <input type="text" name="title"><br>
    <div>Comment:</div> <textarea type="text" name="comment" cols=50 rows=10></textarea>
    <div><input type="submit" value="Post Discussion"></div>
	  			
</fieldset>
</form>