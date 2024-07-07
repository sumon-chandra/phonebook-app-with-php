<?php
require_once "./includes/db.php";
require_once "./includes/config-session.php";

try {
    $userId =  isset($_SESSION["user_id"]) ? $_SESSION["user_id"] : "";

    // Get the user from users table
    $query = "SELECT * FROM users WHERE id = $userId";
    $statement = $pdo->prepare($query);
    $statement->execute();
    $user = $statement->fetch(PDO::FETCH_ASSOC);
} catch (PDOException $error) {
    die("Something went wrong! Please try again. " . $error->getMessage());
}
