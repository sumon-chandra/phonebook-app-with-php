<!-- Get contact  -->
<?php
require_once "./includes/db.php";
require_once "./includes/config-session.php";
require_once "includes/contacts/contact-model.php";
require_once "includes/contacts/contact-contr.php";
require_once "includes/users/user.php";
require_once "includes/contacts/get-contacts.php";

// Check if the user is logged in
if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    die();
};

$isLoggedIn = isset($_SESSION["user_id"]);
$userId =  isset($_SESSION["user_id"]) ? $_SESSION["user_id"] : "";

$contactId = $_GET["contact_id"];

try {
    // Get contact
    $contact = getContact($pdo, $contactId);
    $contactDBId = $contact["id"];
    $imageUrl = "uploads/users/" . $contact["contact_image"];

    if (!$contact) {
        die("Contact not found.");
    }

    $avatar = isset($contact["avatar"]) ? $contact["avatar"] : "";

    $contact_name = isset($contact["contact_name"]) ? htmlspecialchars($contact["contact_name"]) : '';
    $contact_email = isset($contact["contact_email"]) ? htmlspecialchars($contact["contact_email"]) : '';
    $contact_number = isset($contact["contact_number"]) ? htmlspecialchars($contact["contact_number"]) : '';
    $age = null;
    $districtName = isset($contact["district"]) ? htmlspecialchars($contact["district"]) : '';
    $dob = isset($contact["dob"]) ? htmlspecialchars($contact["dob"]) : '';
    $professionName = isset($contact["profession"]) ? htmlspecialchars($contact["profession"]) : '';
    $genderName = isset($contact["gender"]) ? htmlspecialchars($contact["gender"]) : '';
    $bloodGroupName = isset($contact["blood_group"]) ? htmlspecialchars($contact["blood_group"]) : '';
} catch (PDOException $error) {
    die("Something went wrong! Please try again" . $error->getMessage());
}
?>

<!-- Update contact form -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://kit.fontawesome.com/3930858232.js" crossorigin="anonymous"></script>
    <title>Update contact - Phonebook</title>
</head>

