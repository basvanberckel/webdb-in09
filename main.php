<?php
  dbconnect();
  $res = dbquery("SELECT * FROM categories 
                  ORDER BY position;");
  while($row = $res->fetch(PDO::FETCH_ASSOC)) {
    $title = $row['title'];
    $cid = $row['cid'];
    echo "
    <div class='category'>
      <h2>$title</h2>
    ";
    $fres = dbquery("SELECT * FROM forums 
                     WHERE parent_id=$cid AND main=1
                     ORDER BY position;");
    while($frow = $fres->fetch(PDO::FETCH_ASSOC)) {
      $fid = $frow['fid'];
      $title = $frow['title'];
      $desc = $frow['description'];
      echo "<a href='?page=forum&fid=$fid'>
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
    echo "</div>";
  }
?> 
