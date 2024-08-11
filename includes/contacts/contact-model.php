<?php

// Get the contact
function getContact(object $pdo, string $contactId)
{
    $query = "SELECT 
                c.id,
                c.created_at,
                c.updated_at,
                c.contact_name,
                c.contact_email,
                c.contact_number,
                c.contact_image,
                c.dob,
                u.id AS creator_id,
                d.district,
                g.gender,
                bg.blood AS blood_group,
                p.profession
            FROM contacts AS c 
            LEFT JOIN users AS u 
            ON u.id = c.user_id
            LEFT JOIN districts AS d 
            ON d.id = c.district_id
            LEFT JOIN genders AS g 
            ON g.id = c.gender_id
            LEFT JOIN blood_groups AS bg
            ON bg.id = c.blood_group_id
            LEFT JOIN professions AS p
            ON p.id = c.profession_id
            WHERE c.id = :id;";

    $statement = $pdo->prepare($query);
    $statement->bindParam(":id", $contactId);
    $statement->execute();
    $contact = $statement->fetch(PDO::FETCH_ASSOC);
    return $contact;
}

function isPhoneNumberFound(object $pdo, $contact_number)
{
    $query = "SELECT COUNT(*) as count FROM contacts WHERE contact_number = :contact_number;";
    $statement = $pdo->prepare($query);
    $statement->bindParam(":contact_number", $contact_number);
    $statement->execute();
    $result = $statement->fetch(PDO::FETCH_ASSOC);
    return $result["count"] > 0;
}

function getDistricts(object $pdo)
{
    $query = "SELECT * FROM districts;";
    $statement = $pdo->prepare($query);
    $statement->execute();
    return $statement->fetchAll(PDO::FETCH_ASSOC);
}

function getBloodGroups(object $pdo)
{
    $query = "SELECT * FROM blood_groups;";
    $statement = $pdo->prepare($query);
    $statement->execute();
    return $statement->fetchAll(PDO::FETCH_ASSOC);
}

function getProfessions(object $pdo)
{
    $query = "SELECT * FROM professions;";
    $statement = $pdo->prepare($query);
    $statement->execute();
    return $statement->fetchAll(PDO::FETCH_ASSOC);
}

function insertContact(object $pdo, string $contact_name, string $contact_email, string $contact_number, string $contact_image, string $dob, string $user_id, string $gender_id, string $district_id, string $blood_group_id, string $profession_id)
{
    $query = "INSERT INTO contacts 
                    (contact_name, contact_email, contact_number, contact_image, dob, user_id, gender_id, district_id, blood_group_id, profession_id) 
                    VALUES 
                    (:contact_name, :contact_email, :contact_number, :contact_image, :dob, :user_id, :gender_id, :district_id, :blood_group_id, :profession_id);";

    $statement = $pdo->prepare($query);
    $statement->bindParam(":contact_name", $contact_name);
    $statement->bindParam(":contact_email", $contact_email);
    $statement->bindParam(":contact_number", $contact_number);
    $statement->bindParam(":contact_image", $contact_image);
    $statement->bindParam(":dob", $dob);
    $statement->bindParam(":user_id", $user_id);
    $statement->bindParam(":gender_id", $gender_id);
    $statement->bindParam(":district_id", $district_id);
    $statement->bindParam(":blood_group_id", $blood_group_id);
    $statement->bindParam(":profession_id", $profession_id);
    $statement->execute();
    $newContactId = $pdo->lastInsertId();
    return $newContactId;
}

function getAllContactsByUserId(object $pdo, array $conditions, array $parameters, string $query, string $user_id)
{
    $MAIN_QUERY = "SELECT 
                    c.id,
                    c.created_at,
                    c.updated_at,
                    c.contact_name,
                    c.contact_email,
                    c.contact_number,
                    c.contact_image,
                    c.dob,
                    u.id AS creator_id,
                    d.district,
                    g.gender,
                    bg.blood AS blood_group,
                    p.profession
                FROM contacts AS c 
                LEFT JOIN users AS u 
                ON u.id = c.user_id
                LEFT JOIN districts AS d 
                ON d.id = c.district_id
                LEFT JOIN genders AS g 
                ON g.id = c.gender_id
                LEFT JOIN blood_groups AS bg
                ON bg.id = c.blood_group_id
                LEFT JOIN professions AS p
                ON p.id = c.profession_id
                WHERE c.user_id = :user_id
                ORDER BY c.created_at DESC;
                ";

    $CONDITION_QUERY = $query .= " WHERE " . implode(" AND ", $conditions) . " AND user_id = " . $user_id . " ORDER BY created_at DESC";

    if ($conditions) {
        $statement = $pdo->prepare($CONDITION_QUERY);
        $statement->execute($parameters);
        $searchResult = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $searchResult;
    } else {
        $statement = $pdo->prepare($MAIN_QUERY);
        $statement->bindParam(":user_id", $user_id);
        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $result;
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

// Updates the contact
function updateContact(object $pdo, string $contact_name, string $contact_email, string $contact_number, string $contact_image, string $dob, string $user_id, string $gender_id, string $district_id, string $blood_group_id, string $profession_id, string $contact_id)
{
    $query = "UPDATE contacts SET contact_name = :contact_name, contact_email = :contact_email, contact_number = :contact_number, contact_image = :contact_image, dob = :dob, user_id = :user_id, gender_id = :gender_id, district_id = :district_id, blood_group_id = :blood_group_id, profession_id = :profession_id WHERE id = :id;";

    $statement = $pdo->prepare($query);
    $statement->bindParam(":contact_name", $contact_name);
    $statement->bindParam(":contact_email", $contact_email);
    $statement->bindParam(":contact_number", $contact_number);
    $statement->bindParam(":contact_image", $contact_image);
    $statement->bindParam(":dob", $dob);
    $statement->bindParam(":user_id", $user_id);
    $statement->bindParam(":gender_id", $gender_id);
    $statement->bindParam(":district_id", $district_id);
    $statement->bindParam(":blood_group_id", $blood_group_id);
    $statement->bindParam(":profession_id", $profession_id);
    $statement->bindParam(":id", $contact_id);
    $statement->execute();
}
