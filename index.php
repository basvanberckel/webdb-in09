<?php session_start() ?>
<!DOCTYPE HTML>
<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
  <link rel="stylesheet" type="text/css" href="styles/all.css">
  <link href='http://fonts.googleapis.com/css?family=Slabo+27px' rel='stylesheet' type='text/css'>
  <?php
    if (isset($_GET['page'])) {
      $page = $_GET['page'];
    } else {
      $page = 'main';
    }
    if (!is_file($page.'.php') || !is_readable($page.'.php')) {
      $page = '404';
    } else {
      echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"styles/$page.css\">";
    }
   ?>
</head>
<body>
  <?php
    require('header.php');
    echo "<div id='content'>\n";
    require($page.'.php');
    echo "</div>\n";    
    require('footer.php');
    ?>
</body>
</html>
  
