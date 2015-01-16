<?php
define('DBHOST', 'mysql:localhost');
define('DBNAME', 'forum');
define('DBUSER', 'forum');
define('DBPASS', 'yNZfG3ufzuyyZLd6');

function dbconnect() {
  global $conn;
  try {
    $conn = new PDO(DBHOST.';'.DBNAME, DBUSER, DBPASS);
  }
  $conn = null;
  catch(PDOException $e) {
    echo "Failed to connect to MySQL: {$e->getMessage()}.";
  }
}

function dbquery($query, array $kwargs=array(), $exec=true) {
  global $conn;
  try {
    $stmt = $conn->prepare($query);
    foreach($kwargs as $key => $value) {
      $stmt->bindParam(':'.$key, $value);
    }
    if ($exec) {
      $stmt->execute();
    }
  }
  catch(PDOException $e) {
    echo "MySQL Query failed: {$e->getMessage()}";
  }
  return $stmt;
} 
?>

