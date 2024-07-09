<?php

function displayErrors()
{
    $isError = isset($_SESSION["add_contact_errors"]);
    if ($isError) {
        $errors = $_SESSION["add_contact_errors"];
        foreach ($errors as $error) {
            echo "<p class='text-xs text-center font-semibold text-red-600'>$error</p>";
        }
    }
}
