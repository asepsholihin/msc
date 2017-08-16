<?php
error_reporting(0);
header('Access-Control-Allow-Origin: *');

require "../../config.php";

$response = array();

$id    = $_GET['id'];

$sql    ="SELECT a.id, a.nip, b.nama, a.id_pelajaran, c.pelajaran, a.status_guru FROM guru a JOIN pegawai b ON a.nip=b.nip JOIN pelajaran c ON a.id_pelajaran=c.id WHERE a.id='".$id."'";
$query  = $mysqli->prepare($sql);
$query->execute();
$result = $query->get_result();

$response = $result->fetch_assoc();
echo json_encode($response);
?>
