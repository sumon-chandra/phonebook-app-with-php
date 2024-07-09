<?php

// Get the contact
function getContactByPhone(object $pdo, string $phone_number)
{
    $query = "SELECT * FROM contacts WHERE phone_number = :phone_number;";
    $statement = $pdo->prepare($query);
    $statement->bindParam(":phone_number", $phone_number);
    $statement->execute();
    $contact = $statement->fetch(PDO::FETCH_ASSOC);
    return $contact;
}
function getContactById(object $pdo, string $contactId)
{
    $query = "SELECT * FROM contacts WHERE id = :id;";
    $statement = $pdo->prepare($query);
    $statement->bindParam(":id", $contactId);
    $statement->execute();
    $contact = $statement->fetch(PDO::FETCH_ASSOC);
    return $contact;
}

function getProfessionById(object $pdo, string $contactId)
{
    $query = "SELECT * FROM professions WHERE contact_id = :contact_id;";
    $statement = $pdo->prepare($query);
    $statement->bindParam(":contact_id", $contactId);
    $statement->execute();
    $profession = $statement->fetch(PDO::FETCH_ASSOC);
    return isset($profession["profession"]) ? $profession["profession"] : "";
};

function getGenderById(object $pdo, string $contactId)
{
    $query = "SELECT * FROM genders WHERE contact_id = :contact_id;";
    $statement = $pdo->prepare($query);
    $statement->bindParam(":contact_id", $contactId);
    $statement->execute();
    $gender = $statement->fetch(PDO::FETCH_ASSOC);
    return isset($gender["gender"]) ? $gender["gender"] : "";
}

function getBloodGroupById(object $pdo, string $contactId)
{
    $query = "SELECT * FROM blood_groups WHERE contact_id = :contact_id;";
    $statement = $pdo->prepare($query);
    $statement->bindParam(":contact_id", $contactId);
    $statement->execute();
    $bloodGroup = $statement->fetch(PDO::FETCH_ASSOC);
    return isset($bloodGroup["blood_group"]) ? $bloodGroup["blood_group"] : "";
}

function insertContact(object $pdo, string $name, string $phone_number, string $email, string $address, string $age, string $dob, string $user_id)
{
    $query = "INSERT INTO contacts (name, phone_number, email, address, age, dob, user_id) VALUES (:name, :phone_number, :email, :address, :age, :dob, :user_id);";
    $statement = $pdo->prepare($query);
    $statement->bindParam(":name", $name);
    $statement->bindParam(":phone_number", $phone_number);
    $statement->bindParam(":email", $email);
    $statement->bindParam(":address", $address);
    $statement->bindParam(":age", $age);
    $statement->bindParam(":dob", $dob);
    $statement->bindParam(":user_id", $user_id);
    $statement->execute();
    $newContactId = $pdo->lastInsertId();
    return $newContactId;
}

function insertProfession(object $pdo, string $profession, int $contactId)
{
    $query = "INSERT INTO professions (profession, contact_id) VALUES (:profession, :contact_id);";
    $statement = $pdo->prepare($query);
    $statement->bindParam(":profession", $profession);
    $statement->bindParam(":contact_id", $contactId);
    $statement->execute();
}

function insertGender(object $pdo, string $gender, int $contactId)
{
    $query = "INSERT INTO genders (gender, contact_id) VALUES (:gender, :contact_id);";
    $statement = $pdo->prepare($query);
    $statement->bindParam(":gender", $gender);
    $statement->bindParam(":contact_id", $contactId);
    $statement->execute();
}

function insertBloodGroup(object $pdo, string $bloodGroup, int $contactId)
{
    $query = "INSERT INTO blood_groups (blood_group, contact_id) VALUES (:blood_group, :contact_id);";
    $statement = $pdo->prepare($query);
    $statement->bindParam(":blood_group", $bloodGroup);
    $statement->bindParam(":contact_id", $contactId);
    $statement->execute();
}

function insertContactImage(object | null $pdo, string $imageUrl, string $contactId)
{
    $query = "INSERT INTO contacts_images (image_url, contact_id) VALUES (:image_url, :contact_id);";
    $statement = $pdo->prepare($query);
    $statement->bindParam(":image_url", $imageUrl);
    $statement->bindParam(":contact_id", $contactId);
    $statement->execute();
}

