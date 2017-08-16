<?php
date_default_timezone_set('Asia/Jakarta');

error_reporting(0);
header('Access-Control-Allow-Origin: *');

require '../../config.php';

$post = json_decode(file_get_contents('php://input'), true);

$response = array();

if($post['type'] == "masuk") {
  $id_asrama = $post['id'];
} else {
  $id_asrama = '';
}

$sql = "UPDATE siswa SET id_asrama='".$id_asrama."' WHERE nis='".$post['nis']."'";

$query = $mysqli->query($sql);
if($query) {
  $response['success'] = 1;
  $response['message'] = "Datanya udah tersimpan!";
} else {
  $response['success'] = 0;
  $response['message'] = "Sepertinya ada yang error!";
}

echo json_encode($response);

?>
