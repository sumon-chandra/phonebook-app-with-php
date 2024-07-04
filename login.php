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

<body class="min-w-full min-h-screen bg-neutral-100 text-neutral-700">
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
        <p class="text-sm font-semibold">
            <a href="index.php" class="font-bold">Go to home page.</a>
        </p>
    </div>
    <div class="text-center text-sm font-semibold">
        <?php
        checkLoginErrors();
        if (isset($_SESSION["login_error"])) {
            unset($_SESSION["login_error"]);
        }
        ?>
    </div>
</body>

</html>