function getAllContactsByUserId(object $pdo, array $conditions, array $parameters, string $query)
{
    $isLoggedIn = isset($_SESSION["user_id"]);
    $user_id = $isLoggedIn ? $_SESSION["user_id"] : "";

    if ($isLoggedIn) {
        if ($conditions) {
            $query .= " WHERE " . implode(" AND ", $conditions) . " AND user_id = " . $user_id . " ORDER BY created_at DESC";
            $statement = $pdo->prepare($query);
            $statement->execute($parameters);
            $searchResult = $statement->fetchAll(PDO::FETCH_ASSOC);
            return $searchResult;
        } else {
            $query = "SELECT * FROM contacts WHERE user_id = $user_id ORDER BY created_at DESC;";
            $statement = $pdo->prepare($query);
            $statement->execute();
            $result = $statement->fetchAll(PDO::FETCH_ASSOC);
            return $result;
        }
    }
}

// Delete statement
function deleteContact(object $pdo, string $contactId)
{
    $query = "DELETE FROM contacts WHERE id = :id";
    $statement = $pdo->prepare($query);
    $statement->bindParam(":id", $contactId);
    $statement->execute();
}

function deleteGender(object $pdo, string $contactId)
{
    $query = "DELETE FROM genders WHERE id = :id";
    $statement = $pdo->prepare($query);
    $statement->bindParam(":id", $contactId);
    $statement->execute();
};

function deleteProfession(object $pdo, string $contactId)
{
    $query = "DELETE FROM professions WHERE contact_id = :contact_id";
    $statement = $pdo->prepare($query);
    $statement->bindParam(":contact_id", $contactId);
    $statement->execute();
};

function deleteBloodGroup(object $pdo, string $contactId)
{
    $query = "DELETE FROM blood_groups WHERE contact_id = :contact_id";
    $statement = $pdo->prepare($query);
    $statement->bindParam(":contact_id", $contactId);
    $statement->execute();
};

function getContactImageById(object $pdo, string $contactId)
{
    $query = "SELECT * FROM contacts_images WHERE contact_id = :contact_id";
    $statement = $pdo->prepare($query);
    $statement->bindParam(":contact_id", $contactId);
    $statement->execute();
    $contactImage = $statement->fetch(PDO::FETCH_ASSOC);
    return isset($contactImage["image_url"]) ? $contactImage["image_url"] : "";
}

function deleteContactImage(object $pdo, string $contactId)
{
    // Delete the contact image from folder
    $imageUrl = getContactImageById($pdo, $contactId);
    deleteContactImageIfExists($imageUrl);

    // Delete the contact image from database
    $query = "DELETE FROM contacts_images WHERE contact_id = :contact_id";
    $statement = $pdo->prepare($query);
    $statement->bindParam(":contact_id", $contactId);
    $statement->execute();
};

// Updates the contact
function updateContactImage(object $pdo, string $contactId, string $imageUrl)
{
    $query = "UPDATE contacts_images SET image_url = :image_url WHERE contact_id = :contact_id;";
    $statement = $pdo->prepare($query);
    $statement->bindParam(":image_url", $imageUrl);
    $statement->bindParam(":contact_id", $contactId, PDO::PARAM_INT);
    $statement->execute();
}

function updateContact(object|null $pdo, string $name, string $email, string $phone, string $address, string $age, string $dob, string $contactId)
{
    $query = "UPDATE contacts SET name = :name, phone_number = :phone_number, email = :email, address = :address, age = :age, dob = :dob WHERE id = :id;";
    $statement = $pdo->prepare($query);
    $statement->bindParam(":name", $name);
    $statement->bindParam(":phone_number", $phone);
    $statement->bindParam(":email", $email);
    $statement->bindParam(":address", $address);
    $statement->bindParam(":age", $age);
    $statement->bindParam(":dob", $dob);
    $statement->bindParam(":id", $contactId, PDO::PARAM_INT);
    $statement->execute();
}

function updateGender(object|null $pdo, string $gender, string $contactId)
{
    $query = "UPDATE genders SET gender = :gender WHERE contact_id = :contact_id;";
    $statement = $pdo->prepare($query);
    $statement->bindParam(":gender", $gender);
    $statement->bindParam(":contact_id", $contactId, PDO::PARAM_INT);
    $statement->execute();
}

function updateProfession(object|null $pdo, string $profession, string $contactId)
{
    $query = "UPDATE professions SET profession = :profession WHERE contact_id = :contact_id;";
    $statement = $pdo->prepare($query);
    $statement->bindParam(":profession", $profession);
    $statement->bindParam(":contact_id", $contactId, PDO::PARAM_INT);
    $statement->execute();
}

function updateBloodGroup(object|null $pdo, string $bloodGroup, string $contactId)
{
    $query = "UPDATE blood_groups SET blood_group = :blood_group WHERE contact_id = :contact_id;";
    $statement = $pdo->prepare($query);
    $statement->bindParam(":blood_group", $bloodGroup);
    $statement->bindParam(":contact_id", $contactId, PDO::PARAM_INT);
    $statement->execute();
}
