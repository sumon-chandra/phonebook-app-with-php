<?php
require_once "db.php";

try {
    $searchItem = isset($_GET["search"]) ? $_GET["search"] : "";
    // echo "Search item " . $searchItem;

    if ($searchItem) {
        // Getting contacts by search item from the database
        $query = "SELECT * FROM contacts WHERE name LIKE :search";
        $statement = $pdo->prepare($query);
        $statement->execute(["search" => "%" . $searchItem . "%"]);
        // Fetching all contacts
        $data = $statement->fetchAll(PDO::FETCH_ASSOC);
    } else {
        // Getting contacts from the database
        // session_start();
        if (isset($_SESSION["user_id"])) {
            $user_id = $_SESSION["user_id"];
            $query = "SELECT * FROM contacts WHERE user_id = $user_id";
            $statement = $pdo->prepare($query);
            $statement->execute();
            // Fetching all contacts
            $data = $statement->fetchAll(PDO::FETCH_ASSOC);
        }
    }
} catch (PDOException $error) {
    die("Failed to load contacts" . $error->getMessage());
}
