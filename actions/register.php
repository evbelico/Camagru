<?php
require_once(dirname(__FILE__).'/../functions/register.php');
session_start();

if (isset($_POST['register-submit'])) {

    $ok = true;
    $messages = array();
    $username = htmlspecialchars($_POST['username']);
    $vpassword = htmlspecialchars($_POST['password']);
    $vpassword_confirm = htmlspecialchars($_POST['password-confirm']);
    $mail = htmlspecialchars($_POST['mail']);
    $pattern = '/^(?=.*[!@#$%^&*-])(?=.*[0-9])(?=.*[a-zA-Z]).{8,50}$/';
    
    if (empty($username) || empty($mail) || empty($vpassword) || empty($vpassword_confirm)) {
        $ok = false;
        $messages[] = "Please fill out all the fields below.";
    }
    else if (!filter_var($mail, FILTER_VALIDATE_EMAIL)) {
        $ok = false;
        $messages[] = "Invalid e-mail address.";
    }
    else if (!preg_match('/^[a-zA-Z0-9].{2,50}$/', $username)) {
        $ok = false;
        $messages[] = "Your username should be made of letters and/or numbers, and be 2 to 50 characters long.";
    }
    else if (!preg_match($pattern, $vpassword)) {
        $ok = false;
        $messages[] = "Your password should contain 8 to 50 characters, including one capital letter, one small letter and one special character such as : !@#$%^&*-";
    }
    else if ($vpassword_confirm != $vpassword) {
        $ok = false;
        $messages[] = "Passwords do not match.";
    }
    if ($ok) {
        if (register($username, $mail, $vpassword) == TRUE)
            header("Location: ../register_success.php");
        else {
            $ok = false;
            $messages[] = "Registration failed. Try again.";
        }
    }
    else {
        $_SESSION['register-msg'] = $messages;
        header("Location: ../register.php");
        return;
    }
}  
?>