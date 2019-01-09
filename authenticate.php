
<?php
/*
by Austin
*/
session_start();
if(empty($_SESSION["authenticated"]) || $_SESSION["authenticated"] != 'true') {
    header('Location: loginPage.php');
}
?>
