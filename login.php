<?php
require_once "includes/config-session.php";
require_once "includes/login/login-view.php";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://kit.fontawesome.com/3930858232.js" crossorigin="anonymous"></script>
    <title>Login - Phone book app</title>
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
    <main class="flex flex-col items-center justify-center gap-2 mt-20">
        <div>
            <h3 class="text-xl font-bold text-center">Login</h3>
        </div>
        <form action="includes/login/login.php" method="post" class="bg-white min-w-96 p-6 rounded flex flex-col gap-3">
            <div class="flex flex-col gap-1">
                <label for="email" class="font-semibold">Email:</label>
                <input type="email" id="email" name="email" required class="border-2 border-neutral-300 focus:outline-none rounded px-2 py-1">
            </div>
            <div class="flex flex-col gap-1">
                <label for="password" class="font-semibold">Password:</label>
                <input type="password" id="password" name="password" required class="border-2 border-neutral-300 focus:outline-none rounded px-2 py-1">
            </div>
            <div class="flex justify-center gap-1">
                <button type="submit" class="bg-blue-500 text-white font-semibold px-4 py-2 rounded cursor-pointer hover:bg-blue-400 transition-colors duration-200 w-full">Login</button>
        </form>
    </main>
    <div class="text-center mt-3">
        <p class="text-sm font-semibold">
            Don't have an account? <a href="signup.php" class="font-bold">Signup here.</a>
        </p>
    </div>
    <div class="text-center text-sm font-semibold">
        <?php
        checkLoginErrors()
        ?>
    </div>
</body>

</html>