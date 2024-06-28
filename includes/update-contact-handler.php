<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $phone = $_POST["phone"];
    $email = $_POST["email"];
    $address = $_POST["address"];
    $contactId = $_POST["id"];

    // echo $contactId;

    // Validate form data
    if (empty($name) || empty($phone) || empty($email)) {
        die("All fields are required.");
    }

    // Update contact in the database
    try {
        require_once "db.php";

        $query = "UPDATE contacts SET name = :name, phone_number = :phone_number, email = :email, address = :address WHERE id = :id;";
        $statement = $pdo->prepare($query);
        $statement->bindParam(":name", $name);
        $statement->bindParam(":phone_number", $phone);
        $statement->bindParam(":email", $email);
        $statement->bindParam(":address", $address);
        $statement->bindParam(":id", $contactId, PDO::PARAM_INT);
        $statement->execute();

        $pdo = null;
        $statement = null;

        header("Location: ../index.php");
    } catch (PDOException $error) {
        die("Something went wrong! Please try again" . $error->getMessage());
    }
} else {
    header("Location: ../index.php");
}
