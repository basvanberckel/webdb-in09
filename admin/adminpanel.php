<!DOCTYPE HTML>
<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
  <link rel="stylesheet" type="text/css" href="../styles/admin.css">
  <?php
    if (isset($_GET['page'])) {
      $page = $_GET['page'];
    } else {
      $page = 'forum_creation';
    }
    if (!is_file($page.'.php') || !is_readable($page.'.php')) {
      $page = '../404';
    }
   ?>
</head>
<body>
  <?php
	echo '<div id="main">';
	include('header.php');
    include($page.'.php');
    echo '<br /></div>';    
  ?>
</body>
</html>
  
