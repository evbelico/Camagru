<?php
require_once(dirname(__FILE__).'/../functions/modify.php');
session_start();

if (isset($_POST['username-submit'])) {
    if (isset($_SESSION['loggued-on-user']) && isset($_SESSION['userid'])) {
        $username = htmlspecialchars($_SESSION['loggued-on-user']);
        $new_username = htmlspecialchars(trim($_POST['new-username']));
        $password = htmlspecialchars(trim($_POST['password']));
        $messages = array();
        $ok = true;
        if (!preg_match('/^[a-zA-Z].{2,50}$/', $new_username)) {
            $ok = false;
            $messages[] = "Your username should be made of letters and/or numbers, and be 2 to 50 characters long.";
        }
        else {
            if (modify_username($username, $new_username, $password) == TRUE) {
                $_SESSION['mod-username-ok'] = "Username successfully changed !";
                header("Location: ../user.php");
                return;
            }
            else {
                $ok = false;
                $messages[] = "Username could not be changed.";
            }
        }
        $_SESSION['mod-username-error'] = $messages;
        header("Location: ../user.php");
        return;
    }
}

if (isset($_POST['mail-submit'])) {
    if (isset($_SESSION['loggued-on-user']) && isset($_SESSION['userid'])) {
        $mail = htmlspecialchars($_SESSION['mail']);
        $new_mail = htmlspecialchars(trim($_POST['new-mail']));
        $password = htmlspecialchars(trim($_POST['password']));
        $messages = array();
        $ok = true;
        if (!filter_var($new_mail, FILTER_VALIDATE_EMAIL)) {
            $ok = false;
            $messages[] = "E-mail address is not valid.";
        }
        else {
            if (modify_mail($mail, $new_mail, $password) == TRUE) {
                $_SESSION['mod-mail-ok'] = "E-mail address successfully changed !";
                header("Location: ../user.php");
                return;
            }
            else {
                $ok = false;
                $messages[] = "E-mail address could not be changed. Try again.";
            }
        }
        $_SESSION['mod-mail-error'] = $messages;
        header("Location: ../user.php");
        return;
    }
}

if (isset($_POST['password-submit'])) {
    if (isset($_SESSION['loggued-on-user']) && isset($_SESSION['userid'])) {
        $password = htmlspecialchars($_POST['password']);
        $new_password = htmlspecialchars($_POST['new-password']);
        $username = htmlspecialchars($_SESSION['loggued-on-user']);
        $pattern = '/^(?=.*[!@#$%^&*-])(?=.*[0-9])(?=.*[a-zA-Z]).{8,50}$/';
        $messages = array();
        $ok = true;
        if (!preg_match($pattern, $new_password)) {
            $ok = false;
            $messages[] = "Your password should contain 8 to 50 characters, including one capital letter, one small letter and one special character such as : !@#$%^&*-";
        }
        else if ($new_password == $password) {
            $ok = false;
            $messages[] = "Passwords are the same.";
        }
        else {
            if (modify_password($username, $password, $new_password) == TRUE) {
                $_SESSION['mod-pwd-ok'] = "Password successfully changed !";
                header("Location: ../user.php");
                return;
            }
            else {
                $ok = false;
                $messages[] = "Password could not be changed. Try again.";
            }
        }
        $_SESSION['mod-pwd-error'] = $messages;
        header("Location: ../user.php");
        return;
    }
}

if (isset($_POST['mailing-submit'])) {
    if (isset($_SESSION['loggued-on-user']) && isset($_SESSION['userid']) && (isset($_POST['get-mails']) || isset($_POST['no-mails']))) {
        $userid = $_SESSION['userid'];
        $answer = ($_POST['get-mails'] ? 'Y' : 'N');
        if (modify_mailing($userid, $answer) == TRUE) {
            $_SESSION['mod-mailing-ok'] = "Preference changed.";
            header("Location: ../user.php");
            return;
        }
        else {
            $_SESSION['mod-mailing-error'] = "Preference could not be changed. Try again.";
            header("Location: ../user.php");
            return;
        }
    }
    else {
        $_SESSION['mod-mailing-error'] = "Pick a preference beforehand.";
        header("Location: ../user.php");
        return;
    }
}
?>