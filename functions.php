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
  $t = $res->fetch(PDO::FETCH_ASSOC);
  return $t['fid'];
}

function updateStats($tid, $uid, $date, $newThread) {
  $fid = getParent($tid);
  dbquery("UPDATE threads SET posts=posts+1, lastpost_uid=:uid, lastpost_date=:date WHERE tid=:tid;",
          array("uid"=>$uid, "date"=>$date, "tid"=>$tid));
  if ($newThread) {
    $query = "UPDATE forums SET posts=posts+1, threads=threads+1 WHERE fid=:fid;";
  } else {
    $query = "UPDATE forums SET posts=posts+1 WHERE fid=:fid;";
  }
  dbquery($query, array("fid"=>$fid));
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
                  array("fid",$fid));
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
