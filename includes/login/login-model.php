<?php

declare(strict_types=1);

function getUser(object $pdo, string $email)
{
    // echo "Hello, $email";
    $query = "SELECT * FROM users WHERE email = :email;";
    $statement = $pdo->prepare($query);
    $statement->bindParam(":email", $email);
    $statement->execute();

    $user = $statement->fetch(PDO::FETCH_ASSOC);
    return $user;
}
