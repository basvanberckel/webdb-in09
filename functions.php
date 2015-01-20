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

