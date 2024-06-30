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

function createUser(object $pdo, string $name, string $email, string $pwd)
{
    $options = [
        'cost' => 12, // Bcrypt algorithm level, higher the value, more secure the password
    ];
    $hashedPwd = password_hash($pwd, PASSWORD_BCRYPT, $options);
    $query = "INSERT INTO users (name, email, pwd) VALUES (:name, :email, :pwd);";
    $statement = $pdo->prepare($query);
    $statement->bindParam(":name", $name);
    $statement->bindParam(":email", $email);
    $statement->bindParam(":pwd", $hashedPwd);
    $statement->execute();
}
