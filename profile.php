<?php
require_once "includes/config-session.php";
require_once "includes/users/user.php";

// Check if the user is logged in
if (!$isLoggedIn) {
    header("Location: login.php");
    die();
}

// Get user data
$name = $user["name"];
$email = $user["email"];
$displayname = explode(" ", trim($name))[0];
$imageUrl = "uploads/users/" . $user_image
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://kit.fontawesome.com/3930858232.js" crossorigin="anonymous"></script>
    <title>Profile - Phone book app</title>
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
                        <a href="profile.php?id=<?= $user_id ?>">
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
        <div class="text-center pt-10">
            <h1 class="flex items-center justify-center gap-4 text-4xl font-bold"><?= $displayname . "'s" ?> profile</h1>
        </div>
        <div class="flex flex-col justify-center items-center mt-10">
            <div class="min-w-96 p-6 bg-white rounded-lg shadow-md">
                <div class="mx-auto text-center">
                    <?php if (!empty($user_image)) : ?>
                        <img src="<?= $imageUrl ?>" alt="Avatar" class="rounded-full mx-auto size-36 object-cover">
                    <?php else : ?>
                        <div class="text-2xl">
                            <i class="fas fa-user-circle fa-5x"></i>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="flex flex-col">
                    <div class="mb-4">
                        <label class="block text-neutral-600 text-sm font-bold mb-2">Name:</label>
                        <span class="text-neutral-700 text-lg"><?= $name ?></span>
                    </div>
                    <div class="mb-4">
                        <label class="block text-neutral-600 text-sm font-bold mb-2">Email:</label>
                        <span class="text-neutral-700 text-lg"><?= $email ?></span>
                    </div>
                    <div class="grid grid-cols-2 gap-3">
                        <a href="update-profile.php" class="w-full block bg-neutral-600 text-white text-center font-semibold px-4 py-2 rounded cursor-pointer hover:bg-neutral-700 transition-colors duration-200">
                            <i class="fa fa-pencil pr-1"></i>
                            Edit Profile
                        </a>
                        <form action="includes/login/logout.php">
                            <button type="submit" class="w-full bg-red-500 text-white font-semibold px-4 py-2 rounded cursor-pointer hover:bg-red-400 transition-colors duration-200">
                                <i class="fa fa-sign-out pr-1"></i>
                                Logout
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>
</body>

</html>