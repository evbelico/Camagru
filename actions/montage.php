<?php
require_once(dirname(__FILE__).'/../functions/montage.php');

session_start();
$image64 = htmlspecialchars($_POST['file']);
$filter = htmlspecialchars($_POST['img']);

$directory = '../snapshots/';
if (!file_exists($directory)) {
    mkdir($directory);
}

list($type, $image64) = explode(';', $image64);
list(, $image64) = explode(',', $image64);
$image64 = str_replace(' ', '+', $image64);
$image64 = base64_decode($image64);
$image_name = date("Y-m-d-h:i:s");
$image_path = $_SESSION['loggued-on-user'].'-'.$image_name.'.png';
$path = $directory.$image_path;
file_put_contents($path, $image64);
if (filesize($path) > 1048576) {
    unlink($path);
    exit();
}
else 
    init_montage($path, $filter, $image_path);
?>