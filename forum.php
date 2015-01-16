<?php
  dbconnect();
  if(!$_GET['fid']) {
    echo "<div class='error-box'>This forum does not exist</div>";
    require('main.php');
    die;
  }
  $fid = $_GET['fid'];
  $res = dbquery("SELECT * FROM forums WHERE fid=:fid", array('fid', $fid));
  if($res->rowCount == 0) {
    echo "<div class='error-box'>This forum does not exist</div>";
    require('main.php');
    die;
  }
  $res = dbquery("SELECT * FROM forums WHERE parent_id=:fid AND main=0;",
                  array('fid', $fid));
  if($res->rowCount != 0) {
    echo "<div class='subforums'><h2>Subforums</h2>";
    while($row = $res->fetch(PDO::FETCH_ASSOC)) {
      $fid = $row['fid'];
      $title = $row['title'];
      $desc = $row['description'];
      echo "
      <a href='?page=forum&fid=$fid'>
        <div class='forum'>
          <div class='forum-data'>
            <h3>$title</h3>
            <p>$desc</p>
          </div>
          <div class='forum-activity'>
            <p>Posts:</p>
            <p>Topics:</p>
          </div>
        </div>
      </a>
      ";
    }
    echo "</div><hr />";
  }
  echo "<div class='threads'><h2>Threads</h2>";
  $res = dbquery("SELECT * FROM threads WHERE fid=:fid ORDER BY lastpost_date;",
                  array('fid', $fid));
  if($res->rowCount == 0) {
    echo "<h3>No topics in this forum yet</h3>";
    die();
  }
  while($row = $res->fetch(PDO::FETCH_ASSOC)) {
    $title = $row['title'];
    $tid = $row['tid'];
    echo "
    <a href='?page=thread&tid=$tid'>
      <div class='thread'>
        <div class='thread-data'>
          <h3>$title</h3>
        </div>
      </div>
    </a>
    ";
  }
  echo "</div>";
?>
