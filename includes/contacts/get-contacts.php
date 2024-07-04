<?php

$searchPerformed = false;

try {
    require_once "./includes/db.php";
    $name = isset($_GET['name']) ? $_GET['name'] : '';
    $email = isset($_GET['email']) ? $_GET['email'] : '';
    $phone_number = isset($_GET['phone-number']) ? $_GET['phone-number'] : '';
    $address = isset($_GET['address']) ? $_GET['address'] : '';
    $age = isset($_GET['age']) ? $_GET['age'] : '';
    $gender = isset($_GET['gender']) ? $_GET['gender'] : '';
    $profession = isset($_GET['profession']) ? $_GET['profession'] : '';

    // Conditions and parameters
    $query = "SELECT * FROM contacts";
    $conditions = [];
    $parameters = [];
    if ($name) {
        $conditions[] = "name LIKE :name";
        $parameters[":name"] = "%" . $name . "%";
        $searchPerformed = true;
    }
    if ($email) {
        $conditions[] = "email LIKE :email";
        $parameters[":email"] = "%" . $email . "%";
        $searchPerformed = true;
    }
    if ($phone_number) {
        $conditions[] = "phone_number LIKE :phone_number";
        $parameters[":phone_number"] = "%" . $phone_number . "%";
        $searchPerformed = true;
    }
    if ($address) {
        $conditions[] = "address LIKE :address";
        $parameters[":address"] = "%" . $address . "%";
        $searchPerformed = true;
    }
    if ($age) {
        $conditions[] = "age = :age";
        $parameters[":age"] = $age;
        $searchPerformed = true;
    }
    if ($gender) {
        $conditions[] = "gender = :gender";
        $parameters[":gender"] = $gender;
        $searchPerformed = true;
    }
    if ($profession) {
        $conditions[] = "profession = :profession";
        $parameters[":profession"] = $profession;
        $searchPerformed = true;
    }

    if ($conditions) {
        $query .= " WHERE " . implode(" AND ", $conditions);
        $statement = $pdo->prepare($query);
        $statement->execute($parameters);
        // Fetching all contacts
        $data = $statement->fetchAll(PDO::FETCH_ASSOC);
    } else {
        if (isset($_SESSION["user_id"])) {
            $user_id = $_SESSION["user_id"];
            $query = "SELECT * FROM contacts WHERE user_id = $user_id";
            $statement = $pdo->prepare($query);
            $statement->execute();
            // Fetching all contacts
            $data = $statement->fetchAll(PDO::FETCH_ASSOC);
        }
    }

    // if ($name || $email || $phone_number || $address) {
    //     // Getting contacts by search item from the database
    //     $query = "SELECT * FROM contacts WHERE name LIKE :search";

    // } 
} catch (PDOException $error) {
    die("Failed to load contacts" . $error->getMessage());
}
