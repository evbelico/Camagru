<?php
require_once(dirname(__FILE__).'/../functions/modify.php');

session_start();
if (isset($_POST['forgot-submit'])) {
    $mail = htmlspecialchars($_POST['mail']);
    if (forgot_password($mail) == TRUE)
        header("Location: ../signin.php?message=checkmailforlink");
    else
        header("Location: ../register.php?error=usernotfound");
}

if (isset($_POST['reset-submit'])) {
    if (isset($_POST['mail']) && isset($_POST['password-reset']) && isset($_POST['password-reset-confirm'])) {
        $mail = htmlspecialchars($_POST['mail']);
        $password = htmlspecialchars($_POST['password-reset']);
        $vpassword = htmlspecialchars($_POST['password-reset-confirm']);
        $pattern = '/^(?=.*[!@#$%^&*-])(?=.*[0-9])(?=.*[a-zA-Z]).{8,50}$/';
    if (!filter_var($mail, FILTER_VALIDATE_EMAIL) || $mail == '') {
        echo "Invalid e-mail address\n.";
    }
    else if (!preg_match($pattern, $password)) {
        echo "Wrong password format.\n";
    }
    else if ($vpassword != $password) {
        echo "Passwords do not match. Try again.\n";
    }
    else
        reset_password($mail, $password, $vpassword);
    }
}
?>