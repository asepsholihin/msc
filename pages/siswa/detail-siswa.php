<?php
include "../../config.php";
error_reporting(0);

$sql = "SELECT a.*, tingkat ,kelas, asrama FROM siswa a JOIN kelas b ON a.id_kelas=b.id LEFT JOIN asrama c ON a.id_asrama=c.id JOIN tingkat d ON b.id_tingkat=d.id WHERE nis='".urlencode($_GET['nis'])."'";
$query  = $mysqli->prepare($sql);
$query->execute();
$result = $query->get_result();

$row = $result->fetch_assoc();

$qtahunpelajaran = $mysqli->query("SELECT tahun_pelajaran FROM tahun_pelajaran WHERE aktif=1");
$tahunpelajaran = $qtahunpelajaran->fetch_assoc();

if($row['kelamin'] == 'L'){
	$kelamin = "Laki-laki";
} else {
	$kelamin = "Perempuan";
}
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
				<h2>SMP AL-QUR'AN MA'RIFATUSSALAAM</h2>
				<p>Jl. Manyeti No. 6 RT/RW 05/01, Kp. Cikadu, Kec. Dawuan, Provinsi Jawa Barat - 41271</p>
				<p>Website: www.marifatussalaam.org | Email: smp@marifatussalaam.org</p>
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
			<table >
				<tr>
					<td valign='top'>Tahun Ajaran</td>
					<td valign='top'>:</td>
					<td valign='top'><strong>".$tahunpelajaran['tahun_pelajaran']."</strong></td>
				</tr>
				<tr>
					<td valign='top'>Kelas</td>
					<td valign='top'>:</td>
					<td valign='top'><strong>".$row['tingkat']." - ".$row['kelas']."</strong></td>
				</tr>
				<tr>
					<td valign='top'>Asrama</td>
					<td valign='top'>:</td>
					<td valign='top'><strong>".$row['asrama']."</strong></td>
				</tr>
				<tr>
					<td valign='top'>NIS</td>
					<td valign='top'>:</td>
					<td valign='top'><strong>".$row['nis']."</strong></td>
				</tr>
				<tr>
					<td valign=\"top\">Nama</td>
					<td valign=\"top\">:</td>
					<td valign='top'><strong>".$row['nama']."</strong></td>
				</tr>
			</table>
		</td>
	</tr>
</table>

