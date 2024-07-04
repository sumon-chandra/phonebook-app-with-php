<?php

declare(strict_types=1);

function isInputEmpty(string $pwd, string $email)
{
    if (empty($pwd) || empty($email)) {
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

function isEmailWrong(bool|array $user)
{
    if (!$user) {
        return true;
    } else {
        return false;
    }
}

function isPwdWrong(string $userPwd, string $password)
{
    if ($userPwd != $password) {
        return true;
    } else {
        return false;
    }
}
