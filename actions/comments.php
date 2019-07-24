<?php
require_once(dirname(__FILE__).'/../functions/comments.php');
session_start();
global $_SESSION;

if (isset($_SESSION['loggued-on-user']) && !empty($_SESSION['loggued-on-user'])) {
    $poster = htmlspecialchars($_SESSION['loggued-on-user']);
    $posterid = htmlspecialchars($_SESSION['userid']);
    $userid = htmlspecialchars($_POST['userid']);
    $text = htmlspecialchars($_POST['comment']);
    $imageid = htmlspecialchars($_POST['imageid']);
    $snapshot_src = htmlspecialchars($_POST['snapshot']);

    add_comment($poster, $posterid, $userid, $imageid, $text, $snapshot_src);

}
else {
    header("Location: ../signin.php&message=loginfirst");
}
?>