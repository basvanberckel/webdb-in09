<!DOCTYPE HTML>
<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
  <link rel="stylesheet" type="text/css" href="main.css">
</head>
<body>
  <?php
    include('header.php');
     
    if (isset($_GET['page']) {
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
  ?>
</body>
</html>
  
