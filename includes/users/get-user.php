<?php
require_once "./includes/db.php";
require_once "./includes/config-session.php";

try {
    $user_id = $_SESSION["user_id"];

    // Get the user from users table
    $query = "SELECT * FROM users WHERE id = $user_id";
    $statement = $pdo->prepare($query);
    $statement->execute();
    $user = $statement->fetch(PDO::FETCH_ASSOC);
} catch (PDOException $error) {
    die("Something went wrong! Please try again. " . $error->getMessage());
}
