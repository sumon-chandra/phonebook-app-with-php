<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $pwd = $_POST['password'];

    try {
        require_once "../db.php";
        require_once "../signup/signup-model.php";
        require_once "../signup/signup-contr.php";

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

        $pdo = null;
        $statement = null;

        header('Location: ../../index.php?signup=success');
        die();
    } catch (PDOException $error) {
        die("An error occurred" . $error->getMessage());
    }
} else {
    header('Location: ../../index.php');
    die();
}
