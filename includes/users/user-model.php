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

function getUserImageById(object $pdo, string $user_id)
{
    $query = "SELECT * FROM users_images WHERE user_id = :user_id;";
    $statement = $pdo->prepare($query);
    $statement->bindParam(":user_id", $user_id);
    $statement->execute();
    $userImage = $statement->fetch(PDO::FETCH_ASSOC);
    return isset($userImage["image_url"]) ? $userImage["image_url"] : null;
}

function updateUserName(object $pdo, string $name, string $user_id)
{
    $query = "UPDATE users SET name = :name WHERE id = :user_id;";
    $statement = $pdo->prepare($query);
    $statement->bindParam(":name", $name);
    $statement->bindParam(":user_id", $user_id);
    $statement->execute();
}


function updateUserImage(object $pdo, string $image_url, string $user_id)
{
    $query = "UPDATE users_images SET image_url = :image_url WHERE user_id = :user_id;";
    $statement = $pdo->prepare($query);
    $statement->bindParam(":image_url", $image_url);
    $statement->bindParam(":user_id", $user_id);
    $statement->execute();
}

function insertUserImage(object $pdo, string $image_url, string $user_id)
{
    $query = "INSERT INTO users_images (image_url, user_id) VALUES (:image_url, :user_id);";
    $statement = $pdo->prepare($query);
    $statement->bindParam(":image_url", $image_url);
    $statement->bindParam(":user_id", $user_id);
    $statement->execute();
}
