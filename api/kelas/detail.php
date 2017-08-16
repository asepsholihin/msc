<?php
error_reporting(0);
header('Access-Control-Allow-Origin: *');

require "../../config.php";

$response = array();

$id    = $_GET['id'];

$sql    ="SELECT a.id, a.kelas, a.nipwali, a.keterangan, a.id_tingkat, b.tingkat FROM kelas a JOIN tingkat b ON a.id_tingkat=b.id WHERE a.id='".$id."'";
$query  = $mysqli->prepare($sql);
$query->execute();
$result = $query->get_result();

$response = $result->fetch_assoc();
echo json_encode($response);
?>
