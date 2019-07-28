<?php

function modify_username($username, $new_username, $password) {

    require(dirname(__FILE__).'/../config/database.php');

    global $_SESSION;
    try {
        $sql = "SELECT id, username FROM camagru.users WHERE username=:username";
        $request = $cxn->prepare($sql);
        $request->execute(array(":username" => $new_username));
        $result = $request->fetch(PDO::FETCH_ASSOC);
        if ($result > 0)
            return (FALSE);
        else {
            $sql = "SELECT id, username, `password` FROM camagru.users WHERE username=:username";
            $request = $cxn->prepare($sql);
            $request->execute(array(':username' => $username));
            $result = $request->fetch(PDO::FETCH_ASSOC);
            if ($result > 0) {
                if (password_verify($password, $result['password']) == TRUE) {
                    $sql = "UPDATE camagru.users SET username=:username WHERE id=:id";
                    $request = $cxn->prepare($sql);
                    $request->execute(array(':username' => $new_username, ':id' => $result['id']));
                    $_SESSION['loggued-on-user'] = $new_username;
                    return (TRUE);
                }
                else
                    return (FALSE);
            }
        }
    }
    catch (PDOException $e) {
        echo "FAILURE : " . $e->getMessage() . "\n";
    }
}

function modify_mail($mail, $new_mail, $password) {

    require(dirname(__FILE__).'/../config/database.php');

    try {
        $sql = "SELECT id, mail FROM camagru.users WHERE mail=:mail";
        $request = $cxn->prepare($sql);
        $request->execute(array(':mail' => $new_mail));
        $result = $request->fetch(PDO::FETCH_ASSOC);
        if ($result > 0)
            return (FALSE);
        else {
            $sql = "SELECT id, mail, `password` FROM camagru.users WHERE mail=:mail";
            $request = $cxn->prepare($sql);
            $request->execute(array(':mail' => $mail));
            $result = $request->fetch(PDO::FETCH_ASSOC);
            if ($result > 0) {
                if (password_verify($password, $result['password']) == TRUE) {
                    $sql = "UPDATE camagru.users SET mail=:mail WHERE id=:id";
                    $request = $cxn->prepare($sql);
                    $request->execute(array(':mail' => $new_mail, ':id' => $result['id']));
                    $_SESSION['mail'] = $new_mail;
                    return (TRUE);
                }
            }
            else
                return (FALSE);
        }
    }
    catch (PDOException $e) {
        echo "FAILURE : " . $e->getMessage() . "\n";
    }
}

function modify_password($username, $password, $new_password) {

    require(dirname(__FILE__).'/../config/database.php');

    try {
        $sql = "SELECT `password` FROM camagru.users WHERE username=:username";
        $request = $cxn->prepare($sql);
        $request->execute(array(':username' => $username));
        $result = $request->fetch(PDO::FETCH_ASSOC);
        if ($result > 0) {
            if (password_verify($password, $result['password']) == TRUE) {
                $new_password = password_hash($new_password, PASSWORD_DEFAULT);
                $sql = "UPDATE camagru.users SET `password`=:password WHERE username=:username";
                $request = $cxn->prepare($sql);
                $request->execute(array(':password' => $new_password, ':username' => $username));
                return (TRUE);
            }
            else
                return (FALSE);
        }
    }
    catch (PDOException $e) {
        echo "ERROR : your password remains unchanged : ". $e->getMessage() . "\nAborting.\n";
    }
}

function modify_mailing($userid, $type) {

    require(dirname(__FILE__).'/../config/database.php');

    try {
        $sql = "UPDATE camagru.users SET mailing=:mailing WHERE id=:id";
        $request = $cxn->prepare($sql);
        $request->execute(array(':mailing' => $type, ':id' => $userid));
        return (TRUE);
    }
    catch (PDOException $e) {
        echo "FAILURE : mailing could not be changed : " . $e->getMessage() . "\nAborting.\n";
    }
}

function forgot_password($mail) {

    require(dirname(__FILE__).'/../config/database.php');
    require_once(dirname(__FILE__).'/mail.php');

    try {
        $sql = "SELECT username, mail FROM camagru.users WHERE mail=:mail";
        $request = $cxn->prepare($sql);
        $request->execute(array(':mail' => $mail));
        $result = $request->fetch(PDO::FETCH_ASSOC);
        if ($result > 0) {
            $token = bin2hex(openssl_random_pseudo_bytes(64));
            $url = URLROOT ."reset.php?reset=". $token;
            $link = '<a href="' . $url . '">' . $token . '</a>';
            $sql = "UPDATE camagru.users SET `password`=:pass WHERE mail=:mail";
            $request = $cxn->prepare($sql);
            $request->execute(array(':pass' => $token, ':mail'=> $result['mail']));

            forgot_password_mail($result['mail'], $result['username'], $link);
            return (TRUE);
        }
    }
    catch (PDOException $e) {
        echo "FAILURE : password reset link was not sent : ". $e->getMessage() ."\nAborting.\n";
    }
}

function reset_password($mail, $password) {
    
    require(dirname(__FILE__).'/../config/database.php');

    try {
        $sql = "SELECT mail FROM camagru.users WHERE mail=:mail AND verified='Y'";
        $request = $cxn->prepare($sql);
        $request->execute(array(':mail' => $mail));
        $result = $request->fetch(PDO::FETCH_ASSOC);
        if ($result > 0) {
            $password = password_hash($password, PASSWORD_DEFAULT);
            $sql = "UPDATE camagru.users SET `password`=:pass WHERE mail=:mail";
            $request = $cxn->prepare($sql);
            $request->execute(array(':pass' => $password, ':mail' => $result['mail']));
            header("Location: ../signin.php");
        }
        else
            header("Location: ../index.php");
    }
    catch (PDOException $e) {
        echo "ERROR : could not reset old password : ". $e->getMessage() ."\nAborting.\n";
    }
}
?>