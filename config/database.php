<?php
$DBNAME = "camagru";
$DBHOST = "127.0.0.1";
$DBLOG = "root";
$DBPWD = "DivisionJoy1";
$IMAGE = "img/";
$DBDSN = 'mysql:host='.$DBHOST.';port=3306';
if (!defined('URLROOT')) {
    define('URLROOT' , 'http://127.0.0.1:8080/');
}

try {
    $cxn = new PDO($DBDSN, $DBLOG, $DBPWD);
    $cxn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch (PDOException $e) {
    die("FAILURE : Connexion failed " . $e->getMessage() . "\n");
}
?>
