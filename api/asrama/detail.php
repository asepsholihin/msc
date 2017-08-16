<?php
error_reporting(0);
header('Access-Control-Allow-Origin: *');

require "../../config.php";

$response = array();

$id    = $_GET['id'];

$sql    ="SELECT id,nipwali,asrama,keterangan FROM asrama WHERE id='".$id."'";
$query  = $mysqli->prepare($sql);
$query->execute();
$result = $query->get_result();

$response = $result->fetch_assoc();
echo json_encode($response);
?>