<hr>
<table  width='100%' >
	<tr>
		<td width='50%'>
			<table>
				<tr>
					<td valign='top'>NISN</td>
					<td valign='top'>:</td>
					<td valign='top'><strong>".$row['nisn']."</strong></td>
				</tr>
				<tr>
					<td valign='top'>NIK</td>
					<td valign='top'>:</td>
					<td valign='top'><strong>".$row['nik']."</strong></td>
				</tr>
				<tr>
					<td valign='top'>Nomor UN</td>
					<td valign='top'>:</td>
					<td valign='top'><strong>".$row['noun']."</strong></td>
				</tr>
				<tr>
					<td valign='top'>Kelamin</td>
					<td valign='top'>:</td>
					<td valign='top'><strong>".$kelamin."</strong></td>
				</tr>
				<tr>
					<td valign='top'>Tempat Lahir</td>
					<td valign='top'>:</td>
					<td valign='top'><strong>".$row['tempat_lahir']."</strong></td>
				</tr>
				<tr>
					<td valign='top'>Tanggal Lahir</td>
					<td valign='top'>:</td>
					<td valign='top'><strong>".$row['tanggal_lahir']."</strong></td>
				</tr>
				<tr>
					<td valign='top'>Agama</td>
					<td valign='top'>:</td>
					<td valign='top'><strong>".$row['agama']."</strong></td>
				</tr>
				<tr>
					<td valign='top'>Status</td>
					<td valign='top'>:</td>
					<td valign='top'><strong>".$row['status']."</strong></td>
				</tr>
			</table>

		</td>

		<td width='50%'>
			<table >
				<tr>
					<td valign='top'>Kewarganegaraan</td>
					<td valign='top'>:</td>
					<td valign='top'><strong>".$row['warga']."</strong></td>
				</tr>
				<tr>
					<td valign='top'>Anak Ke</td>
					<td valign='top'>:</td>
					<td valign='top'><strong>".$row['anakke']."</strong></td>
				</tr>
				<tr>
					<td valign='top'>Jumlah Saudara Kandung</td>
					<td valign='top'>:</td>
					<td valign='top'><strong>".$row['jsaudara']."</strong></td>
				</tr>
				<tr>
					<td valign='top'>Jumlah Saudara Tiri</td>
					<td valign='top'>:</td>
					<td valign='top'><strong>".$row['jtiri']."</strong></td>
				</tr>
				<tr>
					<td valign='top'>Status Anak</td>
					<td valign='top'>:</td>
					<td valign='top'><strong>".$row['status_anak']."</strong></td>
				</tr>
				<tr>
					<td valign='top'>Golongan Darah</td>
					<td valign='top'>:</td>
					<td valign='top'><strong>".$row['darah']."</strong></td>
				</tr>
				<tr>
					<td valign='top'>Berat Badan</td>
					<td valign='top'>:</td>
					<td valign='top'><strong>".$row['berat']." Kg</strong></td>
				</tr>
				<tr>
					<td valign='top'>Tinggi Badan</td>
					<td valign='top'>:</td>
					<td valign='top'><strong>".$row['tinggi']." Cm</strong></td>
				</tr>
				<tr>
					<td valign='top'>Riwayat Penyakit</td>
					<td valign='top'>:</td>
					<td valign='top'><strong>".$row['kesehatan']."</strong></td>
				</tr>
			</table>
		</td>
	</tr>
</table>

<hr>

<table  width='100%' >
	<tr>
		<td width='50%'>
			<table>
				<tr>
						<td valign=\"top\">Alamat</td>
						<td valign=\"top\">:</td>
						<td valign='top'><strong>".$row['alamat']."</strong></td>
				</tr>

				<tr>
						<td valign='top'>Desa</td>
						<td valign='top'>:</td>
						<td valign='top'><strong>".$row['desa']."</strong></td>
				</tr>
				<tr>
						<td valign='top'>Kecamatan</td>
						<td valign='top'>:</td>
						<td valign='top'><strong>".$row['kecamatan']."</strong></td>
				</tr>
				<tr>
						<td valign='top'>Kabupaten</td>
						<td valign='top'>:</td>
						<td valign='top'><strong>".$row['kabupaten']."</strong></td>
				</tr>
				<tr>
						<td valign='top'>Provinsi</td>
						<td valign='top'>:</td>
						<td valign='top'><strong>".$row['provinsi']."</strong></td>
				</tr>
				<tr>
						<td valign='top'>Kode Pos</td>
						<td valign='top'>:</td>
						<td valign='top'><strong>".$row['kodepos']."</strong></td>
				</tr>
				<tr>
						<td valign=\"top\">Jarak Ke Sekolah</td>
						<td valign=\"top\">:</td>
						<td valign=\"top\"><strong>".$row['jarak_sekolah']." Km</strong></td>
				</tr>
			</table>

		</td>

		<td width='50%'>
			<table >
				<tr>
						<td valign='top'>Telepon</td>
						<td valign='top'>:</td>
						<td valign='top'><strong>".$row['kontak']."</strong></td>
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
				<tr>
						<td valign='top'>Asal Sekolah</td>
						<td valign='top'>:</td>
						<td valign='top'><strong>".$row['asal_sekolah']."</strong></td>
				</tr>
				<tr>
						<td valign='top'>No. Seri Ijazah</td>
						<td valign='top'>:</td>
						<td valign='top'><strong>".$row['no_ijazah']."</strong></td>
				</tr>
				<tr>
						<td valign='top'>No. Seri SKHUN</td>
						<td valign='top'>:</td>
						<td valign='top'><strong>".$row['no_skhun']."</strong></td>
				</tr>
				<tr>
						<td valign='top'>Tanggal Ijazah</td>
						<td valign='top'>:</td>
						<td valign='top'><strong>".$row['tanggal_ijazah']."</strong></td>
				</tr>
				<tr>
						<td valign='top'>Alamat Sekolah</td>
						<td valign='top'>:</td>
						<td valign='top'><strong>".$row['alamat_sekolah']."</strong></td>
				</tr>
			</table>
		</td>
	</tr>
