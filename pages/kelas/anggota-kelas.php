<?php
include "../../config.php";
error_reporting(0);
$no = 1;

$sql = "SELECT nis, nisn, nama, asal_sekolah, tempat_lahir, tanggal_lahir FROM siswa WHERE id_kelas='".urlencode($_GET['id'])."'";
$query  = $mysqli->prepare($sql);
$query->execute();
$result = $query->get_result();

while( $row = $result->fetch_assoc() ) {
    $show .= "
    <tr>
        <td align=center>".$no."</td>
        <td>".$row['nis']."</td>
        <td>".$row['nisn']."</td>
        <td>".$row['nama']."</td>
        <td>".$row['asal_sekolah']."</td>
        <td>".$row['tempat_lahir'].", ".$row['tanggal_lahir']."</td>
    </tr>
    ";
    $no++;
}


$sql2 = "SELECT a.kelas, b.tingkat, c.nama FROM kelas a JOIN tingkat b ON a.id_tingkat=b.id JOIN pegawai c ON a.nipwali=c.nip  WHERE a.id='".urlencode($_GET['id'])."'";
$query2  = $mysqli->prepare($sql2);
$query2->execute();
$result2 = $query2->get_result();

$row2 = $result2->fetch_assoc();


echo "
<script>
	window.print();
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
	margin: 10px 0;
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
table.table {
    font-size: 0.9em;
    width: 100%;
}
.table th {
    background: #ccc;
    padding: 10px;
    border-top: 1px solid #000;
    border-left: 1px solid #000;
    border-bottom: 1px solid #000;
}
.table th:last-child {
    border-right: 1px solid #000;
}
.table td {
    border-left: 1px solid #000;
    border-bottom: 1px solid #000;
    padding: 5px;
}
.table td:last-child {
    border-right: 1px solid #000;
}

.header td {
    padding: 10px 0;
}
</style>

<center>
	<table>
		<tr>
			<td valign='top'><img class='header' src='../../assets/img/logo-smp.png'></td>
			<td valign='top'>
				<h2>SMP AL-QUR'AN MA'RIFATUSSALAAM</h2>
				<p>Jl. Manyeti No. 6 RT/RW 05/01, Kp. Cikadu, Kec. Dawuan, Provinsi Jawa Barat - 41271</p>
				<p>Website: www.marifatussalaam.org | Email: smp@marifatussalaam.org</p>
			</td>
		</tr>
	</table>
</center>

<hr>

<table width=\"100%\" class=\"header\" cellpadding=\"0\" cellspacing=\"0\">
    <tr>
        <td>Kelas : <strong>".$row2['tingkat']." ".$row2['kelas']."</strong></td>
        <td align=right>Wali Kelas : <strong>".$row2['nama']."</strong></td>
    </tr>
</table>

<table class=\"table\" cellpadding=\"0\" cellspacing=\"0\">
    <tr>
        <th>No.</th>
        <th>NIS</th>
        <th>NISN</th>
        <th>Nama</th>
        <th>Asal Sekolah</th>
        <th>Tempat Tanggal Lahir</th>
    </tr>
    ".$show."
</table>
";
?>
