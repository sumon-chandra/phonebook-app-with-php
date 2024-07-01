<?php
require_once "db.php";

$searchPerformed = false;

try {
    $name = isset($_GET['name']) ? $_GET['name'] : '';
    $email = isset($_GET['email']) ? $_GET['email'] : '';
    $phone_number = isset($_GET['phone-number']) ? $_GET['phone-number'] : '';
    $address = isset($_GET['address']) ? $_GET['address'] : '';

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
