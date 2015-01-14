<?php
define('DBHOST', 'localhost');
define('DBNAME', 'forum');
define('DBUSER', 'forum');
define('DBPASS', 'yNZfG3ufzuyyZLd6');

function dbconnect() {
 global $conn;
 $conn = new mysqli(DBHOST, DBUSER, DBPASS, DBNAME);
 if ($conn->connect_errno) {
    echo "Failed to connect to MySQL: (" . $conn->connect_errno . ") " . $conn->connect_error;
  }
}

function dbquery($query) {
  global $conn;
  $conn->query($query);
  if (!$conn->query($query)) {
    echo "MySQL Query failed: {$conn->error}";
  }
} 
?>

