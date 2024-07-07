<?php
require_once "includes/config-session.php";
require_once "./includes/contacts/get-contacts.php";
require_once "includes/users/get-user-image.php";

// Check if the user is logged in
if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    die();
};

$isLoggedIn = isset($_SESSION["email"]);
$userId =  isset($_SESSION["user_id"]) ? $_SESSION["user_id"] : "";
$imageUrl = isset($userImage["image_url"]) ? $userImage["image_url"] : "";
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
    <header class="container flex justify-between items-center p-3">
        <h4 class="text-center text-xl font-bold">
            <a href="index.php">Phone Book App</a>
        </h4>
        <div>
            <?php
            if ($isLoggedIn) { ?>
                <?php if ($imageUrl) { ?>
                    <a href="profile.php?id=<?php echo $userId; ?>">
                        <img class="rounded-full size-12" src="uploads/users/<?php echo $imageUrl; ?>" alt="Avatar">
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
        $name = isset($_GET['name']) ? htmlspecialchars($_GET['name']) : '';
        $email = isset($_GET['email']) ? htmlspecialchars($_GET['email']) : '';
        $phone_number = isset($_GET['phone-number']) ? htmlspecialchars($_GET['phone-number']) : '';
        $address = isset($_GET['address']) ? htmlspecialchars($_GET['address']) : '';
        $age = isset($_GET['age']) ? htmlspecialchars($_GET['age']) : '';
        $dob = isset($_GET['dob']) ? htmlspecialchars($_GET["dob"]) : '';
        $gender = isset($_GET['gender']) ? htmlspecialchars($_GET['gender']) : '';
        $profession = isset($_GET['profession']) ? htmlspecialchars($_GET['profession']) : '';
        ?>

        <!-- Search form -->
        <form class="bg-white p-5 rounded font-semibold" method="get" action="contacts.php" onsubmit="removeEmptyFields(this)">
            <div class="grid grid-cols-1 md:grid-cols-4 justify-center gap-6">
                <input type="text" placeholder="Search by name" value="<?php echo $name ?>" name="name" class="w-full focus:outline-none border rounded p-2 border-neutral-700">
                <input type="email" placeholder="Search by email" value="<?php echo $email ?>" name="email" class="w-full focus:outline-none border rounded p-2 border-neutral-700">
                <input type="tel" placeholder="Search by phone number" value="<?php echo $phone_number ?>" name="phone-number" class="w-full focus:outline-none border rounded p-2 border-neutral-700">
                <input type="number" placeholder="Search by age" value="<?php echo $age ?>" name="age" class="w-full focus:outline-none border rounded p-2 border-neutral-700">
                <div class="col-span-1 md:col-span-4 grid grid-cols-2 md:grid-cols-5 gap-3">
                    <input type="date" placeholder="Search by birthday" value="<?php echo $dob ?>" name="dob" class="w-full focus:outline-none border rounded p-2 border-neutral-700">
                    <select name="gender" id="gender" class="w-full focus:outline-none border rounded p-2 border-neutral-700">
                        <option value="">Gender</option>
                        <option value="male" <?php echo ($age == 'male') ? 'selected' : ''; ?>>Male</option>
                        <option value="female" <?php echo ($age == 'female') ? 'selected' : ''; ?>>Female</option>
                        <option value="other" <?php echo ($age == 'other') ? 'selected' : ''; ?>>Other</option>
                    </select>
                    <select name="profession" id="profession" class="w-full focus:outline-none border rounded p-2 border-neutral-700">
                        <option value="">Profession</option>
                        <option value="student" <?php echo ($profession == 'student') ? 'selected' : ''; ?>>Student</option>
                        <option value="teacher" <?php echo ($profession == 'teacher') ? 'selected' : ''; ?>>Teacher</option>
                        <option value="engineer" <?php echo ($profession == 'engineer') ? 'selected' : ''; ?>>Engineer</option>
                        <option value="other" <?php echo ($profession == 'other') ? 'selected' : ''; ?>>Other</option>
                    </select>
                    <select name="blood_group" id="blood_group" class="w-full focus:outline-none border rounded p-2 border-neutral-700">
                        <option value="">Blood group</option>
                        <option value="A+">A+</option>
                        <option value="A-">A-</option>
                        <option value="B+">B+</option>
                        <option value="B-">B-</option>
                        <option value="AB+">AB+</option>
                        <option value="AB-">AB-</option>
                        <option value="O+">O+</option>
                        <option value="O-">O-</option>
                    </select>
                    <input type="text" placeholder="Search by address" value="<?php echo $address ?>" name="address" class="w-full focus:outline-none border rounded p-2 border-neutral-700">
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
                <!-- Search form -->
                <div class="flex gap-3">
                    <a href="add-contact.php" class="bg-blue-500 text-white font-semibold px-4 py-1 rounded cursor-pointer hover:bg-blue-400 transition-colors duration-200">
                        + Add contact
                    </a>
                </div>

            </div>
            <table class="table-auto w-full overflow-x-scroll">
                <thead>
                    <tr>
                        <th class="text-start px-4 py-2">Name</th>
                        <th class="text-start px-4 py-2">Phone</th>
                        <th class="text-start px-4 py-2">Email</th>
                        <th class="text-start px-4 py-2">Address</th>
                        <th class="text-start px-4 py-2">Action</th>
                    </tr>
                </thead>
                <tbody class="bg-white">
                    <?php

                    if (empty($data)) {
                        echo "<tr><td colspan='5' class='text-center text-lg font-semibold py-4'>No contacts found</td></tr>";
                    } else {
                        foreach ($data as $contact) : ?>
                            <tr class="border rounded">
                                <td class="px-4 py-2">
                                    <a href="contact.php?id=<?= $contact["id"]; ?>"><?= htmlspecialchars($contact["name"]) ?></a>
                                </td>
                                <td class="px-4 py-2"><?= htmlspecialchars($contact["phone_number"]) ?></td>
                                <td class="px-4 py-2"><?= htmlspecialchars($contact["email"]) ?></td>
                                <td class="px-4 py-2"><?= htmlspecialchars($contact["address"]) ?></td>
                                <td class="px-4 py-2">
                                    <button title="Edit contact" class="text-blue-400 font-semibold px-2 py-1 rounded cursor-pointer transition-colors duration-200">
                                        <a href="update-contact.php?id=<?= $contact["id"] ?>">
                                            <i class="fa-solid fa-pen-to-square"></i>
                                        </a>
                                    </button>
                                    <button title="Delete contact" class="text-red-400 font-semibold px-2 py-1 rounded cursor-pointer transition-colors duration-200">
                                        <a href="includes/contacts/delete-contact-handler.php?id=<?= $contact["id"] ?>" onclick="return confirm('Are you sure you want to delete this contact?');">
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