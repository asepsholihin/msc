<?php
date_default_timezone_set('Asia/Jakarta');

error_reporting(0);
header('Access-Control-Allow-Origin: *');

require '../../config.php';

$posts = json_decode(file_get_contents('php://input'), true);

$response = array();
$date = date('Y-m-d');

// membuat no referensi
$result = $mysqli->query("SELECT substring(id_referensi,5,7) as id FROM log_transaksi ORDER BY id_referensi DESC LIMIT 1");
$row = $result-> fetch_assoc();
// menambah nilai id
$upid = $row['id'] + 1;
$lastid = date('Y').sprintf('%06s', $upid);


//
foreach ($posts as $key) {
  if(is_array($key)) {

    foreach ($key as $key2 => $value) {
      if(is_array($value)) {

        //cek value spp kalo gak kosong, eksekusi!
        if($value['sppjumlah'] != "") {
          $query = "INSERT INTO log_transaksi (id_referensi,nis,id_transaksi,catatan,jumlah,transfer,petugas,tanggal) VALUES ('".$lastid."','".$posts['nis']."','70','".$value['sppbulan']." ".$value['spptahun']."','".str_replace(',','',$value['sppjumlah'])."','".$posts['transfer']."','".$posts['petugas']."','".$posts['tanggal']."');";
          $mysqli->query($query);

          $result = $mysqli->query("SELECT nis FROM log_spp WHERE nis='".$posts['nis']."' AND tahun='".$value['spptahun']."'");
          if($result->num_rows > 0) {
            $query = "UPDATE log_spp SET ".$value['sppbulan']."='1', tahun='".$value['spptahun']."' WHERE nis='".$posts['nis']."'";
            $mysqli->query($query);
          } else {
            $query = "INSERT INTO log_spp (nis,".$value['sppbulan'].", tahun) VALUES ('".$posts['nis']."','1','".$value['spptahun']."')";
            $mysqli->query($query);
          }

          // $row = array(
          //   'id'        => ''.$posts['nis'].'',
          //   'nama'      => ''.$posts['nama'].'',
          //   'transaksi' => 'Iuran Bulanan/SPP',
          //   'jumlah'    => ''.$value['sppjumlah'].'',
          //   'tanggal'   => ''.date("d-m-Y").''
          // );
          // array_push($response, $row);
        }

      } else {

        //Definis supaya form diganti jadi no referensi
        switch ($key2) {
          case 'psp':
            $key2 = "71";
            $transaksi = "Pengembangan Sarana & Prasarana";
            break;
          case 'sdm':
            $key2 = "72";
            $transaksi = "Pengembangan SDM";
            break;
          case 'kegiatantahunan':
            $key2 = "73";
            $transaksi = "Kegiatan Tahunan";
            break;
          case 'seragam':
            $key2 = "74";
            $transaksi = "Seragam";
            break;
          case 'buku':
            $key2 = "75";
            $transaksi = "Buku Paket & Modul";
            break;
          case 'orientasi':
            $key2 = "76";
            $transaksi = "Pekan Ta'aruf (Orientasi)";
            break;
          case 'komitmenbulanan':
            $key2 = "77";
            $transaksi = "Komitmen Bulanan";
            break;
          case 'komitmentahunan':
            $key2 = "78";
            $transaksi = "Komitmen Tahunan";
            break;
          case 'uangsaku':
            $key2 = "79";
            $transaksi = "Uang Saku";
            break;
          case 'kaskomite':
            $key2 = "80";
            $transaksi = "Kas Komite";
            break;
          case 'infaq':
            $key2 = "81";
            $transaksi = "Infaq";
            break;
          case 'qurban':
            $key2 = "82";
            $transaksi = "Qurban";
            break;

          default:
            # code...
            break;
        }

        $query = "INSERT INTO log_transaksi (id_referensi,nis,id_transaksi,jumlah,transfer,petugas,tanggal) VALUES ('".$lastid."','".$posts['nis']."','$key2','".str_replace(',','',$value)."','".$posts['transfer']."','".$posts['petugas']."','".$posts['tanggal']."')";
        if($value != '') {
          $mysqli->query($query);
        }

        // $row = array(
        //   'id'        => ''.$posts['nis'].'',
        //   'nama'      => ''.$posts['nama'].'',
        //   'transaksi' => ''.$transaksi.'',
        //   'jumlah'    => ''.$value.'',
        //   'tanggal'   => ''.date("d-m-Y").''
        // );
        // array_push($response, $row);

      }
    }
  }
}

$sql ="SELECT a.id_referensi as id, a.nis, c.nama ,a.id_transaksi, a.jumlah, a.petugas, LEFT(a.ts,10) as tanggal, b.transaksi, SUM(jumlah) as total FROM log_transaksi a JOIN transaksi b JOIN siswa c ON a.nis=c.nis WHERE a.id_transaksi=b.id AND LEFT(a.ts, 10)='".$date."' GROUP BY id ORDER BY id DESC LIMIT 10";
$query = $mysqli->prepare($sql);
$query->execute();
$result = $query->get_result();

while( $row = $result->fetch_assoc() ) {
  $response[] = $row;
}
echo json_encode($response);

?>
