<?php

$filename ="data-pegawai.xls";
header('Content-type: application/ms-excel');
header('Content-Disposition: attachment; filename='.$filename);

include('../../config.php');

$sql = "SELECT *,
CASE WHEN bpjs_kes=1 THEN 'Terdaftar' ELSE 'Tidak Terdaftar' END as bpjs_kes,
CASE WHEN bpjs_ket=1 THEN 'Terdaftar' ELSE 'Tidak Terdaftar' END as bpjs_ket
FROM pegawai";
$query = $mysqli->prepare($sql);
$query->execute();
$result = $query->get_result();

while($row = $result->fetch_assoc()) {
    $show .="
    <tr>
        <td>".$row['nip']."</td>
        <td>".$row['bagian']."</td>
        <td>".$row['nik']."</td>
        <td>".$row['nama']."</td>
        <td>".$row['kelamin']."</td>
        <td>".$row['tempat_lahir']."</td>
        <td>".$row['tanggal_lahir']."</td>
        <td>".$row['alamat']."</td>
        <td>".$row['handphone']."</td>
        <td>".$row['email']."</td>
        <td>".$row['nikah']."</td>
        <td>".$row['asal_sekolah']."</td>
        <td>".$row['pendidikan']."</td>
        <td>".$row['gelar_awal']."</td>
        <td>".$row['gelar_akhir']."</td>
        <td>".$row['mulai_kerja']."</td>
        <td>".$row['amanah']."</td>
        <td>".$row['status']."</td>
        <td>".$row['nosk']."</td>
        <td>".$row['bpjs_kes']."</td>
        <td>".$row['bpjs_ket']."</td>
        <td>".$row['hobi']."</td>
    </tr>
    ";
}
?>

<style media="screen">
    th {
        background: #a2f17b;
    }
</style>

<table border>
    <tr>
        <th>NIP</th>
        <th>Bagian</th>
        <th>NIK</th>
        <th>Nama</th>
        <th>Kelamin</th>
        <th>Tempat Lahir</th>
        <th>Tanggal Lahir</th>
        <th>Alamat</th>
        <th>Handphone</th>
        <th>Email</th>
        <th>Nikah</th>
        <th>Asal Sekolah</th>
        <th>Pendidikan</th>
        <th>Gelar Awal</th>
        <th>Gelar Akhir</th>
        <th>Muali Kerja</th>
        <th>Amanah</th>
        <th>Status</th>
        <th>No. SK</th>
        <th>BPJS Kesehatan</th>
        <th>BPJS Ketenagakerjaan</th>
        <th>Hobi</th>
    </tr>
    <?php echo $show; ?>
</table>
