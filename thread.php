<?php
  dbconnect();
  if(!$_GET['tid']) {
    echo "<script>window.location='/';</script>";
    die();
  }
  $tid = $_GET['tid'];
  $res = dbquery("SELECT COUNT(*) FROM threads 
                  WHERE tid=:tid", 
                  array('tid'=>$tid));
  if($res->fetchColumn() == 0) {
    echo "<script>window.location='/';</script>";
    die();
  }
  if(array_key_exists('delete', $_GET)) {
    $pid = $_GET['delete'];
    $res = dbquery("SELECT uid FROM posts WHERE pid=:pid", array('pid'=>$pid));
    $uid = $res->fetchColumn();
    if(allow("mod_delete") || (allow("forum_posting") && $_SESSION['user']->uid == $uid)) {
      echo "<script>var r = confirm('Are you sure you want to delete this post?');
      if (r == false) {
        window.location('/?page=thread&tid=$tid');
      }
      </script>";
      deletePost($pid, $tid);
    }
  }
  $title = getTopicTitle($tid);
  breadcrumbs(getParent($tid), $tid);
  
  echo "<div id='thread'>
          <div id='titlebar'>
            <div id='title'>
              <a href='?page=thread&tid=$tid'><h1>$title</h1></a>
            </div>
            <div id='post-button'>
            <div class='buttons'>
              <a href='?page=discussion&tid=$tid'><button>Post Reply</button></a>
            </div>
            </div>
            
          </div>";
  if (allow('mod_approve')) {
    $res = dbquery("SELECT * FROM posts
                    WHERE tid=:tid
                    ORDER BY date;",
                    array('tid'=>$tid));
  } else {
    $res = dbquery("SELECT * FROM posts
                    WHERE tid=:tid AND approved=1
                    ORDER BY date;",
                    array('tid'=>$tid));
  }
  while($row = $res->fetch(PDO::FETCH_ASSOC)) {
    $pid = $row['pid'];
    $title = $row['title'];
    $content = nl2br($row['content']);
    $uid = $row['uid'];
    $date = date("D, d M Y H:i", strtotime($row['date']));
    $user = getUsername($uid);
    echo "
    <a name='p$pid'></a>
    <div class='post'>
      <div class='post-data'>
        <span>Username: <a href='?page=profile&uid=$uid'>$user</a></span>
        <p>Date: $date</p>";
      if (allow("mod_delete") || (allow("forum_posting") && $_SESSION['user']->uid == $uid)) {
        echo "<div class='buttons delete'><button onclick=\"deletePost($pid, $tid)\">Delete Post</button></div>";
      }
      if (allow("mod_edit") || (allow("forum_posting") && $_SESSION['user']->uid == $uid)) {
        echo "<div class='buttons delete'>
                <button onclick=\"window.location='/?page=discussion&pid=$pid';\">Edit Post</button>
              </div>";
      }
      echo "
      </div>
      <div class='post-content'>
        <a href='?page=thread&tid=$tid#p$pid'><h2>$title</h2></a>
        <span>$content</span>
      </div>
      
    </div>";
  }
  echo "</div>";
?>
<script>
function deletePost(pid, tid) {
  window.location='/?page=thread&tid='+tid+'&delete='+pid;
}
</script>
