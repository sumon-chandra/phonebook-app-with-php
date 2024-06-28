<?php
require_once "db.php";

$contactId = $_GET["id"];

try {
    $query = "DELETE FROM contacts WHERE id = :id";
    $statement = $pdo->prepare($query);
    $statement->bindParam(":id", $contactId);
    $statement->execute();
    header("Location: ../index.php");
} catch (PDOException $error) {
    die("Something went wrong! Please try again" . $error->getMessage());
    header("Location: ../index.php");
}
