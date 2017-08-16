<?php
error_reporting(0);
header('Access-Control-Allow-Origin: *');

require "../../config.php";

$response = array();

$nip    = $_GET['nip'];

$sql    ="SELECT *, LEFT(tanggal_lahir,4) AS thnlahir, RIGHT(tanggal_lahir,2) AS tgllahir, SUBSTRING(tanggal_lahir,6,2) AS blnlahir FROM pegawai WHERE nip='".$nip."'";
$query  = $mysqli->prepare($sql);
$query->execute();
$result = $query->get_result();

$response = $result->fetch_assoc();
// $query = "SELECT a.nis as id, a.id_transaksi, a.jumlah, a.petugas, LEFT(a.ts,10) as tanggal, b.transaksi FROM log_transaksi a INNER JOIN transaksi b WHERE a.id_transaksi=b.id AND LEFT(a.ts, 10)='".date('Y-m-d')."'";
// $result = $mysqli->query($query);
// while( $row = $result-> fetch_assoc()) {
//   $response[] = $row;
// }
echo json_encode($response);
?>
