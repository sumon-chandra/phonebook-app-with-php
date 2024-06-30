<?php

declare(strict_types=1);

function isInputEmpty(string $name, string $pwd, string $email)
{
    if (empty($name) || empty($pwd) || empty($email)) {
        return true;
    } else {
        return false;
    }
}

function isEmailInvalid(string $email)
{
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return true;
    } else {
        return false;
    }
}

function isEmailExist(object $pdo, string $email)
{
    if (getEmail($pdo, $email)) {
        return true;
    } else {
        return false;
    }
}
