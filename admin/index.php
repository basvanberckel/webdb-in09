<!DOCTYPE HTML>
<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
  <link rel="stylesheet" type="text/css" href="../styles/all.css">
  <link rel="stylesheet" type="text/css" href="../styles/main.css">
  <link rel="stylesheet" type="text/css" href="../styles/admin.css">
  <?php
	require('../dbconfig.php');
    if (isset($_GET['page'])) {
      $page = $_GET['page'];
    } else {
      $page = 'creation';
    }
    if (!is_file($page.'.php') || !is_readable($page.'.php')) {
      $page = '../404';
    }	
   ?>
</head>
<body>
  <?php
	echo '<div id="main">';
	require('header.php');
    require($page.'.php');
    echo '<br /></div>';    
   ?>
</body>
</html>