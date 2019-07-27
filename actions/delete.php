<?php
require_once(dirname(__FILE__).'/../functions/delete.php');

session_start();
if (isset($_POST['delete-submit'])) {
    if (isset($_SESSION['loggued-on-user']) && isset($_SESSION['userid']) && isset($_POST['mail']) && isset($_POST['password']) && isset($_POST['password-confirm'])) {
        $userid = $_SESSION['userid'];
        $password = htmlspecialchars($_POST['password']);
        $password_confirm = htmlspecialchars($_POST['password-confirm']);
        $mail = htmlspecialchars($_POST['mail']);
        $ok = true;
        $messages = array();
        if ($password_confirm == $password) {
            if (delete_account($userid, $mail, $password, $password_confirm) == TRUE) {
                $_SESSION['userid'] = null;
                $_SESSION['loggued-on-user'] = null;
                $_SESSION['mail'] = null;
                header("Location: ../index.php");
            }
            else {
                $ok = false;
                $messages[] = "Your account could not be deleted. Try again.";
            }
        }
        else {
            $ok = false;
            $messages[] = "Passwords do not match.";
        }
        if (!$ok) {
            $_SESSION['delete-account-error'] = $messages;
            header("Location: ../user.php");
            exit;
        }
    }
}

if (isset($_SESSION['loggued-on-user']) && $_SESSION['loggued-on-user'] != '' && isset($_POST['imageid']) && isset($_POST['userid']) && isset($_POST['snapshot'])) {

    $imageid = htmlspecialchars($_POST['imageid']);
    $userid = htmlspecialchars($_POST['userid']);
    $snapshot = htmlspecialchars($_POST['snapshot']);

    delete_content($userid, $imageid, $snapshot);
}
?>