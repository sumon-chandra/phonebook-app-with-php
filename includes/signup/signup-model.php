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

function createUser(object $pdo, string $name, string $email, string $hashed_pwd, string $avatar)
{
    $query = "INSERT INTO users (name, email, hashed_pwd, avatar) VALUES (:name, :email, :hashed_pwd, :avatar);";
    $statement = $pdo->prepare($query);
    $statement->bindParam(":name", $name);
    $statement->bindParam(":email", $email);
    $statement->bindParam(":hashed_pwd", $hashed_pwd);
    $statement->bindParam(":avatar", $avatar);
    $statement->execute();
}
