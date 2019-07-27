<?php

function signin($mail, $password) {

    require_once('../config/database.php');
    global $_SESSION;
        try {
            $sql = "SELECT id, username, mail, `password` FROM camagru.users WHERE mail=:mail AND verified='Y'";
            $request = $cxn->prepare($sql);
            $request->execute(array(':mail' => $mail));
            $result = $request->fetch(PDO::FETCH_ASSOC);
            if (password_verify($password, $result['password']) == TRUE) {
                $_SESSION['loggued-on-user'] = $result['username'];
                $_SESSION['userid'] = $result['id'];
                $_SESSION['mail'] = $result['mail'];
                return (TRUE);
            }
        }
        catch (PDOException $e) {
            header("Location: ../signin.php?error=usernotfound");
        }
}
?>