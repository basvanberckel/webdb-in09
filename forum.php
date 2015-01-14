<?php
  dbconnect();
  if(!$_GET['fid']) {
    echo "<div class='error-box'>This forum does not exist</div>";
    require('main.php');
    die;
  }
  $fid = $_GET['fid'];
  $res = dbquery("SELECT * FROM forums WHERE parent_id=$fid AND main=0;", false);
  if($res) {
    echo "<h2>Subforums</h2>";
    for($row_no = 0; $row_no < $res->num_rows; $row_no++) {
      $res->data_seek($row_no);
      $forum = $res->fetch_assoc();
      $fid = $forum['fid'];
      $title = $forum['title'];
      $desc = $forum['description'];
      echo "
      <a href='/?page=forum&fid=$fid'>
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
    echo "<hr />";
  }
  echo "<h2>Threads</h2>";
  $res = dbquery("SELECT * FROM threads WHERE fid=$fid ORDER BY lastpost_date;");
  if(!$res) {
    echo "<h1>No topics in this forum yet</h1>";
    die();
  }
  for($row_no = 0; $row_no < $res->num_rows; $row_no++) {
    $res->data_seek($row_no);
    $thread = $res->fetch_assoc();
    $title = $thread['title'];
    $tid = $thread['tid'];
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
?>
