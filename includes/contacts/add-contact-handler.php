<?php

if ($_SERVER["REQUEST_METHOD"] =   "POST") {
    // Get form data
    $name = $_POST["name"];
    $phone = $_POST["phone"];
    $email = $_POST["email"];
    $address = $_POST["address"];
    $age = $_POST["age"];
    $profession = $_POST["profession"];
    $gender = $_POST["gender"];
    $blood_group = $_POST["blood_group"];

    // Validate form data
    if (empty($name) || empty($phone) || empty($email)) {
        die("All fields are required.");
    }

    try {
        require_once "db.php";

        session_start();
        $user_id = $_SESSION["user_id"];

        // Method 01: Non name parameter
        // $query = "INSERT INTO contacts (name, phone_number, email, address, avatar, user_id, age, profession, gender, blood_group) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        // $statement = $pdo->prepare($query);
        // $statement->execute([$name, $phone, $email, $address, null, $user_id, $age, $profession, $gender, $blood_group]);

        // Method 02: Name parameter
        $query = "INSERT INTO contacts (name, phone_number, email, address, avatar, user_id) VALUES (:name, :phone_number, :email, :address, :avatar, :user_id, :blood_group);";
        $statement = $pdo->prepare($query);
        $statement->bindParam(":name", $name);
        $statement->bindParam(":phone_number", $phone);
        $statement->bindParam(":email", $email);
        $statement->bindParam(":address", $address);
        $statement->bindParam(":avatar", $avatar);
        $statement->bindParam(":age", $age);
        $statement->bindParam(":user_id", $user_id);
        $statement->execute();

        $statement->bindParam(":profession", $profession);
        $statement->bindParam(":gender", $gender);
        $statement->bindParam(":blood_group", $blood_group);

        $pdo = null;
        $statement = null;

        echo "Contact added successfully.";
        header("Location:../contacts.php");
        exit();
    } catch (PDOException $error) {
        die("Something went wrong! Please try again" . $error->getMessage());
    }
} else {
    header("Location: ../index.php");
}