<body class="min-w-full min-h-screen bg-neutral-200 text-neutral-700">
    <header class="container flex justify-between items-center p-3">
        <h4 class="text-center text-xl font-bold">
            <a href="index.php">Phone Book App</a>
        </h4>
        <div>
            <?php
            if ($isLoggedIn) { ?>
                <?php if (!empty($isAvatarExist)) { ?>
                    <a href="profile.php?id=<?= $user_id ?>">
                        <img class="rounded-full size-12" src="uploads/users/<?= $user["avatar"] ?>" alt="Avatar">
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
    <main class="lg:w-3/4 lg:p-0 p-3 m-auto">
        <div>
            <a href="contacts.php" class="font-semibold">
                <i class="fas fa-arrow-left"></i>
                Back to Contacts List
            </a>
        </div>
        <div class="text-center pt-10">
            <h1 class="flex items-center justify-center gap-4 text-4xl font-bold">
                <i class="fa-solid fa-address-book"></i>
                <span>Update contact</span>
            </h1>
        </div>
        <section class="space-y-4 overflow-x-auto">
            <form action="includes/contacts/update-contact-handler.php" method="post" enctype="multipart/form-data" class="md:w-3/4 mx-auto flex flex-col gap-3 p-6 rounded-sm mt-10 bg-white">
                <input type="hidden" name="contact_id" value="<?= $contactId ?>">

                <div class="grid grid-cols-1 md:grid-cols-6 gap-4">
                    <div class="flex flex-col col-span-1 md:col-span-3">
                        <label for="name">Name:</label>
                        <input type="text" id="name" name="name" value="<?= $contact_name ?>" autofocus placeholder="Enter name" class="p-2 border rounded">
                    </div>
                    <div class="flex flex-col col-span-1 md:col-span-3">
                        <label for="phone">Phone:</label>
                        <input type="tel" id="phone" name="phone" value="<?= $contact_number ?>" placeholder="Enter phone number" class="p-2 border rounded">
                    </div>
                    <div class="flex flex-col col-span-1 md:col-span-3">
                        <label for="email" class="font-semibold text-sm mb-1">Email:</label>
                        <input type="email" id="email" name="email" value="<?= $contact_email ?>" placeholder="Enter email" class="p-2 border rounded">
                    </div>
                    <div class="flex flex-col col-span-1 md:col-span-3">
                        <label for="district">District:</label>
                        <select name="district" id="district" class="w-full border rounded p-2">
                            <option value="">Select district</option>
                            <?php foreach ($districts as $district) : ?>
                                <option value="<?= $district["id"] ?>" <?= ($districtName == $district["district"]) ? "selected" : "" ?>>
                                    <?= $district["district"] ?>
                                </option>
                            <?php endforeach ?>
                        </select>
                    </div>
                    <div class="flex flex-col col-span-1 md:col-span-3">
                        <label for="gender" class="font-semibold text-sm mb-1">Gender:</label>
                        <select name="gender" id="gender" class="p-2 border rounded" class="p-2 border rounded">
                            <option value="">Select gender</option>
                            <option value="1" <?= ($genderName == 'Male') ? 'selected' : ''; ?>>Male</option>
                            <option value="2" <?= ($genderName == 'Female') ? 'selected' : ''; ?>>Female</option>
                            <option value="3" <?= ($genderName == 'Other') ? 'selected' : ''; ?>>Other</option>
                        </select>
                    </div>
                    <div class="flex flex-col col-span-1 md:col-span-2">
                        <label for="dob" class="font-semibold text-sm mb-1">Date of birth:</label>
                        <input type="date" id="dob" name="dob" value="<?= $dob ?>" required class="p-2 border rounded">
                    </div>
                    <div class="flex flex-col col-span-1 md:col-span-2">
                        <label for="profession" class="font-semibold text-sm mb-1">Profession:</label>
                        <select name="profession" id="profession" class="w-full border rounded p-2">
                            <option value="">Choose Profession</option>
                            <?php foreach ($professions as $profession) : ?>
                                <option value="<?= $profession["id"] ?>" <?= ($professionName == $profession["profession"]) ? "selected" : "" ?>>
                                    <?= $profession["profession"] ?>
                                </option>
                            <?php endforeach ?>
                        </select>
                    </div>
                    <div class="flex flex-col col-span-1 md:col-span-2">
                        <label for="blood_group" class="font-semibold text-sm mb-1">Blood Group</label>
                        <select name="blood_group" id="blood_group" class="w-full border rounded p-2">
                            <option value="">Choose blood group</option>
                            <?php foreach ($blood_groups as $blood) : ?>
                                <option value="<?= $blood["id"] ?>" <?= ($bloodGroupName == $blood["blood"]) ? "selected" : "" ?>>
                                    <?= $blood["blood"] ?>
                                </option>
                            <?php endforeach ?>
                        </select>
                    </div>
                    <div class="flex flex-col col-span-1">
                        <label for="image" class="font-semibold text-sm mb-1">Update image:</label>
                        <input type="file" name="image" id="image" accept="image/png, image/jpeg, image/webp, image/jpg">
                    </div>
                </div>
                <div class="flex gap-3 justify-end">
                    <input type="submit" value="Update contact" class="bg-blue-500 text-white font-semibold px-4 py-1 rounded cursor-pointer hover:bg-blue-400 transition-colors duration-200" />
                    <a href="contacts.php" class=" text-slate-200 bg-neutral-700 font-semibold px-4 py-1 rounded cursor-pointer hover:bg-neutral-600 transition-colors duration-200">Cancel</a>
                </div>
            </form>
            </form>
        </section>
        <div class="text-center font-semibold">
            <?=
            displayErrors("update");
            if (isset($_SESSION["update_contact_errors"])) {
                unset($_SESSION["update_contact_errors"]);
            }
            ?>
        </div>
    </main>
</body>

</html>