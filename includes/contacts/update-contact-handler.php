<?php
require_once "../config-session.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $phone = $_POST["phone"];
    $email = $_POST["email"];
    $address = $_POST["address"];
    $contactId = $_POST["id"];
    $age = $_POST["age"];
    $dob = $_POST["dob"];
    $profession = $_POST["profession"];
    $gender = $_POST["gender"];
    $blood_group = $_POST["blood_group"];

    // Validate form data
    if (empty($name) || empty($phone) || empty($email) || empty($dob)) {
        die("Name, phone, email and date of birth are required.");
    }

    // Update contact in the database
    try {
        require_once "../db.php";

        // Update contact
        $query = "UPDATE contacts SET name = :name, phone_number = :phone_number, email = :email, address = :address, age = :age, dob = :dob WHERE id = :id;";
        $statement = $pdo->prepare($query);
        $statement->bindParam(":name", $name);
        $statement->bindParam(":phone_number", $phone);
        $statement->bindParam(":email", $email);
        $statement->bindParam(":address", $address);
        $statement->bindParam(":age", $age);
        $statement->bindParam(":dob", $dob);
        $statement->bindParam(":id", $contactId, PDO::PARAM_INT);
        $statement->execute();

        // Update gender
        $query = "UPDATE genders SET gender = :gender WHERE contact_id = :contact_id;";
        $statement = $pdo->prepare($query);
        $statement->bindParam(":gender", $gender);
        $statement->bindParam(":contact_id", $contactId, PDO::PARAM_INT);
        $statement->execute();

        // Update profession
        $query = "UPDATE professions SET profession = :profession WHERE contact_id = :contact_id;";
        $statement = $pdo->prepare($query);
        $statement->bindParam(":profession", $profession);
        $statement->bindParam(":contact_id", $contactId, PDO::PARAM_INT);
        $statement->execute();

        // Update blood_group
        $query = "UPDATE blood_groups SET blood_group = :blood_group WHERE contact_id = :contact_id;";
        $statement = $pdo->prepare($query);
        $statement->bindParam(":blood_group", $blood_group);
        $statement->bindParam(":contact_id", $contactId, PDO::PARAM_INT);
        $statement->execute();

        // Close database connection
        $pdo = null;
        $statement = null;

        // Redirect to previous page
        $previousPage = $_SESSION["current_page"];
        header("Location: $previousPage");
    } catch (PDOException $error) {
        // header("Location: ../../update-contact.php?id=$contactId");
        die("Something went wrong! Please try again" . $error->getMessage());
    }
} else {
    header("Location: ../../contacts.php");
}
