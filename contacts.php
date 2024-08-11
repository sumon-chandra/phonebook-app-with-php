<?php
require_once "includes/config-session.php";
require_once "./includes/contacts/get-contacts.php";
require_once "includes/users/user.php";

// Check if the user is logged in
$userId =  isset($_SESSION["user_id"]) ? $_SESSION["user_id"] : "";
if (!$userId) {
    header("Location: login.php");
    die();
};

$isAvatarExist = isset($user["avatar"]);
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
        <?=
        $contact_number = isset($_GET['contact_number']) ? htmlspecialchars($_GET['contact_number']) : '';
        $contact_email = isset($_GET['contact_email']) ? htmlspecialchars($_GET['contact_email']) : '';
        $contact_number = isset($_GET['contact_number']) ? htmlspecialchars($_GET['contact_number']) : '';
        $age = isset($_GET['age']) ? htmlspecialchars($_GET['age']) : '';
        $dob = isset($_GET['dob']) ? htmlspecialchars($_GET["dob"]) : '';
        $genderTitle = isset($_GET['gender']) ? htmlspecialchars($_GET['gender']) : '';
        $districtTitle = isset($_GET['district']) ? htmlspecialchars($_GET['district']) : '';
        $professionTitle = isset($_GET['profession']) ? htmlspecialchars($_GET['profession']) : '';
        $bloodGroupTitle = isset($_GET['blood_group']) ? htmlspecialchars($_GET['blood_group']) : '';
        ?>

        <!-- Search form -->
        <form class="bg-white p-5 rounded font-semibold" method="get" action="contacts.php" onsubmit="removeEmptyFields(this)">
            <div class="grid grid-cols-1 md:grid-cols-3 justify-center gap-6">
                <input type="text" placeholder="Search by contact name" value="<?= $contact_name ?>" name="contact_name" class="w-full focus:outline-none border rounded p-2 border-neutral-700">
                <input type="email" placeholder="Search by email" value="<?= $contact_email ?>" name="contact_email" class="w-full focus:outline-none border rounded p-2 border-neutral-700">
                <input type="tel" placeholder="Search by phone number" value="<?= $contact_number ?>" name="contact_number" class="w-full focus:outline-none border rounded p-2 border-neutral-700">
                <div class="col-span-1 md:col-span-3 grid grid-cols-2 md:grid-cols-5 gap-3">
                    <input type="date" placeholder="Search by birthday" value="<?= $dob ?>" name="dob" class="w-full focus:outline-none border rounded p-2 border-neutral-700">
                    <select name="gender" id="gender" class="w-full focus:outline-none border rounded p-2 border-neutral-700">
                        <option value="">Choose Gender</option>
                        <option value="male" <?= ($genderTitle == 'male') ? 'selected' : ''; ?>>Male</option>
                        <option value="female" <?= ($genderTitle == 'female') ? 'selected' : ''; ?>>Female</option>
                        <option value="other" <?= ($genderTitle == 'other') ? 'selected' : ''; ?>>Other</option>
                    </select>
                    <select name="profession" id="profession" class="w-full focus:outline-none border rounded p-2 border-neutral-700">
                        <option value="">Choose Profession</option>
                        <?php foreach ($professions as $profession) : ?>
                            <option value="<?= $profession["profession"] ?>" <?= ($professionTitle == $profession["profession"]) ? "selected" : "" ?>>
                                <?= $profession["profession"] ?>
                            </option>
                        <?php endforeach ?>
                    </select>
                    <select name="blood_group" id="blood_group" class="w-full focus:outline-none border rounded p-2 border-neutral-700">
                        <option value="">Choose blood group</option>
                        <?php foreach ($blood_groups as $blood) : ?>
                            <option value="<?= $blood["blood"] ?>" <?= ($bloodGroupTitle == $blood["blood"]) ? "selected" : "" ?>>
                                <?= $blood["blood"] ?>
                            </option>
                        <?php endforeach ?>
                    </select>
                    <select name="district" id="district" class="w-full focus:outline-none border rounded p-2 border-neutral-700">
                        <option value="">Choose district</option>
                        <?php foreach ($districts as $district) : ?>
                            <option value="<?= $district["district"] ?>" <?= ($districtTitle == $district["district"]) ? "selected" : "" ?>>
                                <?= $district["district"] ?>
                            </option>
                        <?php endforeach ?>
                    </select>
                </div>
            </div>
            <div class="flex items-center justify-center gap-3 mt-2">
                <button type="submit" class="bg-blue-500 text-white font-semibold px-4 py-1 rounded cursor-pointer hover:bg-blue-400 transition-colors duration-200">
                    <i class=" fa-solid fa-magnifying-glass"></i>
                    Search
                </button>
                <?php if ($searchPerformed) : { ?>
                        <button type="button" onclick="clearForm(this.form)" class="bg-neutral-700 text-white font-semibold px-4 py-1 rounded cursor-pointer hover:bg-neutral-600 transition-colors duration-200">
                            <i class="fa-solid fa-times"></i>
                            Remove
                        </button>
                <?php }
                endif ?>
            </div>
        </form>

        <!-- Contacts table -->
        <div class="text-center pt-10">
            <h4 class="flex items-center justify-center gap-4 text-4xl font-bold">
                <i class="fa-solid fa-address-book"></i>
                <span>Your contact list</span>
            </h4>
        </div>
        <section class="space-y-4 overflow-x-auto">
            <div class="flex justify-between items-start mt-10">
                <h3 class="text-xl font-semibold">Contacts</h3>
                <div class="flex gap-3">
                    <a href="add-contact.php" class="bg-blue-500 text-white font-semibold px-4 py-1 rounded cursor-pointer hover:bg-blue-400 transition-colors duration-200">
                        + Add contact
                    </a>
                </div>

            </div>
            <table class="table-auto w-full overflow-x-scroll">
                <thead>
                    <tr>
                        <th class="text-start px-4 py-2">Avatar</th>
                        <th class="text-start px-4 py-2">Name</th>
                        <th class="text-start px-4 py-2">Phone</th>
                        <th class="text-start px-4 py-2">Email</th>
                        <th class="text-start px-4 py-2">Address</th>
                        <th class="text-start px-4 py-2">Action</th>
                    </tr>
                </thead>
                <tbody class="bg-white">
                    <?php

                    if (empty($contacts)) {
                        echo "<tr><td colspan='5' class='text-center text-lg font-semibold py-4'>No contacts found</td></tr>";
                    } else {
                        foreach ($contacts as $contact) : ?>
                            <tr class="border rounded">
                                <td class="px-4 py-2">
                                    <a href="contact.php?id=<?= $contact["id"]; ?>">
                                        <?php if (!empty($contact["contact_image"])) : ?>
                                            <img src="uploads/contacts/<?= $contact["contact_image"] ?>" alt="Contact avatar" class="size-10 rounded-full object-cover">
                                        <?php else : ?>
                                            <div>
                                                <i class="fas fa-user-circle fa-2x text-4xl"></i>
                                            </div>
                                        <?php endif; ?>
                                    </a>
                                </td>
                                <td class="px-4 py-2"><?= htmlspecialchars($contact["contact_name"]) ?></td>
                                <td class="px-4 py-2"><?= htmlspecialchars($contact["contact_number"]) ?></td>
                                <td class="px-4 py-2"><?= htmlspecialchars($contact["contact_email"]) ?></td>
                                <td class="px-4 py-2"><?= htmlspecialchars($contact["district"]) ?></td>
                                <td class="px-4 py-2">
                                    <button title="Edit contact" class="text-blue-400 font-semibold px-2 py-1 rounded cursor-pointer transition-colors duration-200">
                                        <a href="update-contact.php?contact_id=<?= $contact["id"] ?>">
                                            <i class="fa-solid fa-pen-to-square"></i>
                                        </a>
                                    </button>
                                    <button title="Delete contact" class="text-red-400 font-semibold px-2 py-1 rounded cursor-pointer transition-colors duration-200">
                                        <a href="includes/contacts/delete-contact-handler.php?contact_id=<?= $contact["id"] ?>" onclick="return confirm('Are you sure you want to delete this contact?');">
                                            <i class="fa-solid fa-trash"></i>
                                        </a>
                                    </button>
                                </td>
                            </tr>
                    <?php endforeach;
                    }
                    ?>
                </tbody>
            </table>
        </section>
    </main>
</body>

</html>