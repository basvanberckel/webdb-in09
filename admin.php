<?php session_start() ?>
<!DOCTYPE HTML>
<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
  <link rel="stylesheet" type="text/css" href="../styles/all.css">
  <link rel="stylesheet" type="text/css" href="../styles/admin.css">
  <?php
  require('functions.php');
	require('dbconfig.php');
  dbconnect();
    if (isset($_GET['page'])) {
      $page = $_GET['page'];
    } else {
      $page = 'creation';
    }
    if (!is_file('admin/'.$page.'.php') || !is_readable('admin/'.$page.'.php')) {
      $page = '../404';
	}
	elseif ($page == 'management') {
		echo " <link rel='stylesheet' type='text/css' href='../styles/main.css'>";
	}
	elseif ($page == 'moderation') {
		echo "  <link rel='stylesheet' type='text/css' href='../styles/thread.css'>";     
	}
   ?>
</head>
<body>
  <?php
  require("header.php");
  if(allow('acp_view')) {
	  echo '<div id="main">';
	  require('admin/header.php');
    require('admin/'.$page.'.php');
    echo '<br /></div>';    
  } else {
    echo "You are not allowed to view this page";
  } 
  require("footer.php"); 
  ?>
</body>
</html>
