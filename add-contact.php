<?php
require_once "includes/config-session.php";
require_once "includes/users/user.php";

// Check if the user is logged in
if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    die();
};

$isLoggedIn = isset($_SESSION["email"]);
$userId =  isset($_SESSION["user_id"]) ? $_SESSION["user_id"] : "";
$imageUrl = "uploads/users/" . $user_image;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://kit.fontawesome.com/3930858232.js" crossorigin="anonymous"></script>
    <title>Add contact - Phonebook</title>
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
                        <img class="rounded-full size-12" src="<?= $imageUrl ?>" alt="Avatar">
                    </a>
                <?php } else { ?>
                    <div>
                        <span class="text-lg font-semibold"><span class="font-light">Logged in as</span> <?php echo $_SESSION["email"]; ?></span>
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
        <div class="text-center pt-10">
            <h1 class="flex items-center justify-center gap-4 text-4xl font-bold">
                <i class="fa-solid fa-address-book"></i>
                <span>Add contact</span>
            </h1>
        </div>
        <section class="space-y-4 overflow-x-auto">
            <form action="includes/contacts/add-contact-handler.php" method="post" enctype="multipart/form-data" class="md:w-3/4 mx-auto flex flex-col gap-3 p-6 rounded-sm mt-10 bg-white">
                <div class="grid grid-cols-2 md:grid-cols-6 gap-4">
                    <div class="flex flex-col col-span-1 md:col-span-3">
                        <label for="name" class="font-semibold text-lg">Name:</label>
                        <input type="text" id="name" name="name" autofocus required placeholder="Enter name" class="p-2 focus:outline-none border rounded">
                    </div>
                    <div class="flex flex-col col-span-1 md:col-span-3">
                        <label for="phone" class="font-semibold text-lg">Phone:</label>
                        <input type="tel" id="phone" name="phone" required placeholder="Enter phone number" class="p-2 focus:outline-none border rounded">
                    </div>
                    <div class="flex flex-col col-span-1 md:col-span-3">
                        <label for="email" class="font-semibold text-lg">Email:</label>
                        <input type="email" id="email" name="email" required placeholder="Enter email" class="p-2 focus:outline-none border rounded">
                    </div>
                    <div class="flex flex-col col-span-1 md:col-span-3">
                        <label for="age" class="font-semibold text-lg">Age:</label>
                        <input type="number" id="age" name="age" placeholder="Enter age" class="p-2 focus:outline-none border rounded">
                    </div>
                    <div class="flex flex-col col-span-1 md:col-span-3">
                        <label for="address" class="font-semibold text-lg">Address:</label>
                        <input type="text" id="address" name="address" placeholder="Enter address" class="p-2 focus:outline-none border rounded">
                    </div>
                    <div class="flex flex-col col-span-1 md:col-span-3">
                        <label for="gender" class="font-semibold text-lg">Gender:</label>
                        <select name="gender" id="gender" class="p-2 focus:outline-none border rounded">
                            <option value="">Select gender</option>
                            <option value="male">Male</option>
                            <option value="female">Female</option>
                            <option value="other">Other</option>
                        </select>
                    </div>
                    <div class="flex flex-col col-span-1 md:col-span-2">
                        <label for="dob" class="font-semibold text-lg">Date of birth:</label>
                        <input type="date" id="dob" name="dob" required class="p-2 focus:outline-none border rounded">
                    </div>
                    <div class="flex flex-col col-span-1 md:col-span-2">
                        <label for="profession" class="font-semibold text-lg">Profession:</label>
                        <select name="profession" id="profession" class="p-2 focus:outline-none border rounded">
                            <option value="">Select profession</option>
                            <option value="student">Student</option>
                            <option value="teacher">Teacher</option>
                            <option value="engineer">Engineer</option>
                            <option value="other">Other</option>
                        </select>
                    </div>
                    <div class="flex flex-col col-span-1 md:col-span-2">
                        <label for="blood_group" class="font-semibold text-lg">Blood Group</label>
                        <select name="blood_group" id="blood_group" class="p-2 focus:outline-none border rounded">
                            <option value="">Select blood group</option>
                            <option value="A+">A+</option>
                            <option value="A-">A-</option>
                            <option value="B+">B+</option>
                            <option value="B-">B-</option>
                            <option value="AB+">AB+</option>
                            <option value="AB-">AB-</option>
                            <option value="O+">O+</option>
                            <option value="O-">O-</option>
                        </select>
                    </div>
                    <div class="flex flex-col col-span-1 md:col-span-3">
                        <label for="image" class="font-semibold text-lg">Add image:</label>
                        <input type="file" name="image" id="image" accept="image/png, image/jpeg, image/webp, image/jpg">
                    </div>
                </div>
                <div class="flex gap-3 justify-end">
                    <input type="submit" value="Add contact" class="bg-blue-500 text-white font-semibold px-4 py-1 rounded cursor-pointer hover:bg-blue-400 transition-colors duration-200" />
                    <a href="contacts.php" class=" text-slate-200 bg-neutral-700 font-semibold px-4 py-1 rounded cursor-pointer hover:bg-neutral-600 transition-colors duration-200">Cancel</a>
                </div>
            </form>
            </form>
        </section>
    </main>
</body>

</html>