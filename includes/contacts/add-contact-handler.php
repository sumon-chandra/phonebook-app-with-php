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
    $dob = $_POST["dob"];
    $district_id = $_POST["district"];
    $profession_id = $_POST["profession"];
    $gender_id = $_POST["gender"];
    $blood_group_id = $_POST["blood_group"];
    $contact_image = "";

    // Error handling
    $errors = [];

    // Validate form data
    if (empty($name) || empty($phone) || empty($email) || empty($dob)) {
        $errors["invalid_inputs"] = "Name, phone, email and date of birth are required.";
        die();
    }
    try {
        //code...


        $isLoggedIn = isset($_SESSION["user_id"]);
        $user_id = $isLoggedIn ? $_SESSION["user_id"] : "";

        // Check if contact already exists
        if (!isPhoneNumberExist($pdo, $phone)) {
            // Upload contact image file 
            $imageName = $_FILES["image"]["name"];
            if (!empty($imageName)) {
                $allowed = ['jpg', 'jpeg', 'png', 'webp'];
                $image_temp = $_FILES["image"]["tmp_name"];
                $ext = pathinfo($imageName, PATHINFO_EXTENSION);
                $imageUrl = "contact_" . $imageName;
                $targetPath = "../../uploads/contacts/" . $imageUrl;

                if (!empty($imageName)) {
                    if (in_array($ext, $allowed)) {
                        $contactImg = move_uploaded_file($image_temp, $targetPath);
                        if ($contactImg) {
                            $contact_image = $imageUrl;
                        }
                    }
                }
            }

            // Insert data into database
            insertContact($pdo, $name, $email, $phone, $contact_image, $dob, $user_id, $gender_id, $district_id, $blood_group_id, $profession_id);
        } else {
            $errors["number_exist"] = "Phone number already exists. Try different phone number!";
        }

        if ($errors) {
            $_SESSION["add_contact_errors"] = $errors;
            header("Location:../../add-contact.php");
            die();
        }

        // Close database connection
        $pdo = null;
        $statement = null;
        // Redirect to contacts page with success message
        header("Location:../../contacts.php");
        die();
    } catch (PDOException $error) {
        echo "Failed to add contact : " . $error->getMessage();
        die();
    }
} else {
    header("Location: ../../contacts.php");
    die();
}
