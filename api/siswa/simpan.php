<?php
date_default_timezone_set('Asia/Jakarta');

error_reporting(0);
header('Access-Control-Allow-Origin: *');

require '../../config.php';

$post = json_decode(file_get_contents('php://input'), true);

$response = array();

//untuk mengambil tahun pelajaran
$queryTP = $mysqli->query("SELECT LEFT(tahun_pelajaran,4) as tahun_pelajaran FROM tahun_pelajaran WHERE aktif=1");
$tp = $queryTP-> fetch_assoc();

//membuat supaya tanggal lahir sebgai format date
$unregister_tgllahir = date_create($post['tgllahir']."-".$post['blnlahir']."-".$post['thnlahir']);
$tgllahir = date_format($unregister_tgllahir,"Y-m-d");

if($post['update'] == "true") {
  $type = "UPDATE";
  $where = "WHERE nis='".$post['nis']."'";
} else {
  $type = "INSERT INTO";
  $where = "";
}

//script untuk mengecek select apakah otomatis atau tidak
if(is_array($post['provinsi'])) {
  $provinsi = $post['provinsi']['provinsi'];
} else {
  $provinsi = $post['provinsi'];
}
if(is_array($post['kabupaten'])) {
  $kabupaten = $post['kabupaten']['kabupaten'];
} else {
  $kabupaten = $post['kabupaten'];
}
if(is_array($post['kecamatan'])) {
  $kecamatan = $post['kecamatan']['kecamatan'];
} else {
  $kecamatan = $post['kecamatan'];
}
if(is_array($post['desa'])) {
  $desa = $post['desa']['desa'];
} else {
  $desa = $post['desa'];
}

//query untuk nyimpen data
$sql = "
".$type."
siswa SET
nis           = '".$post['nis']."',
nisn          = '".$post['nisn']."',
nik           = '".$post['nik']."',
noun          = '".$post['noun']."',
nama          = '".addslashes(strtoupper($post['nama']))."',
aktif         = '1',
tahun_masuk   = '".$tp['tahun_pelajaran']."',
agama         = 'Islam',
status        = '".$post['status']."',
kelamin       = '".$post['kelamin']."',
tempat_lahir  = '".addslashes($post['tempat_lahir'])."',
tanggal_lahir = '".$tgllahir."',
warga         = '".$post['warga']."',
anakke        = '".$post['anakke']."',
status_anak   = '".$post['status_anak']."',
jsaudara      = '".$post['jsaudara']."',
jtiri         = '".$post['jtiri']."',

darah         = '".$post['darah']."',
berat         = '".$post['berat']."',
tinggi        = '".$post['tinggi']."',
kesehatan     = '".$post['kesehatan']."',

asal_sekolah  = '".addslashes($post['asal_sekolah'])."',
no_ijazah     = '".$post['no_ijazah']."',
tanggal_ijazah= '".$post['tanggal_ijazah']."',
no_skhun      = '".$post['no_skhun']."',
alamat_sekolah= '".addslashes($post['alamat_sekolah'])."',

nama_ayah           = '".addslashes($post['nama_ayah'])."',
status_ayah         = '".$post['status_ayah']."',
tempat_lahir_ayah   = '".$post['tempat_lahir_ayah']."',
tanggal_lahir_ayah  = '".$post['tanggal_lahir_ayah']."',
pendidikan_ayah     = '".$post['pendidikan_ayah']."',
pekerjaan_ayah      = '".$post['pekerjaan_ayah']."',
penghasilan_ayah    ='".$post['penghasilan_ayah']."',

nama_ibu          = '".addslashes($post['nama_ibu'])."',
status_ibu        = '".$post['status_ibu']."',
tempat_lahir_ibu  = '".$post['tempat_lahir_ibu']."',
tanggal_lahir_ibu = '".$post['tanggal_lahir_ibu']."',
pendidikan_ibu    = '".$post['pendidikan_ibu']."',
pekerjaan_ibu     = '".$post['pekerjaan_ibu']."',
penghasilan_ibu   = '".$post['penghasilan_ibu']."',

alamat        = '".addslashes($post['alamat'])."',
provinsi      = '".$provinsi."',
kabupaten     = '".$kabupaten."',
kecamatan     = '".$kecamatan."',
desa          = '".$desa."',
kodepos       = '".$post['kodepos']."',
jarak_sekolah = '".$post['jarak_sekolah']."',

handphone     = '".$post['handphone']."',
kontak        = '".$post['kontak']."',
email         = '".$post['email']."'

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
