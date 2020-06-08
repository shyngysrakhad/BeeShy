<?php

require "config.php";
require "Database.php";

$conn = new Database(DB_SERVER, DB_USER, DB_PASS, DB_DATABASE);

$db = $conn->connect();