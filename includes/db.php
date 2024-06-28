<?php

$dsn = "mysql:host=localhost;dbname=phonebook"; // dsn = Database Server Name
$db_username = "root";
$db_password = "";

try {
    $pdo = new PDO($dsn, $db_username, $db_password); // pdo = PHP Data Object
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $error) {
    echo "Connection Error: " . $error->getMessage();
}
