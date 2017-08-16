<?php
date_default_timezone_set('Asia/Jakarta');

error_reporting(0);
header('Access-Control-Allow-Origin: *');

require '../../config.php';

$post = json_decode(file_get_contents('php://input'), true);

$response = array();

if($post['update'] == "true") {
  $type = "UPDATE";
  $where = "WHERE id='".$post['id']."'";
} else {
  $type = "INSERT INTO";
  $where = "";
}

//script untuk mengecek select apakah otomatis atau tidak
if(is_array($post['id_pelajaran'])) {
  $id_pelajaran = $post['id_pelajaran']['id'];
} else {
  $id_pelajaran = $post['id_pelajaran'];
}

$sql = "
".$type."
guru SET
nip           = '".$post['nip']."',
id_pelajaran  = '".$id_pelajaran."',
status_guru   = '".$post['status_guru']."',
keterangan   = '".$post['keterangan']."'
".$where."
";

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
