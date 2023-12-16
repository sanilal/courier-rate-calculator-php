<?php
ob_start();
session_start();
$_SESSION['user_id']=NULL;
$_SESSION = array();
session_destroy();
$messages[] = "You have been logged out.";
header("location:index.php");
?>