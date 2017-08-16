<?php
include "../../config.php";
error_reporting(0);

$sql = "SELECT nis, nama, tempat_lahir, tanggal_lahir, kelamin, alamat, foto FROM siswa WHERE nis='".urlencode($_GET['nis'])."'";
$query  = $mysqli->prepare($sql);
$query->execute();
$result = $query->get_result();

$row = $result->fetch_assoc();

$namaexp = explode(' ', $row[nama]);

if($row['kelamin'] == 'L'){
	$kelamin = "Laki-laki";
} else {
	$kelamin = "Perempuan";
}
echo '
<script>
	window.print();
</script>

<style>
body {
    margin: auto;
    text-align: center;
    font-family: arial;
}
table {
  font-size: 0.9em;
}
.id-card {
    width: 325px;
    height: 208px;
    margin: 10px;
    background: url("../../assets/img/depan.jpg") center no-repeat;
    background-size: cover;
}

.id-card-back {
    width: 325px;
    height: 208px;
    margin: 10px;
    background: url("../../assets/img/belakang.jpg") center no-repeat;
    background-size: cover;
}


.wrap-text {
    position: absolute;
    width: 190px;
    text-align: left;
    margin: 85px 0 0 100px;
    font-size: 0.56em;
}

.line-text {
    float: right;
    margin-top: 174px;
    margin-right: 10px;
    font-size: 0.55em;
    letter-spacing: 2px;
}

.foto {
    float: left;
    margin-top: 75px;
    margin-left: 15px;
    width: 80px;
    height: 80px;
    border-radius: 100%;
}

.qrcode {
    float: right;
    margin-top: 60px;
    height: 50px;
    margin-right: 5px;
}

.barcode {
    float: right;
    margin-top: 164px;
    height: 30px;
    margin-right: 15px;
}
</style>

<div class="id-card">
    <img class="foto" src="../../assets/img/faces/'.$row['foto'].'.jpg">
    <div class="wrap-text">
        <table cellpadding="0" cellspacing="2">
        <tr>
            <td>NIS</td>
            <td>:</td>
            <td><strong>'.$row['nis'].'</strong></td>
        </tr>
        <tr>
            <td>NAMA</td>
            <td>:</td>
            <td><strong>'.strtoupper($namaexp[0]).' '.strtoupper($namaexp[1]).' '.strtoupper(substr($namaexp[2], 0, 1)).' '.strtoupper(substr($namaexp[3], 0, 1)).'</strong></td>
        </tr>
        <tr>
            <td>LAHIR</td>
            <td>:</td>
            <td>'.strtoupper($row['tempat_lahir']).', '.date_format(date_create($row['tanggal_lahir']),"d-m-Y").' </td>
        </tr>
        <tr>
            <td>KELAMIN</td>
            <td>:</td>
            <td>'.strtoupper($kelamin).'</td>
        </tr>
        <tr>
            <td valign="top">ALAMAT</td>
            <td valign="top">:</td>
            <td>'.strtoupper($row['alamat']).'</td>
        </tr>
        </table>
    </div>
    <img class="qrcode" src="../../assets/img/qrcode/'.$row['foto'].'.png">
</div>
';
?>
