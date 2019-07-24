<?php
session_start();
unset($_SESSION['loggued-on-user']);
session_destroy();
header("Location: index.php");
?>