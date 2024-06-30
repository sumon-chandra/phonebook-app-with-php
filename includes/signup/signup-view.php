<?php

declare(strict_types=1);

function displayErrors()
{
    if (isset($_SESSION["signup_error"])) {
        $errors = $_SESSION["signup_error"];
        echo "<br/>";
        foreach ($errors as $error) {
            echo "<p style='color: red;'>$error</p>";
        }
        unset($_SESSION["signup_error"]);
    } else if (isset($_GET["signup"]) && $_GET["signup"] == "success") {
        echo "<p style='color: green;'>Signup successful. Please log in.</p>";
    }
};
