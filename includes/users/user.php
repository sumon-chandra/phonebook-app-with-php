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

require_once "user-model.php";
require_once "user-view.php";
require_once "user-contr.php";


$isLoggedIn = isset($_SESSION["user_id"]);
$user_id = $isLoggedIn ? $_SESSION["user_id"] : "";

// Check form submission for update users info  
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {

        $name = $_POST["name"];
        $image_file = $_FILES["image"]["name"];
        $avatar = "";

        if (!empty($image_file)) {
            $image_temp = $_FILES["image"]["tmp_name"];
            $allowed = ['jpg', 'jpeg', 'png', 'webp'];
            $ext = pathinfo($image_file, PATHINFO_EXTENSION);
            $image_url = "user_" . $user_id . "_" . $image_file;
            $target_path = "../../uploads/users/" . $image_url;
            // Update user image
            if (!empty($image_file) && in_array($ext, $allowed)) {
                move_uploaded_file($image_temp, $target_path);
                $avatar = $image_url;
            }
        }

        updateUser($pdo, $name, $avatar, $user_id);

        header("Location: ../../profile.php");
    } catch (PDOException $error) {
        die("An error occurred while updating the user info! " . $error->getMessage());
    }
} else {
    // Get user data
    try {
        $user = getUserById($pdo, $user_id);
    } catch (PDOException $error) {
        die("An error occurred while getting the user! " . $error->getMessage());
    }
}
