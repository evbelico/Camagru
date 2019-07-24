<?php
function registration_mail($mail, $username, $link) {

    $receiver = $mail;
    $subject = "[Camagru] Last step before your full registration !";
    $message = "
    <html>
        <head>
            <title>Camagru registration</title>
        </head>
        <body>
            Hi " . $username . "!
            <br>
            Only one last step is left in order for you to log in and share your montages with the world !
            <br/>
            Follow this link in order to activate your account : ". $link ."
            <br/>
            We are happy to see you join the Camagru ranks ! See you soon on our website. :)
        </body>
    </html>
    ";
    $headers = "MIME-Version: 1.0\r\n";
    $headers .= "Content-type: text/html;charset=UTF-8\r\n";
    $headers .= "From: <evbelico@student.42.fr>\r\n";
    mail($receiver, $subject, $message, $headers);
}

function forgot_password_mail($mail, $username, $url) {
    
    $receiver = $mail;
    $subject = "[Camagru] Have you forgotten your password ?";
    $message = "
    <html>
        <head>
            <title>Camagru forgotten password</title>
        </head>
        <body>
            Hi ". $username ."!
            <br/>
            It seems you have forgotten your password. You can reset it at this link : ". $url ."
            <br/>
            See you back soon on Camagru. :)
            <br/>
            <hr>
            If you did not ask to reset your password, your account might have been compromised. You should also change
            your account's e-mail address.
        </body>
    </html>
    ";
    $headers = "MIME-Version: 1.0\r\n";
    $headers .= "Content-type: text/html;charset=UTF-8\r\n";
    $headers .= "From: <evbelico@student.42.fr>\r\n";
    mail($receiver, $subject, $message, $headers);
}

function comment_mail($username, $mail, $content, $from) {
    $receiver = $mail;
    $subject = "[Camagru] New comment !";
    $message = '
    <html>
        <head>
            <title>Camagru comment</title>
            <meta charset="utf-8" name="viewport">
        </head>
        <body>
            Hi '. $username .' !<br/>
            '. $from .' left a comment under one of your snapshots. Have a look ! <br/>'. $content. '
        </body>
    </html>';
    $headers = "MIME-Version: 1.0\r\n";
    $headers .= "Content-type: text/html;charset=UTF-8\r\n";
    $headers .= "From: <evbelico@student.42.fr>\r\n";
    mail($receiver, $subject, $message, $headers);
}
?>
