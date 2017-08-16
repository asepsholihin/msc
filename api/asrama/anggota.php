<?php
error_reporting(0);
header('Access-Control-Allow-Origin: *');

require "../../config.php";

$response = array();

$id    = $_GET['id'];

$sql    ="SELECT nis, nama FROM siswa WHERE id_asrama='".$id."'";
$query  = $mysqli->prepare($sql);
$query->execute();
$result = $query->get_result();

while( $row = $result->fetch_assoc() ) {
  $response['anggota'][] = $row;
}

$sql2    ="SELECT nis, nama FROM siswa WHERE id_asrama!='".$id."'";
$query2  = $mysqli->prepare($sql2);
$query2->execute();
$result2 = $query2->get_result();

while( $row2 = $result2->fetch_assoc() ) {
  $response['siswa'][] = $row2;
}

echo json_encode($response);
?>
