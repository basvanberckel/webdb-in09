<?php
    dbconnect();
    $res = dbquery("INSERT INTO `forum`.`posts` (title, comment)
                    VALUES (:title :comment)",
                    array('title'=>$_POST['title'],
                        'comment'=>$_POST['content']));

?>
<h1>New Discussion</h1>

<!-- Temporary link to profile, should link to thread page -->
<form method="post">
<fieldset>
             
    <div><label for="title">Discussion Title:</label></div> <input type="text" name="title"><br>
    <div><label for="comment">Comment:</label></div> <textarea type="text" name="comment" cols=50 rows=10></textarea>
    <div><input type="submit" value="Post Discussion"></div>
	  			
</fieldset>
</form>