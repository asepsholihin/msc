<?php
error_reporting(0);
header('Access-Control-Allow-Origin: *');

require "../../config.php";

$response = array();

$start  = $_GET['start'];
$limit  = $_GET['limit'];

$sql    ="SELECT a.nis,a.nisn,a.nama,a.asal_sekolah,a.tempat_lahir,a.tanggal_lahir,b.kelas,c.tingkat,a.aktif,CASE WHEN a.aktif='1' THEN 'smile' ELSE 'sad' END AS icon FROM siswa a LEFT JOIN kelas b ON a.id_kelas=b.id LEFT JOIN tingkat c ON b.id_tingkat=c.id ORDER BY aktif DESC, nis LIMIT ".$start.", ".$limit."";
$query  = $mysqli->prepare($sql);
$query->execute();
$result = $query->get_result();

$querytotal  = $mysqli->query("SELECT count(nis) as total FROM siswa");
$resulttotal = $querytotal->fetch_assoc();

while( $row = $result->fetch_assoc() ) {
  $response['data'][] = $row;
  $response['total']  = $resulttotal['total'];
}
// $query = "SELECT a.nis as id, a.id_transaksi, a.jumlah, a.petugas, LEFT(a.ts,10) as tanggal, b.transaksi FROM log_transaksi a INNER JOIN transaksi b WHERE a.id_transaksi=b.id AND LEFT(a.ts, 10)='".date('Y-m-d')."'";
// $result = $mysqli->query($query);
// while( $row = $result-> fetch_assoc()) {
//   $response[] = $row;
// }
echo json_encode($response);
?>
