<?php
  dbconnect();
  if(!$_GET['fid']) {
    echo "<div class='error-box'>This forum does not exist</div>";
    require('main.php');
    die();
  }
  $fid = $_GET['fid'];
  $res = dbquery("SELECT COUNT(*) FROM forums 
                  WHERE fid=:fid", 
                  array('fid'=>$fid));
  if($res->fetchColumn() == 0) {
    echo "<div class='error-box'>This forum does not exist</div>";
    require('main.php');
    die;
  }
  $res = dbquery("SELECT COUNT(*) FROM forums 
                  WHERE parent_id=:fid AND main=0;",
                  array('fid'=>$fid));
  if($res->fetchColumn() != 0) {
    $res = dbquery("SELECT * FROM forums 
                    WHERE parent_id=:fid AND main=0
                    ORDER BY position;",
                    array('fid'=>$fid));
                    
    echo "<div class='subforums'><h2>Subforums</h2>";
    while($row = $res->fetch(PDO::FETCH_ASSOC)) {
      $sfid = $row['fid'];
      $title = $row['title'];
      $desc = $row['description'];
      $posts = $row['posts'];
      $topics = $row['topics'];
      echo "
      <a href='?page=forum&fid=$sfid'>
        <div class='forum'>
          <div class='forum-data'>
            <h3>$title</h3>
            <p>$desc</p>
          </div>
          <div class='forum-activity'>
            <p>Posts: $posts</p>
            <p>Topics: $topics</p>
          </div>
        </div>
      </a>
      ";
    }
    echo "</div><hr />";
  }
  echo "<div class='threads'><h2>Threads</h2>";
  $res = dbquery("SELECT COUNT(*) FROM threads 
                  WHERE fid=:fid 
                  ORDER BY lastpost_date;",
                  array('fid'=>$fid));
  if($res->fetchColumn() == 0) {
    echo "<h3>No topics in this forum yet</h3>";
    die();
  }
  $res = dbquery("SELECT * FROM threads 
                  WHERE fid=:fid 
                  ORDER BY lastpost_date;",
                  array('fid'=>$fid));
  while($row = $res->fetch(PDO::FETCH_ASSOC)) {
    $title = $row['title'];
    $tid = $row['tid'];
    $uid = $row['uid'];
    $date = $row['date'];
    $posts = $row['posts'];
    $lastpost_uid = $row['lastpost_uid'];
    $lastpost_date = $row['lastpost_date'];
    $user = getUsername($uid);
    $lastpost_user = getUsername($lastpost_uid);
    
    echo "
    <a href='?page=thread&tid=$tid'>
      <div class='thread'>
        <div class='thread-data'>
          <h3>$title</h3>
          <span>By: <a href='?page=profile&uid=$uid'>$user</a> on $date</span>
        </div>
        <div class='thread-activity'>
          <p>Posts: $posts</p>
          <span>Last post by: <a href='?page=profile&uid=$lastpost_uid'>$lastpost_user</a></span>
          <p>$lastpost_date</p>
        </div>
      </div>
    </a>
    ";
  }
  echo "</div>";
?>
