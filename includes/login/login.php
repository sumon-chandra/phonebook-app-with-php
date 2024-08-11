<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $pwd = $_POST['password'];


    try {
        require_once "../db.php";
        require_once "login-model.php";
        require_once "login-contr.php";
        // require_once "../config-session.php";

        // Error handling
        $errors = [];
        if (isInputEmpty($pwd, $email)) {
            $errors["Input_empty"] = "Fill the all fields!";
        }

        $user = getUser($pdo, $email);

        if (!$user) {
            echo "User not found";
            $errors["invalid_user"] = "User not found!";
        } else {
            // echo "User: " . $user["pwd"];
            if (isEmailWrong($user)) {
                $errors["invalid_email"] = "Invalid Email!";
            }
            if (isPwdWrong($user['hashed_pwd'], $pwd)) {
                $errors["invalid_password"] = "Invalid password!";
            }
        }

        $newSessionId = session_create_id();
        $sessionId = $newSessionId . "_" . $user["id"];
        session_id($sessionId);
        require_once "../config-session.php";


        if ($errors) {
            $_SESSION["login_error"] = $errors;
            header('Location:../../login.php');
            die();
        }

        // Login the user
        $_SESSION["user_id"] = $user["id"];

        $pdo = null;
        $statement = null;

        $_SESSION["last_regeneration_time"] = time();

        $pdo = null;
        $statement = null;

        header('Location: ../../contacts.php?login=success');
        die();
    } catch (PDOException $error) {
        die("An error occurred" . $error->getMessage());
    }
} else {
    header('Location: ../../contacts.php');
    die();
}
