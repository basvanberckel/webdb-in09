<<<<<<< HEAD
<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
  <link rel="stylesheet" type="text/css" href="styles/all.css">
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
=======
<!DOCTYPE HTML>
<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
  <link rel="stylesheet" type="text/css" href="main.css">
</head>
<body>
  <?php
    include('header.php');
     
    if (isset($_GET['page'])) {
      $page = $_GET['page'].'.php';
    } else {
      $page = 'main.php';
    }
    
    if (is_file($page) && is_readable($page)) {
      include($page);
    } else {
      include('404.php');
    }
    
    include('footer.php');
>>>>>>> 200b14e66ae8239789fc645d69eeeae6cceace55
  ?>
</body>
</html>
  
