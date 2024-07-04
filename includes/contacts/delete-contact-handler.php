<?php

$contactId = $_GET["id"];

try {
    require_once "../db.php";

    // Delete from contacts table
    $query = "DELETE FROM contacts WHERE id = :id";
    $statement = $pdo->prepare($query);
    $statement->bindParam(":id", $contactId);
    $statement->execute();

    // Delete from genders table
    $query = "DELETE FROM genders WHERE id = :id";
    $statement = $pdo->prepare($query);
    $statement->bindParam(":id", $contactId);
    $statement->execute();

    // Delete from professions table
    $query = "DELETE FROM professions WHERE id = :id";
    $statement = $pdo->prepare($query);
    $statement->bindParam(":id", $contactId);
    $statement->execute();

    header("Location: ../../contacts.php");
} catch (PDOException $error) {
    die("Something went wrong! Please try again" . $error->getMessage());
    header("Location: ../../contacts.php");
}
