<?php
require_once('../functions/signin.php');

if (isset($_POST['login-submit'])) {
    session_start();
    $mail = htmlspecialchars($_POST['mail']);
    $password = htmlspecialchars($_POST['password']);
    if (signin($mail, $password) == TRUE)
        header("Location: ../signed_in.php?signin=success");
    else
        header("Location: ../signin.php?error=usernotfound");
}
?>