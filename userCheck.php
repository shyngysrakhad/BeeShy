<?php
require 'User.php';
require 'Admin.php';
if ($_SESSION['user']['type'] == 'admin'){
    $user = new Admin($_SESSION['user']['id']);
}else{
    $user = new User($_SESSION['user']['id']);
}