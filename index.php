<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://kit.fontawesome.com/3930858232.js" crossorigin="anonymous"></script>
    <title>Phone book app</title>
</head>

<body class="min-w-full min-h-screen bg-slate-200 text-neutral-700">
    <header class="flex justify-between items-center p-3">
        <h4 class="text-center text-xl font-bold">
            <a href="index.php">Phone Book App</a>
        </h4>
        <a href="login.php" class="bg-neutral-700 text-white font-semibold px-4 py-2 rounded cursor-pointer hover:bg-neutral-600 transition-colors duration-200">
            Login
        </a>
    </header>
    <main class="lg:w-3/4 lg:p-0 p-3 m-auto">
        <div class="text-center pt-10">
            <h1 class="flex items-center justify-center gap-4 text-4xl font-bold">
                <i class="fa-solid fa-address-book"></i>
                <span>Phone Book App</span>
            </h1>
        </div>
        <section class="space-y-4 overflow-x-auto">
            <div class="flex justify-between items-start mt-10">
                <h3 class="text-xl font-semibold">Contacts</h3>
                <!-- Search form -->
                <?=
                $value = isset($_GET['search']) ? htmlspecialchars($_GET['search']) : '';
                ?>
                <form class="border bg-white px-3 py-1 rounded font-semibold flex items-center justify-start gap-3" method="get" action="index.php">
                    <input type="text" placeholder="Search by name" value="<?php echo $value ?>" name="search" class="w-full focus:outline-none">
                    <button type="submit">
                        <i class="fa-solid fa-magnifying-glass"></i>
                    </button>
                </form>
                <button class="bg-blue-400 text-white font-semibold px-4 py-1 rounded cursor-pointer hover:bg-blue-500 transition-colors duration-200">
                    <a href="add-contact.php">+ Add contact</a>
                </button>

            </div>
            <table class="table-auto w-full overflow-x-scroll">
                <thead>
                    <tr>
                        <th class="text-start px-4 py-2">Name</th>
                        <th class="text-start px-4 py-2">Phone</th>
                        <th class="text-start px-4 py-2">Email</th>
                        <th class="text-start px-4 py-2">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white">
                    <?php
                    require_once "./includes/get-contacts.php";
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
                    <?php endforeach  ?>
                </tbody>
            </table>
        </section>
    </main>
</body>

</html>