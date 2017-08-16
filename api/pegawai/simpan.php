<?php
date_default_timezone_set('Asia/Jakarta');

error_reporting(0);
header('Access-Control-Allow-Origin: *');

require '../../config.php';

$post = json_decode(file_get_contents('php://input'), true);

$response = array();

//membuat supaya tanggal lahir sebgai format date
$unregister_tgllahir = date_create($post['tgllahir']."-".$post['blnlahir']."-".$post['thnlahir']);
$tgllahir = date_format($unregister_tgllahir,"Y-m-d");

if($post['update'] == "true") {
  $type = "UPDATE";
  $where = "WHERE nip='".$post['nip']."'";
} else {
  $type = "INSERT INTO";
  $where = "";
}

//query untuk nyimpen data
$sql = "
".$type." pegawai SET

bagian        = '".$post['bagian']."',
nip           = '".$post['nip']."',
nik           = '".$post['nik']."',
noid          = '".$post['noid']."',
nosk          = '".$post['nosk']."',
status        = '".$post['status']."',
amanah        = '".$post['amanah']."',

nama          = '".addslashes(strtoupper($post['nama']))."',
kelamin       = '".$post['kelamin']."',
tempat_lahir  = '".addslashes($post['tempat_lahir'])."',
tanggal_lahir = '".$tgllahir."',
asal_sekolah  = '".$post['asal_sekolah']."',
pendidikan    = '".$post['pendidikan']."',
gelar_awal    = '".$post['gelar_awal']."',
gelar_akhir   = '".$post['gelar_akhir']."',

alamat        = '".addslashes($post['alamat'])."',

handphone     = '".$post['handphone']."',
email         = '".$post['email']."',
nikah         = '".$post['nikah']."',
mulai_kerja   = '".$post['mulai_kerja']."',
bpjs_kes      = '".$post['bpjs_kes']."',
bpjs_ket      = '".$post['bpjs_ket']."',
hobi          = '".$post['hobi']."'

".$where."

";
$query = $mysqli->query($sql);
if($query) {
  $response['success'] = 1;
  $response['message'] = "Datanya udah tersimpan!";
} else {
  $response['success'] = 0;
  $response['message'] = "Sepertinya ada yang error!";
  //$response['message'] = $sql;
}

echo json_encode($response);

?>
