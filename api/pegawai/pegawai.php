<?php
error_reporting(0);
header('Access-Control-Allow-Origin: *');

require "../../config.php";

$response = array();

$start  = $_GET['start'];
$limit  = $_GET['limit'];

$sql    ="SELECT nip, nama, tempat_lahir, tanggal_lahir, bagian, gelar_awal, gelar_akhir, status, bpjs_kes, bpjs_ket,
CASE WHEN bpjs_kes='1' THEN 'check' ELSE 'close' END AS bpjs_kes_icon,
CASE WHEN bpjs_ket='1' THEN 'check' ELSE 'close' END AS bpjs_ket_icon,
aktif, CASE WHEN aktif='1' THEN 'smile' ELSE 'sad' END AS icon,
amanah, asal_sekolah FROM pegawai ORDER BY aktif DESC, nama LIMIT ".$start.", ".$limit."";
$query  = $mysqli->prepare($sql);
$query->execute();
$result = $query->get_result();

$querytotal  = $mysqli->query("SELECT count(nip) as total FROM pegawai");
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
