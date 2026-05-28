<?php
require_once 'session_db.php';
session_start();
$_SESSION = array();
session_destroy();
header("Location:login.php");
?>