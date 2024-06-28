<?php
require_once "db.php";

try {
    // Getting contacts from the database
    $query = "SELECT * FROM contacts";
    $statement = $pdo->prepare($query);
    $statement->execute();
    $data = $statement->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $error) {
    die("Failed to load contacts" . $error->getMessage());
}
