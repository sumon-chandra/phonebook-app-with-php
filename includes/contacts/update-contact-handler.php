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

    // Error handling
    $errors = [];

    // Validate form data
    if (empty($name) || empty($phone) || empty($email) || empty($dob)) {
        $errors["invalid_inputs"] = "Name, phone, email and date of birth are required.";
        die();
    }

    $isLoggedIn = isset($_SESSION["user_id"]);
    $user_id = $isLoggedIn ? $_SESSION["user_id"] : "";

    try {

        // Get contacts_image table for update image_url
        $imageUrl = getContactImageById($pdo, $contactId);

        // Upload new image if provided
        if (!empty($_FILES["image"]["name"])) {
            deleteContactImageIfExists($imageUrl);

            // Set new image path
            $imageName = $_FILES["image"]["name"];
            $allowed = ['jpg', 'jpeg', 'png', 'webp'];
            $image_temp = $_FILES["image"]["tmp_name"];
            $ext = pathinfo($imageName, PATHINFO_EXTENSION);
            $newImageUrl = "image_" . $contactId . "_" . $imageName;
            $targetPath = "../../uploads/contacts/" . $imageUrl;

            // Update the image_url from contacts_images table
            if (in_array($ext, $allowed)) {
                $movedImage = move_uploaded_file($image_temp, $targetPath);
                if ($movedImage) {
                    updateContactImage($pdo, $contactId, $newImageUrl);
                };
            }
        }

        // Update contact information
        updateContact($pdo, $name, $email, $phone, $address, $age, $dob, $contactId);
        updateGender($pdo, $gender, $contactId);
        updateProfession($pdo, $profession, $contactId);
        updateBloodGroup($pdo, $blood_group, $contactId);

        // Close database connection
        $pdo = null;
        $statement = null;

        // Redirect to previous page
        $previousPage = $_SESSION["current_page"];
        header("Location: $previousPage");
    } catch (PDOException $error) {
        header("Location: ../../update-contact.php?id=$contactId");
        die("Something went wrong! Please try again" . $error->getMessage());
    }
} else {
    header("Location: ../../contacts.php");
}
