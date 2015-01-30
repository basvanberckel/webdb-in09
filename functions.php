<?php

function getUsername($uid) {
  $res = dbquery("SELECT username FROM users WHERE uid=:uid", array("uid"=>$uid));
  $u = $res->fetch(PDO::FETCH_ASSOC);
  return $u['username'];
}

function getTopicTitle($tid) {
  
  $res = dbquery("SELECT title FROM threads WHERE tid=:tid", array("tid"=>$tid));
  $t = $res->fetch(PDO::FETCH_ASSOC);
  return $t['title'];
}

function getForumTitle($fid) {
  $res = dbquery("SELECT title FROM forums WHERE fid=:fid", array("fid"=>$fid));
  $t = $res->fetch(PDO::FETCH_ASSOC);
  return $t['title'];
}

function getParent($tid) { 
  $res = dbquery("SELECT fid FROM threads WHERE tid=:tid", array("tid"=>$tid));
  $t = $res->fetchColumn();
  return $t;
}

function getThread($pid) {
  $res = dbquery("SELECT tid FROM posts WHERE pid=:pid", array("pid"=>$pid));
  $p = $res->fetchColumn();
  return $p;
}

function getPost($pid) {
  $res = dbquery("SELECT * FROM posts WHERE pid=:pid", array("pid"=>$pid));
  $p = $res->fetchObject();
  return $p;
}

function updateStats($tid, $uid, $date, $newThread, $approved) { 
  $fid = getParent($tid);
  dbquery("UPDATE threads SET posts=posts+$approved, ". ($approved==1 ? "lastpost_uid=:uid, " : "") .
          "lastpost_date=FROM_UNIXTIME(:date) WHERE tid=:tid;",
          ($approved==1 ? array("uid"=>$uid, "date"=>$date, "tid"=>$tid) : array("date"=>$date, "tid"=>$tid)));
  if ($newThread) {
    $query = "UPDATE forums SET posts=posts+$approved, threads=threads+$approved,". ($approved==1 ? " lastpost_date=FROM_UNIXTIME(:date)":"")." WHERE fid=:fid;";
  } else {
    $query = "UPDATE forums SET posts=posts+$approved,". ($approved==1 ? " lastpost_date=FROM_UNIXTIME(:date)":"")." WHERE fid=:fid;";
  }
  dbquery($query, ($approved==1 ? array("date"=>$date, "fid"=>$fid) : array("fid"=>$date)));
}

function deletePost($pid, $tid) {
  $res = dbquery("DELETE FROM posts WHERE pid=:pid", array('pid'=>$pid));
  $res = dbquery("SELECT COUNT(*) FROM posts WHERE tid=:tid", array('tid'=>$tid));
  if($res->fetchColumn() == 0) {
    $res = dbquery("DELETE FROM threads WHERE tid=:tid", array('tid'=>$tid));
  echo "<script>window.location='/';</script>";
  }
}

function allow($permission) {
  $role = $_SESSION['login'] ? $_SESSION['user']->role : 0;
  $res = dbquery("SELECT role FROM permissions WHERE permission=:permission;", 
                  array("permission"=>$permission));
  $p = $res->fetch(PDO::FETCH_ASSOC);
  return (isset($p['role']) && $role >= $p['role']);
}

function isModerated($fid) {
  $res = dbquery("SELECT moderated FROM forums WHERE fid=:fid;",
                  array("fid"=>$fid));
  $m = $res->fetch(PDO::FETCH_ASSOC);
  return $m['moderated'];
}

function breadcrumbs($fid, $tid=null) {
  $title = getForumTitle($fid);
  $temp_fid = $fid;
  $breadcrumbs = [];
  while(true) {
    $res = dbquery("SELECT parent_id, main FROM forums
                    WHERE fid=:fid", array("fid"=>$temp_fid));
    $pid = $res->fetch(PDO::FETCH_ASSOC);
    if($pid['main'] == 1) {
      /*$cid = $pid['parent_id'];
      $res = dbquery("SELECT title FROM categories
                      WHERE cid=:cid", array("cid"=>$cid));
      $title = $res->fetch(PDO::FETCH_ASSOC);
      $breadcrumbs[$cid] = $title;*/
      break;
    } else {
      $temp_fid = $pid['parent_id'];
      $breadcrumbs[$temp_fid] = getForumTitle($temp_fid);
    }
  }
  echo "<div id='breadcrumbs'><a href='/'>Board index </a>";
  foreach(array_reverse($breadcrumbs, true) as $temp_fid => $temp_title) {
    echo "&gt&gt <a href='/?page=forum&fid=$temp_fid'>$temp_title </a>";
  }
  echo "&gt&gt <a href='/?page=forum&fid=$fid'>$title </a>";
  if ($tid != null) {
    $title = getTopicTitle($tid);
    echo "&gt&gt <a href='/?page=thread&tid=$tid'>$title</a></div>";  
  } else {
    echo "</div>";
  }
}
 ?>
