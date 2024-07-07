<?php
require_once "includes/config-session.php";
require_once "includes/users/get-user-image.php";


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
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://kit.fontawesome.com/3930858232.js" crossorigin="anonymous"></script>
    <title>Phone book app</title>
</head>

<body class="min-w-full min-h-screen bg-neutral-100 text-neutral-700">
    <header class="flex justify-between items-center p-3">
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