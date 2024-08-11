<?php

declare(strict_types=1);

function displayErrors($status)
{
    if ($status == "update") {
        $isError = isset($_SESSION["update_contact_errors"]);
        if ($isError) {
            $errors = $_SESSION["update_contact_errors"];
            echo "<br/>";
            foreach ($errors as $error) {
                echo "<p class='text-sm text-center font-semibold text-red-600'>$error</p>";
            }
        }
    } else {
        $isError = isset($_SESSION["add_contact_errors"]);
        if ($isError) {
            $errors = $_SESSION["add_contact_errors"];
            echo "<br/>";
            foreach ($errors as $error) {
                echo "<p class='text-sm text-center font-semibold text-red-600'>$error</p>";
            }
        }
    }
}
