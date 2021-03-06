<?php
date_default_timezone_set('Asia/Jakarta');

error_reporting(0);
header('Access-Control-Allow-Origin: *');

require "../../config.php";

$response = array();
$date = date('Y-m-d');

$sql ="SELECT a.id_referensi as id, a.nis, c.nama ,a.id_transaksi, a.jumlah, a.petugas, a.tanggal, SUM(jumlah) as total, (CASE WHEN a.transfer=1 THEN 'Transfer' ELSE 'Tunai' END) AS transfer FROM log_transaksi a JOIN transaksi b JOIN siswa c ON a.nis=c.nis WHERE a.id_transaksi=b.id AND LEFT(a.ts, 10)='".$date."' GROUP BY id ORDER BY id DESC LIMIT 10";
$query = $mysqli->prepare($sql);
$query->execute();
$result = $query->get_result();

while( $row = $result->fetch_assoc() ) {
  $response[] = $row;
}
// $query = "SELECT a.nis as id, a.id_transaksi, a.jumlah, a.petugas, LEFT(a.ts,10) as tanggal, b.transaksi FROM log_transaksi a INNER JOIN transaksi b WHERE a.id_transaksi=b.id AND LEFT(a.ts, 10)='".date('Y-m-d')."'";
// $result = $mysqli->query($query);
// while( $row = $result-> fetch_assoc()) {
//   $response[] = $row;
// }
echo json_encode($response);
?>
