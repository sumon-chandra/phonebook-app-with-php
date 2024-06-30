<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $pwd = $_POST['password'];


    try {
        require_once "../db.php";
        require_once "login-model.php";
        require_once "login-contr.php";

        // Error handling
        $errors = [];
        if (isInputEmpty($pwd, $email)) {
            $errors["Input_empty"] = "Fill the all fields!";
        }

        $user = getUser($pdo, $email);
        // getUser($pdo, $email);
        // echo "Email: " . $user["email"];
        echo "Password: " . $user["pwd"];

        if (!$user) {
            // echo "User not found";
            $errors["invalid_login"] = "User not found!";
        }
        if (isEmailWrong($user)) {
            $errors["invalid_login"] = "Invalid Email!";
        }
        if (isPwdWrong($pwd, $user["pwd"])) {
            $errors["invalid_login"] = "Invalid password!";
        }

        require_once "../config-session.php";

        if ($errors) {
            // echo "Error";
            $_SESSION["login_error"] = $errors;
            header('Location:../../login.php');
            die();
        }

        $newSessionId = session_create_id();
        $sessionId = $newSessionId . "_" . $user["id"];
        session_id($sessionId);

        // Login the user
        $_SESSION["user_id"] = $user["id"];
        $_SESSION["email"] = $user["email"];

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
