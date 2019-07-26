<?php
require_once(dirname(__FILE__).'/../functions/signin.php');
session_start();

if (isset($_POST['login-submit'])) {
    $mail = htmlspecialchars($_POST['mail']);
    $password = htmlspecialchars($_POST['password']);
    if (signin($mail, $password) == TRUE)
        header("Location: ../signed_in.php?signin=success");
    else {
        $_SESSION['signin-msg'] = "User not found.";
        header("Location: ../signin.php");
        return;
    }
}
?>