</table>

<hr>

<table width='100%'>
<tr>
	<td width='50%'>
	<table>
	    <tr>
	        <td valign='top'>Nama Ayah</td>
	        <td valign='top'>:</td>
	        <td valign='top'><strong>".$row['nama_ayah']."</strong></td>
	    </tr>
	    <tr>
	        <td valign='top'>Status Ayah</td>
	        <td valign='top'>:</td>
	        <td valign='top'><strong>".$row['status_ayah']."</strong></td>
	    </tr>
	    <tr>
	        <td valign='top'>Tempat Lahir</td>
	        <td valign='top'>:</td>
	        <td valign='top'><strong>".$row['tempat_lahir_ayah']."</strong></td>
	    </tr>
	    <tr>
	        <td valign='top'>Tanggal Lahir</td>
	        <td valign='top'>:</td>
	        <td valign='top'><strong>".$row['tanggal_lahir_ayah']."</strong></td>
	    </tr>
	    <tr>
	        <td valign='top'>Pendidikan Ayah</td>
	        <td valign='top'>:</td>
	        <td valign='top'><strong>".$row['pendidikan_ayah']."</strong></td>
	    </tr>
	    <tr>
	        <td valign='top'>Pekerjaan Ayah</td>
	        <td valign='top'>:</td>
	        <td valign='top'><strong>".$row['pekerjaan_ayah']."</strong></td>
	    </tr>
	    <tr>
	        <td valign='top'>Penghasilan Ayah</td>
	        <td valign='top'>:</td>
	        <td valign='top'><strong>".$row['penghasilan_ayah']."</strong></td>
	    </tr>
	</table>
	</td>
	<td width='50%'>
		<table>
		    <tr>
		        <td valign='top'>Nama Ibu</td>
		        <td valign='top'>:</td>
		        <td valign='top'><strong>".$row['nama_ibu']."</strong></td>
		    </tr>
		    <tr>
		        <td valign='top'>Status Ibu</td>
		        <td valign='top'>:</td>
		        <td valign='top'><strong>".$row['status_ibu']."</strong></td>
		    </tr>
		    <tr>
		        <td valign='top'>Tempat Lahir</td>
		        <td valign='top'>:</td>
		        <td valign='top'><strong>".$row['tempat_lahir_ibu']."</strong></td>
		    </tr>
		    <tr>
		        <td valign='top'>Tanggal Lahir</td>
		        <td valign='top'>:</td>
		        <td valign='top'><strong>".$row['tempat_lahir_ibu']."</strong></td>
		    </tr>
		    <tr>
		        <td valign='top'>Pendidikan Ibu</strong></td>
		        <td valign='top'>:</td>
		        <td valign='top'><strong>".$row['pendidikan_ibu']."</strong></td>
		    </tr>
		    <tr>
		        <td valign='top'>Pekerjaan Ibu</td>
		        <td valign='top'>:</td>
		        <td valign='top'><strong>".$row['pekerjaan_ibu']."</strong></td>
		    </tr>
		    <tr>
		        <td valign='top'>Penghasilan Ibu</td>
		        <td valign='top'>:</td>
		        <td valign='top'><strong>".$row['penghasilan_ibu']."</strong></td>
		    </tr>
		</table>
	</td>
</tr>
</table>
";
?>
