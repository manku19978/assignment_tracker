<?php

$dsn = 'mysql:host=localhost;dbname=assignment_tracker';
$username = 'root';
// If you have password
// $password = 'password'

try {
    // If there was password
    // $db = new PDO($dsn, $username, $password);
    $db = new PDO($dsn, $username);
} catch (PDOException $e) {
    $error = "Database Error: ";
    $error .= $e->getMessage();
    include('view/error.php');
    exit();
}
