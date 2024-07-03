<?php
require_once "includes/config-session.php";
require_once "./includes/get-contacts.php";

// Check if the user is logged in
if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    die();
};
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

<body class="min-w-full min-h-screen bg-slate-200 text-neutral-700">
    <header class="flex justify-between items-center p-3">
        <h4 class="text-center text-xl font-bold">
            <a href="index.php">Phone Book App</a>
        </h4>
        <?php
        $isLoggedIn = isset($_SESSION["email"]);
        if ($isLoggedIn) { ?>
            <div>
                <span class="text-lg font-semibold"><span class="font-light">Logged in as</span> <?php echo $_SESSION["email"]; ?></span>
            </div>
            <form action="includes/login/logout.php">
                <button type="submit" class="bg-neutral-700 text-white font-semibold px-4 py-2 rounded cursor-pointer hover:bg-neutral-600 transition-colors duration-200">
                    Logout
                </button>
            </form>
        <?php } else { ?>
            <a href="login.php" class="bg-neutral-700 text-white font-semibold px-4 py-2 rounded cursor-pointer hover:bg-neutral-600 transition-colors duration-200">
                Login
            </a>
        <?php } ?>
    </header>
    <main class="lg:w-3/4 lg:p-0 p-3 m-auto">
        <?=
        $name = isset($_GET['name']) ? htmlspecialchars($_GET['name']) : '';
        $email = isset($_GET['email']) ? htmlspecialchars($_GET['email']) : '';
        $phone_number = isset($_GET['phone-number']) ? htmlspecialchars($_GET['phone-number']) : '';
        $address = isset($_GET['address']) ? htmlspecialchars($_GET['address']) : '';
        ?>
        <h3 class="text-center py-4 text-lg font-semibold">
            <i class="fa-solid fa-search"></i>
            Search contacts
        </h3>
        <form class="border bg-white px-3 py-1 rounded font-semibold flex items-center justify-start gap-3" method="get" action="contacts.php" onsubmit="removeEmptyFields(this)">
            <input type="text" placeholder="Search by name" value="<?php echo $name ?>" name="name" class="w-full border-r-2 focus:outline-none">
            <input type="email" placeholder="Search by email" value="<?php echo $email ?>" name="email" class="w-full border-r-2 focus:outline-none">
            <input type="tel" placeholder="Search by phone number" value="<?php echo $phone_number ?>" name="phone-number" class="w-full border-r-2 focus:outline-none">
            <input type="text" placeholder="Search by address" value="<?php echo $address ?>" name="address" class="w-full border-r-2 focus:outline-none">
            <?php if ($searchPerformed) : { ?>
                    <button type="button" onclick="clearForm(this.form)" class="bg-blue-400 text-white font-semibold px-4 py-1 rounded cursor-pointer hover:bg-blue-500 transition-colors duration-200">
                        <i class="fa-solid fa-times"></i>
                    </button>
                <?php } ?>
                <?php else : { ?>
                    <button type="submit" class="bg-blue-500 text-white font-semibold px-4 py-1 rounded cursor-pointer hover:bg-blue-400 transition-colors duration-200">
                        <i class=" fa-solid fa-magnifying-glass"></i>
                    </button>
            <?php }
            endif; ?>
        </form>
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
                                <td class="px-4 py-2"><?= htmlspecialchars($contact["name"]) ?></td>
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
                                        <a href="includes/delete-contact-handler.php?id=<?= $contact["id"] ?>" onclick="return confirm('Are you sure you want to delete this contact?');">
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