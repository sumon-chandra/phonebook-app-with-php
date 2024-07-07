<?php

declare(strict_types=1);

function getEmail(object $pdo, string $email)
{
    $query = "SELECT email FROM users WHERE email = :email;";
    $statement = $pdo->prepare($query);
    $statement->bindParam(":email", $email);
    $statement->execute();

    $user = $statement->fetch(PDO::FETCH_ASSOC);
    return $user;
}

function getUser(object $pdo, string $email)
{
    $query = "SELECT id FROM users WHERE email = :email;";
    $statement = $pdo->prepare($query);
    $statement->bindParam(":email", $email);
    $statement->execute();
    $userId = $statement->fetch(PDO::FETCH_ASSOC);
    return $userId;
}

function createUser(object $pdo, string $name, string $email, string $pwd)
{
    $query = "INSERT INTO users (name, email, pwd) VALUES (:name, :email, :pwd);";
    $statement = $pdo->prepare($query);
    $statement->bindParam(":name", $name);
    $statement->bindParam(":email", $email);
    $statement->bindParam(":pwd", $pwd);
    $statement->execute();
}

function uploadUserImage(object $pdo, string $image_url, string $user_id)
{
    $query = "INSERT INTO users_images (image_url, user_id) VALUES (:image_url, :user_id);";
    $statement = $pdo->prepare($query);
    $statement->bindParam(":image_url", $image_url);
    $statement->bindParam(":user_id", $user_id);
    $statement->execute();
}
