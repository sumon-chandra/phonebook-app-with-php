<?php
// Define the absolute path to the db.php file
$dbPath = dirname(__DIR__) . '/db.php';
$configPath = dirname(__DIR__) . '/config-session.php';

if (file_exists($dbPath) && file_exists($configPath)) {
    require_once $dbPath;
    require_once $configPath;
} else {
    die("Error: db.php or config file not found at " . $dbPath . " " . $configPath);
}

require_once "contact-model.php";
require_once "contact-view.php";
require_once "contact-contr.php";


try {

    // Get Districts, Blood groups, Professions
    $districts = getDistricts($pdo);
    $blood_groups = getBloodGroups($pdo);
    $professions = getProfessions($pdo);

    $contact_name = isset($_GET['contact_name']) ? $_GET['contact_name'] : '';
    $contact_email = isset($_GET['contact_email']) ? $_GET['contact_email'] : '';
    $contact_number = isset($_GET['contact_number']) ? $_GET['contact_number'] : '';
    $district = isset($_GET['district']) ? $_GET['district'] : '';
    $gender = isset($_GET['gender']) ? $_GET['gender'] : '';
    $profession = isset($_GET['profession']) ? $_GET['profession'] : '';
    $blood_group = isset($_GET['blood_group']) ? $_GET['blood_group'] : '';
    $user_id = isset($_SESSION["user_id"]) ? $_SESSION['user_id'] : '';

    // Conditions and parameters
    $query = "
    SELECT 
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
            ON p.id = c.profession_id";

    $conditions = [];
    $parameters = [];
    $searchPerformed = false;

    if ($contact_name) {
        $conditions[] = "c.contact_name LIKE :contact_name";
        $parameters[":contact_name"] = "%" . $contact_name . "%";
        $searchPerformed = true;
    }
    if ($contact_email) {
        $conditions[] = "c.contact_email LIKE :contact_email";
        $parameters[":contact_email"] = "%" . $contact_email . "%";
        $searchPerformed = true;
    }
    if ($contact_number) {
        $conditions[] = "c.contact_number LIKE :contact_number";
        $parameters[":contact_number"] = "%" . $contact_number . "%";
        $searchPerformed = true;
    }
    if ($district) {
        $conditions[] = "d.district LIKE :district";
        $parameters[":district"] = "%" . $district . "%";
        $searchPerformed = true;
    }
    if ($gender) {
        $conditions[] = "g.gender = :gender";
        $parameters[":gender"] = $gender;
        $searchPerformed = true;
    }
    if ($profession) {
        $conditions[] = "p.profession = :profession";
        $parameters[":profession"] = $profession;
        $searchPerformed = true;
    }
    if ($blood_group) {
        $conditions[] = "bg.blood_group = :blood_group";
        $parameters[":blood_group"] = $blood_group;
        $searchPerformed = true;
    }

    $contacts = getAllContactsByUserId($pdo, $conditions, $parameters, $query, $user_id);
} catch (PDOException $error) {
    die("Failed to load contacts" . $error->getMessage());
}
