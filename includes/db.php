<?php

// Infinity Free hosting details 
// $dsn = "mysql:host=sql300.infinityfree.com;dbname=if0_36613634_phonebook"; // dsn = Database Server Name
// $db_username = "if0_36613634_XXX";
// $db_password = "kLQvFHHil0";

// Localhost details
$dsn = "mysql:host=localhost;dbname=phonebook"; // dsn = Database Server Name
$db_username = "root";
$db_password = "";

try {
    $pdo = new PDO($dsn, $db_username, $db_password); // pdo = PHP Data Object
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $error) {
    echo "Connection Error: " . $error->getMessage();
}
