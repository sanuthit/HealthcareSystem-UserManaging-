<?php
$serverName = 'localhost';
$dbUsername = 'sanuthi';
$dbPassword = '24-Ivh-Nfoox9[me';
$dbName = 'user_info';

$conn = mysqli_connect($serverName, $dbUsername, $dbPassword, $dbName);

if(!$conn) {
    die("Connection failed : " .mysqli_connect_error());
} 