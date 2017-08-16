<?php
include "../../config.php";
error_reporting(0);

$sql = "SELECT * FROM pegawai WHERE nip='".urlencode($_GET['nip'])."'";
$query  = $mysqli->prepare($sql);
$query->execute();
$result = $query->get_result();

$row = $result->fetch_assoc();

if($row['kelamin'] == 'L'){
	$kelamin = "Laki-laki";
} else {
	$kelamin = "Perempuan";
}


if($row['bpjs_kes'] == '1'){
	$bpjs_kes = "Terdaftar";
} else {
	$bpjs_kes = "Tidak Terdaftar";
}


if($row['bpjs_ket'] == '1'){
	$bpjs_ket = "Terdaftar";
} else {
	$bpjs_ket = "Tidak Terdaftar";
}

echo "
<script>
	//window.print();
</script>

<style>
body {
		margin: 8% 5%;
    font-family: arial;
    font-size: 0.8em;
		background: url('../../assets/img/bg.png') no-repeat;
		background-position: center;
		background-size: cover;
}
hr {
	margin: 20px 0;
	border: 1px solid #555;
}
h2,p {
	margin: 5px;
}
p {
	font-size: 12px;
}
img.header {
	margin: 0 20px;
	width: 80px;
}
img.profil {
	margin: 0 20px 0 0;
	width: 120px;
}
</style>

<center>
	<table>
		<tr>
			<td valign='top'><img class='header' src='../../assets/img/logo-smp.png'></td>
			<td valign='top'>
				<h2>YAYASAN MA'RIFATUSSALAAM</h2>
				<p>Jl. Manyeti No. 6 RT/RW 05/01, Kp. Cikadu, Kec. Dawuan, Provinsi Jawa Barat - 41271</p>
				<p>Website: www.marifatussalaam.org | Email: yayasan@marifatussalaam.org</p>
			</td>
		</tr>
	</table>
</center>

<hr>
<table>
	<tr>
		<td valign='top'>
			<img class='profil' src='../../assets/img/faces/".$row['foto'].".jpg'>
		</td>
		<td valign='top'>
			<table>
				<tr>
					<td valign='top'>Bagian</td>
					<td valign='top'>:</td>
					<td valign='top'><strong>".ucwords($row['bagian'])."</strong></td>
				</tr>
				<tr>
					<td valign='top'>NIP</td>
					<td valign='top'>:</td>
					<td valign='top'><strong>".$row['nip']."</strong></td>
				</tr>
				<tr>
					<td valign=\"top\">Nama</td>
					<td valign=\"top\">:</td>
					<td valign='top'><strong>".ucwords(strtolower($row['nama']))."</strong></td>
				</tr>
				<tr>
					<td valign=\"top\">Posisi</td>
					<td valign=\"top\">:</td>
					<td valign='top'><strong>".$row['amanah']."</strong></td>
				</tr>
				<tr>
					<td valign=\"top\">Masa Kerja</td>
					<td valign=\"top\">:</td>
					<td valign='top'><strong>".$row['status']."</strong></td>
				</tr>
			</table>
		</td>
	</tr>
</table>

<hr>

<table>
	<tr>
		<td valign='top'>NIK</td>
		<td valign='top'>:</td>
		<td valign='top'><strong>".$row['nik']."</strong></td>
	</tr>
	<tr>
		<td valign='top'>Tempat Lahir</td>
		<td valign='top'>:</td>
		<td valign='top'><strong>".$row['tempat_lahir']."</strong></td>
	</tr>
	<tr>
		<td valign='top'>Tanggal Lahir</td>
		<td valign='top'>:</td>
		<td valign='top'><strong>".date_format(date_create($row['tanggal_lahir']),"d-m-Y")."</strong></td>
	</tr>
	<tr>
		<td valign='top'>Kelamin</td>
		<td valign='top'>:</td>
		<td valign='top'><strong>".$kelamin."</strong></td>
	</tr>
	<tr>
		<td valign='top'>Menikah</td>
		<td valign='top'>:</td>
		<td valign='top'><strong>".ucwords($row['nikah'])."</strong></td>
	</tr>
	<tr>
		<td valign='top'>Alamat</td>
		<td valign='top'>:</td>
		<td valign='top'><strong>".$row['alamat']."</strong></td>
	</tr>
	<tr>
		<td valign='top'>Handphone</td>
		<td valign='top'>:</td>
		<td valign='top'><strong>".$row['handphone']."</strong></td>
	</tr>
	<tr>
		<td valign='top'>Email</td>
		<td valign='top'>:</td>
		<td valign='top'><strong>".$row['email']."</strong></td>
	</tr>
</table>

<hr>

<table>
	<tr>
		<td valign='top'>Asal Sekolah</td>
		<td valign='top'>:</td>
		<td valign='top'><strong>".$row['asal_sekolah']."</strong></td>
	</tr>
	<tr>
		<td valign='top'>Pendidikan</td>
		<td valign='top'>:</td>
		<td valign='top'><strong>".$row['pendidikan']."</strong></td>
	</tr>
	<tr>
		<td valign='top'>Gelar Awal</td>
		<td valign='top'>:</td>
		<td valign='top'><strong>".$row['gelar_awal']."</strong></td>
	</tr>
	<tr>
		<td valign='top'>Gelar Akhir</td>
		<td valign='top'>:</td>
		<td valign='top'><strong>".$row['gelar_akhir']."</strong></td>
	</tr>
	<tr>
		<td valign='top'>Mulai Bekerja</td>
		<td valign='top'>:</td>
		<td valign='top'><strong>".date_format(date_create($row['mulai_kerja']),"d-m-Y")."</strong></td>
	</tr>
	<tr>
		<td valign='top'>No. SK</td>
		<td valign='top'>:</td>
		<td valign='top'><strong>".$row['nosk']."</strong></td>
	</tr>
	<tr>
		<td valign='top'>BPJS Kesehatan</td>
		<td valign='top'>:</td>
		<td valign='top'><strong>".$bpjs_kes."</strong></td>
	</tr>
	<tr>
		<td valign='top'>BPJS Ketenagakerjaan</td>
		<td valign='top'>:</td>
		<td valign='top'><strong>".$bpjs_ket."</strong></td>
	</tr>
	<tr>
		<td valign='top'>Hobi</td>
		<td valign='top'>:</td>
		<td valign='top'><strong>".$row['hobi']."</strong></td>
	</tr>
</table>

";
?>
