<?php
require_once(dirname(__FILE__).'/../functions/modify.php');
session_start();

if (isset($_POST['username-submit'])) {
    if (isset($_SESSION['loggued-on-user']) && isset($_SESSION['userid'])) {
        $username = htmlspecialchars($_SESSION['loggued-on-user']);
        $new_username = htmlspecialchars(trim($_POST['new-username']));
        $password = htmlspecialchars(trim($_POST['password']));
        if (!preg_match('/^[a-zA-Z].{2,50}$/', $new_username))
            header("Location: ../user.php?error=wrongusername");
        else {
            if (modify_username($username, $new_username, $password) == TRUE)
                header("Location: ../user.php?modification=success");
            else
                header("Location: ../user.php?error=usernameunchanged");
        }
    }
}

if (isset($_POST['mail-submit'])) {
    if (isset($_SESSION['loggued-on-user']) && isset($_SESSION['userid'])) {
        $mail = htmlspecialchars($_SESSION['mail']);
        $new_mail = htmlspecialchars(trim($_POST['new-mail']));
        $password = htmlspecialchars(trim($_POST['password']));
        if (!filter_var($new_mail, FILTER_VALIDATE_EMAIL))
            header("Location: ../user.php?error=wrongmail");
        else {
            if (modify_mail($mail, $new_mail, $password) == TRUE)
                header("Location: ../user.php?modification=success");
            else
                header("Location: ../user.php?error=mailunchanged");
        }
    }
}

if (isset($_POST['password-submit'])) {
    if (isset($_SESSION['loggued-on-user']) && isset($_SESSION['userid'])) {
        $password = htmlspecialchars($_POST['password']);
        $new_password = htmlspecialchars($_POST['new-password']);
        $username = htmlspecialchars($_SESSION['loggued-on-user']);
        $pattern = '/^(?=.*[!@#$%^&*-])(?=.*[0-9])(?=.*[a-zA-Z]).{8,50}$/';
        if (!preg_match($pattern, $new_password)) {
            header("Location: ../user.php?error=wrongpasswordformat");
        }
        else if ($new_password == $password) {
            header("Location: ../user.php?error=passwordsarethesame");
        }
        else {
            if (modify_password($username, $password, $new_password) == TRUE) {
                header("Location: ../user.php?modification=success");
            }
            else {
                header("Location: ../user.php?error=passwordunchanged");
            }
            
        }
    }
}

if (isset($_POST['mailing-submit'])) {
    if (isset($_SESSION['loggued-on-user']) && isset($_SESSION['userid']) && (isset($_POST['get-mails']) || isset($_POST['no-mails']))) {
        $userid = $_SESSION['userid'];

        $answer = ($_POST['get-mails'] ? 'Y' : 'N');
        if (modify_mailing($userid, $answer) == TRUE)
            header("Location: ../user.php?message=preferencechanged");
        else
            header("Location: ../user.php?error=preferenceunchanged");

    }
    else
        header("Location: ../user.php?message=choosebeforehand");
}
?>