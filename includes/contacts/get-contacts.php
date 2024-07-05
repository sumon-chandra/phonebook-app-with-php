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
    $blood_group = isset($_GET['blood_group']) ? $_GET['blood_group'] : '';

    // Conditions and parameters
    $query = "
    SELECT contacts.*, genders.gender, professions.profession, blood_groups.blood_group FROM contacts
    LEFT JOIN genders ON contacts.id = genders.contact_id
    LEFT JOIN professions ON contacts.id = professions.contact_id
    LEFT JOIN blood_groups ON contacts.id = blood_groups.contact_id
    ";

    $conditions = [];
    $parameters = [];

    if ($name) {
        $conditions[] = "contacts.name LIKE :name";
        $parameters[":name"] = "%" . $name . "%";
        $searchPerformed = true;
    }
    if ($email) {
        $conditions[] = "contacts.email LIKE :email";
        $parameters[":email"] = "%" . $email . "%";
        $searchPerformed = true;
    }
    if ($phone_number) {
        $conditions[] = "contacts.phone_number LIKE :phone_number";
        $parameters[":phone_number"] = "%" . $phone_number . "%";
        $searchPerformed = true;
    }
    if ($address) {
        $conditions[] = "contacts.address LIKE :address";
        $parameters[":address"] = "%" . $address . "%";
        $searchPerformed = true;
    }
    if ($age) {
        $conditions[] = "contacts.age = :age";
        $parameters[":age"] = $age;
        $searchPerformed = true;
    }
    if ($gender) {
        $conditions[] = "genders.gender = :gender";
        $parameters[":gender"] = $gender;
        $searchPerformed = true;
    }
    if ($profession) {
        $conditions[] = "professions.profession = :profession";
        $parameters[":profession"] = $profession;
        $searchPerformed = true;
    }
    if ($blood_group) {
        $conditions[] = "blood_groups.blood_group = :blood_group";
        $parameters[":blood_group"] = $blood_group;
        $searchPerformed = true;
    }

    if (isset($_SESSION["user_id"])) {
        $user_id = $_SESSION["user_id"];
        if ($conditions) {
            $query .= " WHERE " . implode(" AND ", $conditions) . " AND user_id = " . $user_id . " ORDER BY created_at DESC";
            $statement = $pdo->prepare($query);
            $statement->execute($parameters);
            $data = $statement->fetchAll(PDO::FETCH_ASSOC);
        } else {
            $query = "SELECT * FROM contacts WHERE user_id = $user_id ORDER BY created_at DESC;";
            $statement = $pdo->prepare($query);
            $statement->execute();
            $data = $statement->fetchAll(PDO::FETCH_ASSOC);
        }
    }
} catch (PDOException $error) {
    die("Failed to load contacts" . $error->getMessage());
}
