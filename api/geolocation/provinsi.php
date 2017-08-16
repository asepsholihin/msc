<?php

error_reporting(0);
header('Access-Control-Allow-Origin: *');

require "../../config.php";

$response = array();

$sql    ="SELECT id,provinsi FROM provinsi";
$query  = $mysqli->prepare($sql);
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
