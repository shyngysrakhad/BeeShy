<?php
session_start();
if(!isset($_COOKIE['how'])){
    setcookie("how", "mix", time() + 24*60*60);
}
if (empty($_SESSION['user'])){
    header("Location: auth/authentication.php");
    return;
}
