<?php
  dbconnect();
  if(!$_GET['tid']) {
    echo "<div class='error-box'>This topic does not exist</div>";
    require('main.php');
    die();
  }
  $tid = $_GET['tid'];
  $res = dbquery("SELECT COUNT(*) FROM threads 
                  WHERE tid=:tid", 
                  array('tid'=>$tid));
  if($res->fetchColumn() == 0) {
    echo "<div class='error-box'>This topic does not exist</div>";
    require('main.php');
    die;
  }
  $title = getTopicTitle($tid);
  echo "<div id='thread'>
          <div id='title'>
            <a href='?page=thread&tid=$tid'><h1>$title</h1></a>
          </div>";
  if (isset($_SESSION['user']) && $_SESSION['user']->role = 10) {
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
    $content = $row['content'];
    $uid = $row['uid'];
    $date = $row['date'];
    $user = getUsername($uid);
    echo "  
    <div class='post'>
      <div class='post-content'>
        <a name='p$pid' href='?page=thread&tid=$tid#p$pid'><h2>$title</h2></a>
        <p>$content</p>
      </div>
      <div class='post-data'>
        <span>Username: <a href='?page=profile&uid=$uid'>$user</a></span>
        <p>Date: $date</p>
      </div>
    </div>";
  }
  echo "</div>";
?>
