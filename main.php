<?php
  dbconnect();
  $res = dbquery("SELECT * FROM categories ORDER BY position;");
  for ($row_no = 0; $row_no < $res->num_rows; $row_no++) {
    $res->data_seek($row_no);
    $row = $res->fetch_assoc();
    $title = $row['title'];
    echo "
    <div class='category'>
      <h2>$title</h2> <hr />
    ";
    $fres = dbquery("SELECT * FROM forums WHERE cid=$row_no ORDER BY position;");
    for ($frow_no = 0; $frow_no < $fres->num_rows; $frow_no++) {
      $fres->data_seek($frow_no);
      $frow = $fres->fetch_assoc();
      $fid = $frow['fid'];
      $title = $frow['title'];
      $desc = $frow['description'];
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
  }
?> 