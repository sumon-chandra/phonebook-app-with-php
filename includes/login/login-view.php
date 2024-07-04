<?php

declare(strict_types=1);

function checkLoginErrors()
{
    if (isset($_SESSION["login_error"])) {
        $errors = $_SESSION["login_error"];
        echo "<br/>";
        foreach ($errors as $error) {
            echo "<p style='color: red;'>$error</p>";
        }
    } else if (isset($_GET["login"]) && $_GET["login"] == "success") {
        echo "<p style='color: green;'>Login successful. Please log in.</p>";
    }
}
