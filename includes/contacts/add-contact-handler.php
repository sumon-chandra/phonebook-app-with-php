<?php
// Define the absolute path to the db.php file
$dbPath = dirname(__DIR__) . '/db.php';
$configPath = dirname(__DIR__) . '/config-session.php';

if (file_exists($dbPath) && file_exists($configPath)) {
    require_once $dbPath;
    require_once $configPath;
} else {
    die("Error: db.php or config file not found at " . $dbPath . " " . $configPath);
}

require_once "contact-model.php";
require_once "contact-view.php";
require_once "contact-contr.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $name = $_POST["name"];
    $phone = $_POST["phone"];
    $email = $_POST["email"];
    $address = $_POST["address"];
    $age = $_POST["age"];
    $profession = $_POST["profession"];
    $gender = $_POST["gender"];
    $blood_group = $_POST["blood_group"];
    $dob = $_POST["dob"];

    // Error handling
    $errors = [];

    // Validate form data
    if (empty($name) || empty($phone) || empty($email) || empty($dob)) {
        $errors["invalid_inputs"] = "Name, phone, email and date of birth are required.";
        die();
    }

    $isLoggedIn = isset($_SESSION["user_id"]);
    $user_id = $isLoggedIn ? $_SESSION["user_id"] : "";

    // Check if contact already exists
    if (!isPhoneNumberExist($pdo, $phone)) {

        // Insert data into database
        $newContactId = insertContact($pdo, $name, $phone, $email, $address, $age, $dob, $user_id);

        // Upload contact image file 
        $imageName = $_FILES["image"]["name"];
        $allowed = ['jpg', 'jpeg', 'png', 'webp'];
        $image_temp = $_FILES["image"]["tmp_name"];
        $ext = pathinfo($imageName, PATHINFO_EXTENSION);
        $imageUrl = "image_" . $newContactId . "_" . $imageName;
        $targetPath = "../../uploads/contacts/" . $imageUrl;

        insertProfession($pdo, $profession, $newContactId);
        insertGender($pdo, $gender, $newContactId);
        insertBloodGroup($pdo, $blood_group, $newContactId);

        if (!empty($imageName)) {
            if (in_array($ext, $allowed)) {
                move_uploaded_file($image_temp, $targetPath);
                insertContactImage($pdo, $imageUrl, $newContactId);
            }
        }
    } else {
        header("Location:../../add-contact.php");
        $errors["number_exist"] = "Phone number already exists. Try different phone number!";
        die();
    }

    if ($errors) {
        $_SESSION["add_contact_errors"] = $errors;
        header("Location:../../add-contact.php");
        die();
    }

    // Redirect to contacts page with success message
    header("Location:../../contacts.php");
} else {
    header("Location: ../../contacts.php");
}
