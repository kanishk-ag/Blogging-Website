<?php
session_start();
unset($_SESSION["admin"]);
unset($_SESSION["pass"]);
session_unset();
session_destroy();
header("Location: adminlogin.php");
?>