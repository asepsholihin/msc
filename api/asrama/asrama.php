<?php

error_reporting(0);
header('Access-Control-Allow-Origin: *');

require "../../config.php";

$response = array();

$sql    ="SELECT a.id,a.asrama,b.nama,a.keterangan,a.aktif,(SELECT count(nis) FROM siswa WHERE id_asrama=a.id) as anggota FROM asrama a LEFT JOIN pegawai b ON a.nipwali=b.nip";
$query  = $mysqli->prepare($sql);
$query->execute();
$result = $query->get_result();

while( $row = $result->fetch_assoc() ) {
  $response[] = $row;

}

echo json_encode($response);
?>
