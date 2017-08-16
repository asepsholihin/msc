<?php

$host = "localhost";
$user = "root";
$pass = "";
$db   = "master";

//connection
$mysqli = new mysqli($host, $user, $pass, $db);
if($mysqli->connect_errno) {
  echo "gagal mengkoneksikan database dengan error: ". $mysqli->connect_error;
}

?>
