<?php
  dbconnect();
  if(!$_GET['fid']) {
    echo "<script>window.location='/';</script>";
    die();
  }
  $fid = $_GET['fid'];
  $res = dbquery("SELECT COUNT(*) FROM forums 
                  WHERE fid=:fid", 
                  array('fid'=>$fid));
  if($res->fetchColumn() == 0) {
    echo "<script>window.location='/';</script>";
    die();
  }
  echo breadcrumbs($fid);         
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
      $threads = $row['threads'];
      echo "
      <a href='?page=forum&fid=$sfid'>
        <div class='forum'>
          <div class='forum-data'>
            <h3>$title</h3>
            <p>$desc</p>
          </div>
          <div class='forum-activity'>
            <p>Posts: $posts</p>
            <p>Topics: $threads</p>
          </div>
        </div>
      </a>
      ";
    }
    echo "</div>";
  }
  echo "<div class='threads'><h2>Threads</h2>";
  echo "<a href='/?page=discussion&fid=$fid'><div class='thread newthread'><div class='thread-data'><h3>+ New Thread</h3></div></div></a>";

  $res = dbquery("SELECT COUNT(*) FROM threads 
                  WHERE fid=:fid 
                  ORDER BY lastpost_date;",
                  array('fid'=>$fid));
  if($res->fetchColumn() == 0) {
    echo "<div class='error'><h3>No threads in this forum yet!</h3></div>";
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
    $date = date("D, d M Y H:i", strtotime($row['date']));
    $posts = $row['posts'];
    $lastpost_uid = $row['lastpost_uid'];
    $lastpost_date = date("D, d M Y H:i", strtotime($row['lastpost_date']));
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
