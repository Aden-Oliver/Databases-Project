<?php
class Database {
  public function __construct() {
    die('Init function error');
  }

  public static function dbConnect() {
	$mysqli = null;
	//connects to database
	require_once("/home/aaoliver/DBoliver.php");

	//catch a potential error, if unable to connect
  try {
  $mysqli = new PDO('mysql:host=' . DBHOST . ';dbname=' . DBNAME , USERNAME , PASSWORD);
   echo "successful connection"."<br />";
} catch (PDOException $e) {
  echo "Error!: ".$e->getMessage()."<br ?>";
  die("Could not connect to server ".DBNAME."<br />");
}

    return $mysqli;
  }

  public static function dbDisconnect() {
    $mysqli = null;
  }
}
?>
