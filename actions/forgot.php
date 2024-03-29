<?php
require_once(dirname(__FILE__).'/../functions/modify.php');

session_start();
if (isset($_POST['forgot-submit'])) {
    $mail = htmlspecialchars($_POST['mail']);
    if (forgot_password($mail) == TRUE) {
        $_SESSION['forgot-msg'] = "A reset link has been sent via mail.";
        header("Location: ../forgot.php");
        return;
    }
    else {
        $_SESSION['forgot-error'] = "User not found or not validated.";
        header("Location: ../forgot.php");
        return;
    }
}

if (isset($_POST['reset-submit'])) {
    if (isset($_POST['mail']) && isset($_POST['password-reset']) && isset($_POST['password-reset-confirm'])) {
        $ok = true;
        $messages = array();
        $mail = htmlspecialchars($_POST['mail']);
        $password = htmlspecialchars($_POST['password-reset']);
        $vpassword = htmlspecialchars($_POST['password-reset-confirm']);
        $pattern = '/^(?=.*[!@#$%^&*-])(?=.*[0-9])(?=.*[a-zA-Z]).{8,50}$/';
        if (!filter_var($mail, FILTER_VALIDATE_EMAIL) || $mail == '') {
            $ok = false;
            $messages[] = "Invalid e-mail address.";
        }
        else if (!preg_match($pattern, $password)) {
            $ok = false;
            $messages[] = "Your password should contain 8 to 50 characters, including one capital letter, one small letter and one special character such as : !@#$%^&*-";
        }
        else if ($vpassword != $password) {
            $ok = false;
            $messages[] = "Passwords do not match.";
        }
        else {
            reset_password($mail, $password);
        }
        if (!$ok) {
            $_SESSION['reset-error'] = $messages;
            header('Location: ../index.php');
            return;
        }
    }
}
?>