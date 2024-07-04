<?php
require_once "includes/config-session.php";
?>

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

<body class="min-w-full min-h-screen bg-neutral-100 text-neutral-700">
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
    <main class="flex items-center justify-center mt-32">
        <div class="p-6">
            <h3 class="text-5xl font-bold ">Welcome to Phone Book App</h3>
            <h5 class="text-center mt-8">
                <a href="contacts.php" class="bg-neutral-700 text-white font-semibold px-4 py-2 rounded cursor-pointer hover:bg-neutral-600 transition-colors duration-200">Vew your contacts!</a>
            </h5>
        </div>
    </main>
</body>

</html>