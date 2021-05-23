<?php

$host = "localhost";  
$user = "f0474370";  
$password = "deigviniev";  
$dbname = "f0474370_RKVGames";  
	
$con = mysqli_connect($host, $user, $password, $dbname);
// Check connection
if (!$con) {
  die("Connection failed: " . mysqli_connect_error());
}