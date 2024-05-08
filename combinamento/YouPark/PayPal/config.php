<?php 
error_reporting(E_ALL & ~E_NOTICE);
session_start();
define('DBNAME','youpark');
define('DBUSER','admin');
define('DBPASS','admin');
define('DBHOST','localhost');
try {
  $db = new PDO("mysql:host=".DBHOST.";dbname=".DBNAME, DBUSER, DBPASS);
  $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  //echo "Your page is connected with database successfully..";
} catch(PDOException $e) {
  echo "Issue -> Connection failed: " . $e->getMessage();
}
?>