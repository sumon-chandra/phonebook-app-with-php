<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $phone = $_POST["phone"];
    $email = $_POST["email"];
    $address = $_POST["address"];
    $contactId = $_POST["id"];
    $age = $_POST["age"];
    $profession = $_POST["profession"];
    $gender = $_POST["gender"];

    // Validate form data
    if (empty($name) || empty($phone) || empty($email)) {
        die("All fields are required.");
    }

    // Update contact in the database
    try {
        require_once "./includes/db.php";
        $query = "UPDATE contacts SET name = :name, phone_number = :phone_number, email = :email, address = :address, age = :age, gender = :gender, profession = :profession WHERE id = :id;";
        $statement = $pdo->prepare($query);
        $statement->bindParam(":name", $name);
        $statement->bindParam(":phone_number", $phone);
        $statement->bindParam(":email", $email);
        $statement->bindParam(":address", $address);
        $statement->bindParam(":age", $age);
        $statement->bindParam(":gender", $gender);
        $statement->bindParam(":profession", $profession);
        $statement->bindParam(":id", $contactId, PDO::PARAM_INT);
        $statement->execute();

        $pdo = null;
        $statement = null;

        header("Location: ../../contacts.php");
    } catch (PDOException $error) {
        die("Something went wrong! Please try again" . $error->getMessage());
    }
} else {
    header("Location: ../../contacts.php");
}
