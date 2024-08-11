<?php

function isPhoneNumberExist(object | null $pdo, string $phone)
{
    $contact_number = isPhoneNumberFound($pdo, $phone);
    return $contact_number;
}

function deleteContactImageIfExists(string | null $image_url)
{
    if (!empty($image_url) && file_exists("../../uploads/contacts/" . $image_url)) {
        unlink("../../uploads/contacts/" . $image_url);
    }
}
