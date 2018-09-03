<?php

$dsn = 'mysql:host=localhost;dbname=news_book';
$user = 'root';
$pass = '';
$options = array(
    PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
);

try {
    $connection = new PDO($dsn, $user, $pass, $options);
    $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PFOException $e) {
    echo 'Failed to connect to database: ' . $e->getMessage(); 
}