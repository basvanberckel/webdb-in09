<?php
define('DBHOST', 'in09.webdb.fnwi.uva.nl');
define('DBNAME', 'forum');
define('DBUSER', 'bas');
define('DBPASS', 'No-Risk1994');

function dbconnect() {
 global $conn;
 $conn = new mysqli(DBHOST, DBNAME, DBUSER, DBPASS);
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

