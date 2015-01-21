<?php
if(!($_SESSION['login'] && $_SESSION['user']->role > 0)) {
  echo "<div class='error-box'>You need to be registered and logged in to post</div>";
  require('main.php');
  die();
}

$db = dbconnect();
  
if ($_POST) {
  $newThread = false;
  $tid = $_POST['tid'];
  $uid = $_SESSION['user']->uid;
  $title = strip_tags($_POST['title']);
  $content = strip_tags($_POST['content']);
  $approved = ($_SESSION['user']->role = 10 ? 1 : 0);
  $date = time();
  $res = dbquery("INSERT INTO posts (uid, title, content, date, tid, approved)
                  VALUES (:uid, :title, :content, :date, :tid, :approved)",
                  array("uid"=>$uid, "title"=>$title,
                        "content"=>$content, "date"=>$date, 
                        "tid"=>$tid, "approved"=>$approved));
  $pid = $db->lastInsertId();
  
  if ($res && $tid == "" && array_key_exists('fid', $_POST)) {
    $newThread = true;
    $fid = $_POST['fid'];
    $res = dbquery("INSERT INTO threads 
                    (uid, title, pid, date, fid, lastpost_uid, lastpost_date, approved, posts)
                    VALUES (:uid, :title, :pid, :date, :fid, :uid, :date, :approved, 0);",
                    array("uid"=>$uid, "title"=>$title,
                          "pid"=>$pid, "date"=>$date,
                          "fid"=>$fid, "approved"=>$approved));
    $tid = $db->lastInsertId();
    dbquery("UPDATE posts SET tid=:tid WHERE pid=:pid;", array("tid"=>$tid,"pid"=>$pid));
  }
  if ($res) {
      echo "Post successful! View your post <a href='?page=thread&tid=$tid#p$pid'>here</a>";
      updateStats($tid, $uid, $date, $newThread);
  } else {
    echo "Something went wrong";
  }
} else {
  if(array_key_exists('tid', $_GET)) {
    $tid = $_GET['tid'];
    $title = "Re: " . getTopicTitle($tid);
    $fid = getParent($tid);
    echo "<h2>New post in $title</h2>";
  } elseif(array_key_exists('fid', $_GET)) {
    $title = "";
    $tid = "";
    $fid = $_GET['fid'];
    echo "<h2>New Thread</h2>";
  } else {
    echo "Forum or thread not defined";
    die();
  }
  
?>

<!-- Temporary link to profile, should link to thread page -->
<form method="POST">
<fieldset>
             
    <div>Discussion Title:</div> <input type="text" name="title" value="<?php echo $title?>"><br>
    <div>Comment:</div> <textarea type="text" name="content" cols=50 rows=10></textarea>
    <input type='hidden' name='tid' value="<?php echo $tid ?>" />
    <input type='hidden' name='fid' value="<?php echo $fid ?>" /> 
    <div><input type="submit" value="Post Discussion"></div>
	  			
</fieldset>
</form>
<?php } ?>
