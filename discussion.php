<?php
if(!allow('forum_posting')) {
  echo '<script>window.location="/";</script>';
  die();
} 

$db = dbconnect();
if ($_POST && array_key_exists('tid', $_POST) && array_key_exists('fid', $_POST)) {
  $newThread = false;
  $tid = $_POST['tid'];
  $uid = $_SESSION['user']->uid;
  $title = strip_tags($_POST['title']);
  require_once("bbcode.php");
  $content = parse_bbcode_html(strip_tags($_POST['content'],'<br>'));
  $approved = !isModerated($_POST['fid']) || allow('mod_approve') ? 1 : 0;
  $date = time();
  if (array_key_exists('pid', $_POST)) {
    $pid = $_POST['pid'];
    $res = dbquery("SELECT uid FROM posts WHERE pid=:pid", array('pid'=>$pid));
    $uid = $res->fetchColumn();
    if(!(allow("mod_edit") || (allow("forum_posting") && $_SESSION['user']->uid == $uid))) {
      echo '<script>window.location="/";</script>';
      die();
    }
    $pid = $_POST['pid'];
    $res = dbquery("UPDATE posts SET title=:title, content=:content, approved=:approved
                    WHERE pid=:pid;", array('title'=>$title, 'content'=>$content,
                                            'pid'=>$pid, 'approved'=>$approved));
    if ($res) {
      $tid = getThread($pid);
        echo "<script>window.location='/?page=thread&tid=$tid#p$pid';</script>";
    } else {
      echo "Something went wrong";
    }
  } else {
    $res = dbquery("INSERT INTO posts (uid, title, content, date, tid, approved)
                    VALUES (:uid, :title, :content, FROM_UNIXTIME(:date), :tid, :approved)",
                    array("uid"=>$uid, "title"=>$title,
                          "content"=>$content, "date"=>$date, 
                          "tid"=>$tid, "approved"=>$approved));
    $pid = $db->lastInsertId();
    
    if ($res && $tid == "") {
      $newThread = true;
      $fid = $_POST['fid'];
      $res = dbquery("INSERT INTO threads 
                      (uid, title, pid, date, fid, lastpost_uid, lastpost_date, approved, posts)
                      VALUES (:uid, :title, :pid, FROM_UNIXTIME(:date), :fid, :uid, 
                              FROM_UNIXTIME(:date), :approved, 0);",
                      array("uid"=>$uid, "title"=>$title,
                            "pid"=>$pid, "date"=>$date,
                            "fid"=>$fid, "approved"=>$approved));
      $tid = $db->lastInsertId();
      dbquery("UPDATE posts SET tid=:tid WHERE pid=:pid;", array("tid"=>$tid,"pid"=>$pid));
    }
    if ($res) {
        updateStats($tid, $uid, $date, $newThread, $approved);
        echo "<script>window.location='/?page=thread&tid=$tid#p$pid';</script>";
    } else {
      echo "Something went wrong";
    }
  }
} elseif(!(array_key_exists('tid', $_GET) || 
           array_key_exists('fid', $_GET) || 
           array_key_exists('pid', $_GET))) {
  echo "Forum or thread not defined";
} else {
  $content = "";
  if(array_key_exists('tid', $_GET)) {
    $tid = $_GET['tid'];
    $title = "Re: " . getTopicTitle($tid);
    $fid = getParent($tid);
    $legend = "New post in $title";
    $button = "Post";
  } elseif (array_key_exists('pid', $_GET)) {
    $pid = $_GET['pid'];
    $tid = getThread($pid);
    $title = getTopicTitle($tid);
    $fid = getParent($tid);
    $content = getPost($pid)->content;
    $legend = "Edit Post";
    $button = "Edit";
  } else {
    $title = "";
    $tid = "";
    $fid = $_GET['fid'];
    $legend = "New Thread";
    $button = "Create Thread";
  }
?>

<!-- Temporary link to profile, should link to thread page -->
<div id="registration">
<form method="POST">
<fieldset>
    <div id='error'></div>
    <legend><?php echo $legend ?></legend>
    <div>Discussion Title:</div> 
    <input type="text" class="txt" onchange="verify('title')" name="title" id="title" value="<?php echo $title?>" required><br>
    <div>Comment:</div> 
    <textarea type="text" onchange="verify('content')" name="content" id="content" cols=50 rows=10 value="<?php echo $content?>" required></textarea>
    <input type='hidden' name='tid' id="tid" value="<?php echo $tid ?>" />
    <input type='hidden' name='fid' id="fid" value="<?php echo $fid ?>" /> 
    <?php if (isset($pid)) { ?> 
    <input type='hidden' name='pid' id="pid" value="<?php echo $pid ?>" /> 
    <?php } ?>
    <div class="buttons">
	<button type="submit" value="submit"><?php echo $button ?></button>
    </div>
	  			
</fieldset>
</form>
<script>
function verify(id) {
  var elem = document.getElementById(id);
  if (elem.length < 6) {
    document.getElementById("error").innerHTML="Title and content need to be at least 6 characters";
    return false;
  } else {
    return true;
  }
}
</script>
    </div>
<?php } ?>
