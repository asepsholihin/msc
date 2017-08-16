<?php

error_reporting(0);
header('Access-Control-Allow-Origin: *');

require "../../config.php";

$response = array();

$queryaktif = $mysqli->query("SELECT aktif, CASE WHEN aktif='1' THEN 'smile' ELSE 'sad' END AS icon FROM pegawai WHERE nip='".$_GET['nip']."'");
$aktif = $queryaktif->fetch_row();

if($aktif[0] == 1) {
    $sql = "UPDATE pegawai SET aktif=0 WHERE nip='".$_GET['nip']."'";
} else {
    $sql = "UPDATE pegawai SET aktif=1 WHERE nip='".$_GET['nip']."'";
}

$query = $mysqli->query($sql);

if($query) {
    $queryaktif = $mysqli->query("SELECT aktif, CASE WHEN aktif='1' THEN 'smile' ELSE 'sad' END AS icon FROM pegawai WHERE nip='".$_GET['nip']."'");
    $aktif = $queryaktif->fetch_row();

    $response['success'] = 1;
    $response['aktif'] = $aktif[0];
    $response['icon'] = $aktif[1];
} else {
    $response['success'] = 0;
}

echo json_encode($response);

?>
