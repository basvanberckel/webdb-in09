<?php
    $res = dbquery("INSERT INTO posts (title, comment)
                    VALUES (:title :comment");
 
    if($res) {
        echo "post successful!";
    } 
    else {
        echo "post failed!";
    }
?>
<h1>New Discussion</h1>

<!-- Temporary link to profile, should link to thread page -->
<form action="forum.php" method="post">
<fieldset>
             
    <div>Discussion Title:</div> <input type="text" name="title"><br>
    <div>Comment:</div> <textarea type="text" name="comment" cols=50 rows=10></textarea>
    <div><input type="submit" value="Post Discussion"></div>
	  			
</fieldset>
</form>