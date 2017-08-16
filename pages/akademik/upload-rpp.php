
<link rel="stylesheet" href="../../assets/css/third-party.css">

<?php
// CONECT DATABASE
require "../../config.php";

$sqlpelajaran = "SELECT kode,pelajaran FROM pelajaran WHERE aktif=1";
$querypelajaran = $mysqli->prepare($sqlpelajaran);
$querypelajaran->execute();
$resultpelajaran = $querypelajaran->get_result();

while ($row = $resultpelajaran->fetch_assoc()) {
    $show.="
    <option value=\"".$row['kode']."\">".$row['pelajaran']."</option>
    ";
}

if($_POST['submit']){
    $pelajaran = $_POST['pelajaran'];
    $nip       = $_POST['nip'];
    $file_name = $_FILES['file']['name'];
    $tmp_name  = $_FILES['file']['tmp_name'];
    $file_size = $_FILES['file']['size'];
    $file_type = $_FILES['file']['type'];

    $fp = fopen($tmp_name, 'r');

    $file_content = fread($fp, $file_size);
    $file_content = $mysqli->real_escape_string($file_content);
    // INSERT
    $sql = "INSERT INTO rpp
    SET
    nip='".$nip."',
    kode_mapel='".$pelajaran."',
    file_name='".$file_name."',
    file_type='".$file_type."',
    file_size='".$file_size."',
    file_content='".$file_content."'";

    if(!empty($pelajaran)) {
        if(!$file_content) {
            echo "<div class=\"notif-error\">Error: Filenya gak kebaca!</div>";
        } else {
            $query = $mysqli->query($sql);
            if($query) {
            	echo "<div class=\"notif-success\">RPP berhasil diupload.</div>";
            } else {
                echo "<div class=\"notif-error\">Sepertinya ada yang error!</div>";
            }
        }
    } else {
        echo "<div class=\"notif-error\">Pilih dulu atuh mata pelajarannya!</div>";
    }

    fclose($fp);
}
?>

<form method="post" enctype="multipart/form-data">

    <input type="hidden" name="nip" value="<?php echo $_GET['nip'] ?>">

    <select name="pelajaran">
        <option value="">Pilih Pelajaran</option>
        <?php echo $show; ?>
    </select>

    <div class="box">
        <input type="file" name="file" id="file" class="inputfile inputfile-5 hidden"/>
        <label for="file"><figure><svg xmlns="http://www.w3.org/2000/svg" width="20" height="17" viewBox="0 0 20 17"><path d="M10 0l-5.2 4.9h3.3v5.1h3.8v-5.1h3.3l-5.2-4.9zm9.3 11.5l-3.2-2.1h-2l3.4 2.6h-3.5c-.1 0-.2.1-.2.1l-.8 2.3h-6l-.8-2.2c-.1-.1-.1-.2-.2-.2h-3.6l3.4-2.6h-2l-3.2 2.1c-.4.3-.7 1-.6 1.5l.6 3.1c.1.5.7.9 1.2.9h16.3c.6 0 1.1-.4 1.3-.9l.6-3.1c.1-.5-.2-1.2-.7-1.5z"/></svg></figure> <span></span></label>
    </div>

    <div class="form-group">
        <input class="btn" name="submit" type="submit" value="Upload">
    </div>
</form>

<script src="../../assets/js/custom-file-input.js"></script>
