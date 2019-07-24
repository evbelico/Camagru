<?php
require_once(dirname(__FILE__).'/../functions/delete.php');

session_start();
if (isset($_POST['delete-submit'])) {
    if (isset($_SESSION['loggued-on-user']) && isset($_SESSION['userid']) && isset($_POST['mail']) && isset($_POST['password']) && isset($_POST['password-confirm'])) {
        $userid = $_SESSION['userid'];
        $password = htmlspecialchars($_POST['password']);
        $password_confirm = htmlspecialchars($_POST['password-confirm']);
        $mail = htmlspecialchars($_POST['mail']);
        if ($password_confirm == $password) {
            if (delete_account($userid, $mail, $password, $password_confirm) == TRUE) {
                header("Location: ../index.php");
                unset($_SESSION['userid']);
                unset($_SESSION['loggued-on-user']);
            }
            else {
                header("Location: ../user.php?error=usernotfound");
            }
        }
        else 
            header("Location: ../user.php?error=passwordsdonotmatch");
    }
}

if (isset($_SESSION['loggued-on-user']) && $_SESSION['loggued-on-user'] != '' && isset($_POST['imageid']) && isset($_POST['userid']) && isset($_POST['snapshot'])) {

    $imageid = htmlspecialchars($_POST['imageid']);
    $userid = htmlspecialchars($_POST['userid']);
    $snapshot = htmlspecialchars($_POST['snapshot']);

    delete_content($userid, $imageid, $snapshot);
}
?>