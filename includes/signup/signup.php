<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $pwd = $_POST['password'];

    try {
        require_once "../db.php";
        require_once "signup-model.php";
        require_once "signup-contr.php";

        // Error handling
        $errors = [];
        if (isInputEmpty($name, $pwd, $email)) {
            $errors["Input_empty"] = "Fill the all fields!";
        }
        if (isEmailInvalid($email)) {
            $errors["invalid_email"] = "Invalid email address!";
        }
        if (isEmailExist($pdo, $email)) {
            $errors["email_exist"] = "Email already exists!";
        }

        require_once "../config-session.php";

        if ($errors) {
            $_SESSION["signup_error"] = $errors;
            header('Location:../../signup.php');
            die();
        }

        // Register the user
        createUser($pdo, $name, $email, $pwd);

        // Get user_id
        $user = getUser($pdo, $email);

        // Upload user image file
        $image_name = $_FILES['image']['name'];
        $image_temp = $_FILES['image']['tmp_name'];
        $allowed = ['jpg', 'png', 'jpeg'];
        $ext = pathinfo($image_name, PATHINFO_EXTENSION);
        $image_url = "user_" . $user["id"] . "_" . $image_name;
        $target_path = "../../uploads/users/" . $image_url;

        // Upload user image file
        if (in_array($ext, $allowed)) {
            $movedImage = move_uploaded_file($image_temp, $target_path);
            if ($movedImage) {
                uploadUserImage($pdo, $image_url, $user["id"]);
            }
        };

        $pdo = null;
        $statement = null;

        header('Location: ../../login.php?signup=success');
        die();
    } catch (PDOException $error) {
        die("An error occurred" . $error->getMessage());
    }
} else {
    header('Location: ../../index.php');
    die();
}
