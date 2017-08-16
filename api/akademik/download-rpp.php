<?php

require "../../config.php";

$id    = $_GET['id'];
$sql = "SELECT file_name, file_type, file_size, file_content FROM rpp WHERE id='".$id."'";
$query = $mysqli->prepare($sql);
$query->execute();
$result = $query->get_result();

$row = $result->fetch_assoc();

header("Content-length: ".$row['file_size']."");
header("Content-type: ".$row['file_type']."");
header("Content-Disposition: attachment; filename= ".$row['file_name']."");
echo $content;


?>
