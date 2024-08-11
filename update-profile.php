<?php
require_once "includes/config-session.php";
require_once "includes/users/user.php";

// Check if the user is logged in
if (!$isLoggedIn) {
    header("Location: login.php");
    die();
}


$isAvatarExist = isset($user["avatar"]);
$name = $user["name"];
$displayname = explode(" ", trim($name))[0];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://kit.fontawesome.com/3930858232.js" crossorigin="anonymous"></script>
    <title>Update Profile - Phone book app</title>
</head>

<body class="min-w-full min-h-screen bg-neutral-200 text-neutral-700">
    <header class="flex justify-between items-center p-3">
        <h4 class="text-center text-xl font-bold">
            <a href="index.php">Phone Book App</a>
        </h4>
        <div>
            <?php
            if ($isLoggedIn) { ?>
                <?php if (!empty($isAvatarExist)) { ?>
                    <a href="profile.php?id=<?= $user_id ?>">
                        <img class="rounded-full size-12" src="uploads/users/<?= $user["avatar"] ?>" alt="Avatar">
                    </a>
                <?php } else { ?>
                    <div>
                        <span class="text-lg font-semibold"><span class="font-light">Logged in as</span> <?= $_SESSION["email"]; ?></span>
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
            <a href="profile.php" class="font-semibold">
                <i class="fas fa-arrow-left"></i>
                Back to Profile
            </a>
        </div>
        <div class="text-center pt-10">
            <h1 class="flex items-center justify-center gap-4 text-3xl font-bold">Update <?= $displayname . "'s" ?> profile</h1>
        </div>
        <div class="flex flex-col justify-center items-center mt-10">
            <div class="min-w-96 p-6 bg-white rounded-lg shadow-md">
                <form action="includes/users/user.php" enctype="multipart/form-data" method="post">
                    <div class="mb-4">
                        <label for="name" class="block text-gray-700 text-sm font-bold mb-2">Name</label>
                        <input type="text" id="name" name="name" value="<?= $name; ?>" class="appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" required>
                    </div>
                    <div class="mb-4 flex flex-col gap-3">
                        <label for="image" class="block text-gray-700 text-sm font-bold mb-2">User image</label>
                        <input type="file" id="image" name="image" accept="image/png, image/jpeg, image/webp, image/jpg">
                        <small class="text-gray-500">Only .png, .jpg, .jpeg, .webp images are allowed!</small>
                    </div>
                    <div class="grid grid-cols-2 gap-3">
                        <button type="submit" class="bg-blue-600 text-white font-semibold px-4 py-2 rounded hover:bg-blue-500 transition-colors duration-200">
                            <i class="fa fa-refresh pr-2"></i>
                            Update Profile
                        </button>
                        <a href="profile.php" class="block text-center bg-neutral-700 text-white font-semibold px-4 py-2 rounded hover:bg-neutral-600 transition-colors duration-200">
                            <i class="fa fa-times pr-2"></i>
                            Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </main>
</body>

</html>