<?php



session_start();

if (!isset($_SESSION['Username']) || !isset($_SESSION['PermissionLevel']) ) {

    // Set this to false for production.
    if (false) {
        $_SESSION['Username'] = "Patrick Ancel";
        $_SESSION['PermissionLevel'] = "1";
    } else {
        session_destroy();
        header("Location: login.php");
    }
}

$username = $_SESSION['Username'];
$permission = $_SESSION['PermissionLevel'] + 0;