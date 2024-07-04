<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {  // Corrected the equality operator
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
        die("Name, phone, and email are required.");
    }

    try {
        require_once "../db.php";

        session_start();
        $user_id = $_SESSION["user_id"];

        // Insert into contacts table
        $query = "INSERT INTO contacts (name, phone_number, email, address, avatar, age, user_id) VALUES (:name, :phone_number, :email, :address, :avatar, :age, :user_id);";
        $statement = $pdo->prepare($query);
        $statement->bindParam(":name", $name);
        $statement->bindParam(":phone_number", $phone);
        $statement->bindParam(":email", $email);
        $statement->bindParam(":address", $address);

        // Assuming avatar is not being uploaded, setting it to null
        $avatar = null;
        $statement->bindParam(":avatar", $avatar);

        $statement->bindParam(":age", $age);
        $statement->bindParam(":user_id", $user_id);
        $statement->execute();

        // Get the contact info just inserted to use for other tables
        $query = "SELECT * FROM contacts WHERE email = :email;";
        $statement = $pdo->prepare($query);
        $statement->bindParam(":email", $email);
        $statement->execute();
        $contact = $statement->fetch(PDO::FETCH_ASSOC);

        // Insert into professions table
        $query = "INSERT INTO professions (profession, contact_id) VALUES (:profession, :contact_id);";
        $statement = $pdo->prepare($query);
        $statement->bindParam(":profession", $profession);
        $statement->bindParam(":contact_id", $contact["id"]);
        $statement->execute();

        // Insert into genders table
        $query = "INSERT INTO genders (gender, contact_id) VALUES (:gender, :contact_id);";
        $statement = $pdo->prepare($query);
        $statement->bindParam(":gender", $gender);
        $statement->bindParam(":contact_id", $contact["id"]);
        $statement->execute();

        // Insert into blood_groups table
        $query = "INSERT INTO blood_groups (blood_group, contact_id) VALUES (:blood_group, :contact_id);";
        $statement = $pdo->prepare($query);
        $statement->bindParam(":blood_group", $blood_group);
        $statement->bindParam(":contact_id", $contact["id"]);
        $statement->execute();

        // Clean up
        $pdo = null;
        $statement = null;

        // Redirect to contacts page
        header("Location: ../../contacts.php");
        exit();
    } catch (PDOException $error) {
        die("Something went wrong! Please try again. " . $error->getMessage());
    }
} else {
    header("Location: ../../contacts.php");
}
