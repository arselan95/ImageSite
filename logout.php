<?php
/*
log out  by Austin
*/

session_start();
unset($_SESSION['user']);
session_destroy();

header("Location: loginPage.php");
exit;
?>