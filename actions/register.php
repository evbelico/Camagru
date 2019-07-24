<?php
require_once('../functions/register.php');
$username = htmlspecialchars($_POST['username']);
$vpassword = htmlspecialchars($_POST['password']);
$vpassword_confirm = htmlspecialchars($_POST['password-confirm']);
$mail = htmlspecialchars($_POST['mail']);
$pattern = '/^(?=.*[!@#$%^&*-])(?=.*[0-9])(?=.*[a-zA-Z]).{8,50}$/';


if (isset($_POST['register-submit'])) {
    if (empty($username) || empty($mail) || empty($vpassword) || empty($vpassword_confirm)) {
        header("Location: ../register.php?error=emptyfields&username=".$username."&mail=".$mail);
    }
    else if (!filter_var($mail, FILTER_VALIDATE_EMAIL)) {
        header("Location: ../register.php?error=invalidmail&username=".$username);
    }
    else if (!preg_match('/^[a-zA-Z0-9].{2,50}$/', $username)) {
        header("Location: ../register.php?error=invalidusername&mail=".$mail);
    }
    else if (!preg_match($pattern, $vpassword)) {
        header("Location: ../register.php?error=invalidpassword&username=".$username."&mail=".$mail);
    }
    else if ($vpassword_confirm != $vpassword) {
        header("Location: ../register.php?error=passwordsdonotmatch&username=".$username."&mail=".$mail);
    }
    else {
        if (register($username, $mail, $vpassword) == TRUE) {
            header("Location: ../register_success.php?registration=checkmail");
        }
        else {
            header("Location: ../register.php?error=registrationfailed");
        }
    }
}  
?>