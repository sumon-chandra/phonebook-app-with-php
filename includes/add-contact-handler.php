<?php

if ($_SERVER["REQUEST_METHOD"] =   "POST") {
    // Get form data
    $name = $_POST["name"];
    $phone = $_POST["phone"];
    $email = $_POST["email"];
    $address = $_POST["address"];

    // Validate form data
    if (empty($name) || empty($phone) || empty($email)) {
        die("All fields are required.");
    }

    try {
        require_once "db.php";

        // Method 01: Non name parameter
        $query = "INSERT INTO contacts (name, phone_number, email, address) VALUES (?, ?, ?, ?);";

        $statement = $pdo->prepare($query);
        $statement->execute([$name, $phone, $email, $address]);

        // Method 02: Name parameter
        // $query = "INSERT INTO contacts (name, phone_number, email, address) VALUES (:name, :phone_number, :email, :address);";
        // $statement = $pdo->prepare($query);
        // $statement->bindParam(":name", $name);
        // $statement->bindParam(":phone_number", $phone);
        // $statement->bindParam(":email", $email);
        // $statement->bindParam(":address", $address);

        // $statement->execute();

        $pdo = null;
        $statement = null;

        echo "Contact added successfully.";
        header("Location:../index.php");
        exit();
    } catch (PDOException $error) {
        die("Something went wrong! Please try again" . $error->getMessage());
    }
} else {
    header("Location: ../index.php");
}
