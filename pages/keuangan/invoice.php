<style>
body {
    font-family: sans-serif;
}
.wrapper{
    position: absolute;
    width: 548px;
    height: 775px;
    background: url(../../assets/img/bg.png) no-repeat;
    background-size: cover;
}
.caption {
    position: absolute;
    top: 30px;
    right: 10px;
}
.invoice {
    letter-spacing: 3px;
    font-size: 2em;
    font-weight: bold;
}
.invoice-for table td {
    font-size: 0.8em !important;
}
.logo img {
    position: absolute;
    top: 50px;
    left: 50px;
    width: 105px;
}
.content {
    position: absolute;
    top: 170px;
    width: 100%;
}
.content table {
    font-size: 0.8em;
    width: 100%;
}
.content table th {
    padding: 8px 10px;
    background: #8784b1;
    color: #fff;
    text-transform: uppercase;
    font-weight: normal;
}
.left {
    text-align: left;
}
.content table td {
    padding: 15px 10px;
    border-bottom: 2px solid #fff;
    background: rgba(243, 243, 243, 0.84);
}
table.total {
    position: absolute;
    right: 0;
    width: 50%;
}
table.total th {
    text-align: center;
    text-transform: none;
    font-weight: bold;
}
table.total td {
    text-align: left;
    padding: 8px 10px;
    background: #8784b1;
    color: #fff;
    font-weight: bold;
    border: none;
}
.footer {
    position: absolute;
    width: 90%;
    right: 30px;
    bottom: 35px;
}
.footer table {
    font-size: 0.8em;
}
</style>

<?php
error_reporting(0);
require_once '../../config.php';


$no = 1;
$totalarray = array();

$sql = "SELECT c.nama, e.tingkat, d.kelas, a.id_referensi, b.transaksi, a.catatan, a.jumlah, a.petugas,a.ts
FROM log_transaksi a
JOIN transaksi b ON a.id_transaksi=b.id
JOIN siswa c ON a.nis=c.nis
JOIN kelas d ON c.id_kelas=d.id
JOIN tingkat e ON d.id_tingkat=e.id
WHERE a.nis='".$_GET['nis']."' AND a.id_referensi='".$_GET['id_referensi']."'";


$query = $mysqli->prepare($sql);
$query->execute();
$result = $query->get_result();

while($row = $result->fetch_assoc()) {

    $data .= "
    <tr>
        <td align=\"center\">".$no."</td>
        <td>".$row['transaksi']." <br> ".ucwords($row['catatan'])."</td>
        <td>Rp. ".number_format($row['jumlah'],2,",",".")."</td>
    </tr>
    ";

    array_push($totalarray, $row['jumlah']);

    $no++;
}

$total = array_sum($totalarray);

$sqlid = "SELECT a.nama, c.tingkat, b.kelas, d.transfer, d.tanggal, d.petugas FROM siswa a JOIN kelas b ON a.id_kelas=b.id JOIN tingkat c ON b.id_tingkat=c.id JOIN log_transaksi d ON a.nis=d.nis WHERE a.nis='".$_GET['nis']."' AND d.id_referensi='".$_GET['id_referensi']."'";
$queryid = $mysqli->prepare($sqlid);
$queryid->execute();
$resultid = $queryid->get_result();
$id = $resultid->fetch_assoc();
if($id['transfer'] == 1) {
  $transaksi = 'Transfer';
} else {
  $transaksi = 'Tunai';
}

?>
<!-- <script>window.print();</script> -->
<div class="wrapper">
    <div class="logo"><img src="../../assets/img/logo-ms.png"></div>

    <div class="caption">
        <div class="invoice">INVOICE</div>
        <div class="invoice-for">
            <table>
                <tr>
                    <td>ID Referensi<td>
                    <td>:<td>
                    <td><?php echo $_GET['id_referensi']; ?><td>
                </tr>
                <tr>
                    <td>Nama<td>
                    <td>:<td>
                    <td><?php echo $id['nama']; ?><td>
                </tr>
                <tr>
                    <td>Kelas<td>
                    <td>:<td>
                    <td><?php echo $id['tingkat']." - ".$id['kelas']; ?><td>
                </tr>
                <tr>
                    <td>Tanggal<td>
                    <td>:<td>
                    <td><?php echo date('d-m-Y', strtotime($id['tanggal'])); ?><td>
                </tr>
                <tr>
                    <td>Transaksi<td>
                    <td>:<td>
                    <td><?php echo $transaksi; ?><td>
                </tr>
            </table>
        </div>
    </div>

    <div class="content">
        <table cellspacing="0">
            <tr>
                <th width="1">No</th>
                <th class="left">Deskripsi Pembayaran</th>
                <th class="left" width="25%">Jumlah</th>
            </tr>
            <?php echo $data;?>
        </table>
        <table class="total" cellspacing="0">
            <tr>
                <th class="center">TOTAL</th>
                <td width="50%">Rp. <?php echo number_format($total,2,",","."); ?></td>
            </tr>
        </table>
    </div>

    <div class="footer">
        <table width="100%">
            <tr>
                <td valign="top"><strong><?php echo $id['nama']; ?></strong><br><small>Yang menyerahkan</small></td>
                <td align="right"><strong><?php echo $id['petugas']; ?></strong><br><small>Bendahara</small></td>
            </tr>

        </table>
    </div>
</div>
