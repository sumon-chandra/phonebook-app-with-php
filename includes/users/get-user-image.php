<?php
require_once "./includes/db.php";
require_once "./includes/config-session.php";

try {
    $userId =  isset($_SESSION["user_id"]) ? $_SESSION["user_id"] : "";

    // Get the user from users table
    $query = "SELECT * FROM users_images WHERE user_id = :id";
    $statement = $pdo->prepare($query);
    $statement->bindParam(":id", $userId);
    $statement->execute();
    $userImage = $statement->fetch(PDO::FETCH_ASSOC);
} catch (PDOException $error) {
    die("Something went wrong! Please try again. " . $error->getMessage());
}
