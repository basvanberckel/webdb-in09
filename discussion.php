<?php include 'header.php'; ?>

<h1>New Discussion</h1>
        <link rel="stylesheet" type="text/css" href="styles/all.css">

	<!-- Temporary link to profile, should link to thread page -->
    <form action="index.php" method="post">
         <fieldset>

             <div>Discussion Title:</div> <input placeholder="Title" type="text" name="title"><br>
             <div>Comment:</div> <textarea placeholder="Comment" type="text" name="comment" cols=50 rows=10></textarea>
             <div><input type="submit" value="Post Discussion"></div>
	  			
         </fieldset>
    </form>

<?php
    include 'footer.php';
?>