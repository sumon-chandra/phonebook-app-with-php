<?php
// Define the absolute path to the db.php file
$dbPath = dirname(__DIR__) . '/db.php';

if (file_exists($dbPath)) {
    require_once $dbPath;
} else {
    die("Error: db.php or config file not found at " . $dbPath);
}

require_once "contact-model.php";
require_once "contact-view.php";
require_once "contact-contr.php";

try {
    $contactId = isset($_GET["contact_id"]) ? $_GET["contact_id"] : "";

    if ($contactId) {
        deleteContact($pdo, $contactId);
    }

    header("Location: ../../contacts.php");
} catch (PDOException $error) {
    die("Something went wrong! Please try again" . $error->getMessage());
    header("Location: ../../contacts.php");
}
