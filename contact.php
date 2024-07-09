<?php
require_once "includes/config-session.php";
require_once "includes/users/user.php";

require_once "includes/contacts/contact-model.php";
require_once "includes/contacts/contact-contr.php";
require_once "includes/users/user.php";

// Check if the user is logged in
$isLoggedIn = isset($_SESSION["email"]);
if (!$isLoggedIn) {
    header("Location: login.php");
    die();
};

if (!isset($_GET["id"])) {
    header("Location: contacts.php");
    die();
}


$id = $_GET['id'];

// Get the contact
$contact = getContactById($pdo, $id);
$profession = getProfessionById($pdo, $id);
$gender = getGenderById($pdo, $id);
$blood_group = getBloodGroupById($pdo, $id);
$contactImage = getContactImageById($pdo, $id);



$userId =  isset($_SESSION["user_id"]) ? $_SESSION["user_id"] : "";
$contactImageUrl = "uploads/contacts/" . $contactImage;
$userImageUrl = "uploads/users/" . $user_image;

$contactId = isset($contact["id"]) ? $contact["id"] : '';
$name = isset($contact["name"]) ? htmlspecialchars($contact["name"]) : '';
$displayname = explode(" ", trim($name))[0];
$email = isset($contact["email"]) ? htmlspecialchars($contact["email"]) : '';
$address = isset($contact["address"]) ? htmlspecialchars($contact["address"]) : '';
$phone_number = isset($contact["phone_number"]) ? htmlspecialchars($contact["phone_number"]) : '';
$age = isset($contact["age"]) ? htmlspecialchars($contact["age"]) : '';
$dob = isset($contact["dob"]) ? htmlspecialchars($contact["dob"]) : '';
$professionTitle = htmlspecialchars($profession);
$genderTitle = htmlspecialchars($gender);
$bloodGroup = htmlspecialchars($blood_group);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <script defer src="js/script.js"></script>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://kit.fontawesome.com/3930858232.js" crossorigin="anonymous"></script>
    <title>Contacts - Phone book app</title>
</head>

<body class="min-w-full min-h-screen bg-neutral-100 text-neutral-700">
    <header class="flex justify-between items-center p-3">
        <h4 class="text-center text-xl font-bold">
            <a href="index.php">Phone Book App</a>
        </h4>
        <div>
            <?php
            if ($isLoggedIn) { ?>
                <?php if (!empty($user_image)) { ?>
                    <a href="profile.php?id=<?= $user_id ?>">
                        <img class="rounded-full size-12" src="<?= $userImageUrl ?>" alt="Avatar">
                    </a>
                <?php } else { ?>
                    <div>
                        <a href="profile.php?id=<?= $userId ?>">
                            <i class="fas fa-user-circle fa-2x"></i>
                        </a>
                    </div>
                <?php } ?>
            <?php } else { ?>
                <a href="login.php" class="bg-neutral-700 text-white font-semibold px-4 py-2 rounded cursor-pointer hover:bg-neutral-600 transition-colors duration-200">
                    Login
                </a>
            <?php } ?>
        </div>
    </header>
    <main class="lg:w-3/4 lg:p-0 p-3 mx-auto">
        <div>
            <a href="contacts.php" class="font-semibold">
                <i class="fas fa-arrow-left"></i>
                Back to Contacts List
            </a>
        </div>
        <div class="flex flex-col justify-center items-center mt-2">
            <div class="w-full md:w-1/2 p-6 bg-white rounded-lg shadow-md">
                <div class="mx-auto text-center">
                    <?php if (!empty($contactImage)) : ?>
                        <img src="<?= $contactImageUrl ?>" alt="Avatar" class="rounded-full mx-auto size-36 object-cover">
                    <?php else : ?>
                        <div class="text-2xl">
                            <i class="fas fa-user-circle fa-5x"></i>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-3 gap-y-0">
                    <div class="mb-4 p-2 rounded shadow">
                        <h3 class="text-neutral-600 text-sm font-bold">Name:</h3>
                        <span class="text-neutral-700"><?= $name ?></span>
                    </div>
                    <div class="mb-4 p-2 rounded shadow">
                        <h3 class="text-neutral-600 text-sm font-bold">Phone Number:</h3>
                        <span class="text-neutral-700"><?= $phone_number ?></span>
                    </div>
                    <div class="mb-4 p-2 rounded shadow">
                        <h3 class="text-neutral-600 text-sm font-bold">Email:</h3>
                        <span class="text-neutral-700"><?= $email ?></span>
                    </div>
                    <div class="mb-4 p-2 rounded shadow">
                        <h3 class="text-neutral-600 text-sm font-bold">Address:</h3>
                        <span class="text-neutral-700"><?= $address ?></span>
                    </div>
                    <div class="mb-4 p-2 rounded shadow">
                        <h3 class="text-neutral-600 text-sm font-bold">Age:</h3>
                        <span class="text-neutral-700"><?= $age ?></span>
                    </div>
                    <div class="mb-4 p-2 rounded shadow">
                        <h3 class="text-neutral-600 text-sm font-bold">Date of Birth:</h3>
                        <span class="text-neutral-700"><?= $dob ?></span>
                    </div>
                    <div class="mb-4 p-2 rounded shadow">
                        <h3 class="text-neutral-600 text-sm font-bold">Gender:</h3>
                        <span class="text-neutral-700"><?= ucfirst($genderTitle) ?></span>
                    </div>
                    <div class="mb-4 p-2 rounded shadow">
                        <h3 class="text-neutral-600 text-sm font-bold">Blood Group:</h3>
                        <span class="text-neutral-700"><?= $blood_group ?></span>
                    </div>
                    <div class="mb-4 p-2 rounded shadow">
                        <h3 class="text-neutral-600 text-sm font-bold">Profession:</h3>
                        <span class="text-neutral-700"><?= ucfirst($professionTitle) ?></span>
                    </div>
                </div>
                <div>
                    <a href="update-contact.php?id=<?= $contactId ?>" class="block w-full md:w-1/2 mx-auto bg-neutral-600 text-white text-center font-semibold px-4 py-2 rounded cursor-pointer hover:bg-neutral-700 transition-colors duration-200">
                        <i class="fa fa-pencil pr-1"></i>
                        Edit contact
                    </a>
                </div>
            </div>
        </div>
    </main>
</body>

</html>