<?php
require_once "includes/config-session.php";
require_once "includes/users/get-user.php";

// Check if the user is logged in
if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    die();
}


$isLoggedIn = isset($_SESSION["email"]);
$userId = isset($_SESSION["user_id"]) ? $_SESSION["user_id"] : "";

// Get user data
$name = $user["name"];
$email = $user["email"];
$image = "";
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
        <?php
        if ($isLoggedIn) { ?>
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
    <main>
        <div class="flex flex-col justify-center items-center mt-32">
            <div class="min-w-96 p-6 bg-white rounded-lg shadow-md">
                <div class="mb-4">
                    <h2 class="text-xl font-bold">Profile</h2>
                </div>
                <div class="mx-auto text-center">
                    <?php if ($image) : ?>
                        <img src="#" alt="Avatar" class="rounded-full mx-auto size-28 object-cover">
                    <?php else : ?>
                        <i class="fas fa-user-circle fa-5x"></i>
                    <?php endif; ?>
                </div>
                <div class="flex flex-col">
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Name:</label>
                        <span class="text-gray-900"><?php echo $name ?></span>
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Email:</label>
                        <span class="text-gray-900"><?php echo $email ?></span>
                    </div>
                    <form action="includes/login/logout.php">
                        <button type="submit" class="w-full bg-neutral-700 text-white font-semibold px-4 py-2 rounded cursor-pointer hover:bg-neutral-600 transition-colors duration-200">
                            Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </main>
</body>

</html>