<?php
session_start();
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Camagru</title>
        <meta charset="utf-8" name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" type="text/css" href="../css/homepage.css">
    </head>
    <body>
        <div id="header">
            <form action="index.php">
                <h1>Camagru !</h1>
            </form>
            <a href="index.php">Home</a>
            <a href="gallery.php">Gallery</a>
            <?php if (isset($_SESSION['loggued-on-user']) && $_SESSION['loggued-on-user'] != '') { ?>
                <a href="user.php"><?php echo $_SESSION['loggued-on-user']; ?></a>
                <a href="signout.php">Logout</a>
                <a href="signed_in.php">Snapshot</a>
            <?php } else { ?>
                <a href="signin.php">Login</a>
                <a href="register.php">Register</a>
            <?php } ?>
        </div>