<?php
header('Content-Type: application/json');
session_start();
setcookie(session_name(), '', 100);
unset($_SESSION['user']);
session_unset();
session_destroy();
$_SESSION = array();
echo json_encode(array('message'=>'success'));
header("Location: authentication.php");