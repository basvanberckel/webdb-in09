<!DOCTYPE HTML>
<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
  <link rel="stylesheet" type="text/css" href="../styles/all.css">
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
	elseif ($page == 'management') {
		echo " <link rel='stylesheet' type='text/css' href='../styles/main.css'>
				<script>
				function updateDB(divid, forum, act) {
					console.log(divid);
					console.log(forum);
					console.log(act);
					var xmlhttp;
					if (window.XMLHttpRequest) {
						xmlhttp=new XMLHttpRequest();
					} else {
						xmlhttp=new ActiveXObject('Microsoft.XMLHTTP');
					}
					xmlhttp.onreadystatechange=function() {
						if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
							document.getElementById(divid).innerHTML=xmlhttp.responseText;
						}
					  }
					xmlhttp.open('GET','action.php?fid='+forum+'&action='+act,true);
        			xmlhttp.send();
				}
				</script>";
	}
	elseif ($page == 'moderation') {
		echo "  <link rel='stylesheet' type='text/css' href='../styles/thread.css'>";
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