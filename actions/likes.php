<?php
require_once(dirname(__FILE__).'/../functions/likes.php');
session_start();

if (isset($_SESSION['loggued-on-user']) && !empty($_SESSION['loggued-on-user'])) {
    $likerid = htmlspecialchars($_SESSION['userid']);
    $userid = htmlspecialchars($_POST['userid']);
    $imageid = htmlspecialchars($_POST['imageid']);
    $type = htmlspecialchars($_POST['like']);
    $snapshot = htmlspecialchars($_POST['snapshot']);

    if ($type == 'L') {
        add_like($likerid, $userid, $imageid, $snapshot);
    }
    else if ($type == 'D') {
        add_dislike($likerid, $userid, $imageid, $snapshot);
    }
}
else {
    header("Location: ../gallery.php?error=usernotfoundcouldnotlikedislike");
}
?>