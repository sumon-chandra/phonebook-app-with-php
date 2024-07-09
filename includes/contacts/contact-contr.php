<?php

function isPhoneNumberExist(object | null $pdo, string $phone)
{
    $isLoggedIn = isset($_SESSION["user_id"]);
    $user_id = $isLoggedIn ? $_SESSION["user_id"] : "";
    $contact = getContactByPhone($pdo, $phone);
    $contactPhoneNumber = isset($contact["phone_number"]) ? $contact["phone_number"] : "";
    if (!empty($contactPhoneNumber) && ($user_id == $contact["user_id"])) {
        return true;
    } else {
        return false;
    }
}

function deleteContactImageIfExists(string | null $image_url)
{
    if (!empty($image_url) && file_exists("../../uploads/contacts/" . $image_url)) {
        unlink("../../uploads/contacts/" . $image_url);
    }
}
