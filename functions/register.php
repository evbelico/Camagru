<?php

function register($username, $mail, $password) {

    require(dirname(__FILE__).'/../config/database.php');
    require_once(dirname(__FILE__).'/mail.php');
        try {
            ### Check if the username or mail is already taken
            $sql = "SELECT id FROM camagru.users WHERE username=:username OR mail=:mail";
            $request = $cxn->prepare($sql);
            $request->execute(array(':username' => $username, ':mail' => $mail));
            $flag = $request->fetch(PDO::FETCH_ASSOC);
            if ($flag > 0)
                return (FALSE);
            else {
                ### Enter information into the database if it's clear
                $password = password_hash($password, PASSWORD_DEFAULT);
                $token = bin2hex(openssl_random_pseudo_bytes(64));
                $sql = "INSERT INTO camagru.users (username, password, mail, token, `creation`) VALUES (:username, :password, :mail, :token, NOW())";
                $request = $cxn->prepare($sql);
                $request->execute(array(':username' => $username, ':password' => $password, ':mail' => $mail, ':token' => $token));
                $url = URLROOT . "activate.php?token=" . $token;
                $link = '<a href="' . $url . '">' . $token . '</a>';
                registration_mail($mail, $username, $link);
                return (TRUE);
            }
        }
        catch (PDOException $e) {
            header("Location: register.php?error=registrationfailed");
        }
}
?>
