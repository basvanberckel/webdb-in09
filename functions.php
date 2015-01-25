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
  $res = dbquery("SELECT role FROM permissions WHERE permission=:permission", 
                  array("permission"=>$permission));
  $p = $res->fetch(PDO::FETCH_ASSOC);
  return (isset($p['role']) && $role >= $p['role']);
}
