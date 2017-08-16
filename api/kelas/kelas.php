<?php

error_reporting(0);
header('Access-Control-Allow-Origin: *');

require "../../config.php";

$response = array();

$sql    ="SELECT a.id ,a.kelas, c.nama as wali_kelas, a.aktif, b.tingkat, (SELECT count(nis) FROM siswa WHERE id_kelas=a.id) as anggota FROM kelas a JOIN tingkat b ON a.id_tingkat=b.id JOIN pegawai c ON a.nipwali=c.nip";
$query  = $mysqli->prepare($sql);
$query->execute();
$result = $query->get_result();

while( $row = $result->fetch_assoc() ) {
  $response[] = $row;
}


echo json_encode($response);
?>
