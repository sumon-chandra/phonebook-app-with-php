<?php

function getUserById(object $pdo, string $id)
{
    $query = "SELECT * FROM users WHERE id = :id;";
    $statement = $pdo->prepare($query);
    $statement->bindParam(":id", $id);
    $statement->execute();
    $user = $statement->fetch(PDO::FETCH_ASSOC);
    return $user;
}

function updateUser(object $pdo, string $name, string $avatar, string $user_id)
{
    $query = "UPDATE users SET name = :name, avatar = :avatar WHERE id = :user_id;";
    $statement = $pdo->prepare($query);
    $statement->bindParam(":name", $name);
    $statement->bindParam(":avatar", $avatar);
    $statement->bindParam(":user_id", $user_id);
    $statement->execute();
}
