<!-- Get contact  -->
<?php
require_once "includes/db.php";
require_once "includes/config-session.php";

// Check if the user is logged in
if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    die();
};

$contactId = $_GET["id"];

try {
    $query = "SELECT * FROM contacts WHERE id = $contactId;";
    $statement = $pdo->prepare($query);
    $statement->execute();
    $contact = $statement->fetch(PDO::FETCH_ASSOC);

    if (!$contact) {
        die("Contact not found.");
    }

    $name = htmlspecialchars($contact["name"]);
    $phone = htmlspecialchars($contact["phone_number"]);
    $email = htmlspecialchars($contact["email"]);
    $address = htmlspecialchars($contact["address"]);
    $age = htmlspecialchars($contact["age"]);
    $gender = htmlspecialchars($contact["gender"]);
    $avatar = htmlspecialchars($contact["avatar"]);
    $profession = htmlspecialchars($contact["profession"]);
} catch (PDOException $error) {
    die("Something went wrong! Please try again" . $error->getMessage());
}
?>

<!-- Update contact form -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://kit.fontawesome.com/3930858232.js" crossorigin="anonymous"></script>
    <title>Update contact - Phonebook</title>
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
    <main class="lg:w-3/4 lg:p-0 p-3 m-auto">
        <div>
            <a href="contacts.php" class="font-semibold">
                <i class="fas fa-arrow-left"></i>
                Back to Contacts List
            </a>
        </div>
        <div class="text-center pt-10">
            <h1 class="flex items-center justify-center gap-4 text-4xl font-bold">
                <i class="fa-solid fa-address-book"></i>
                <span>Update contact</span>
            </h1>
        </div>
        <section class="space-y-4 overflow-x-auto">
            <form action="includes/contacts/update-contact-handler.php" method="post" class="md:w-3/4 mx-auto flex flex-col gap-3 p-6 rounded-sm mt-10 bg-slate-100">
                <input type="hidden" name="id" value="<?= $contactId ?>">

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                    <div class="flex flex-col col-span-1">
                        <label for="name">Name:</label>
                        <input type="text" id="name" name="name" value="<?= $name ?>" autofocus placeholder="Enter name" class="p-2 focus:outline-none border rounded">
                    </div>
                    <div class="flex flex-col col-span-1">
                        <label for="phone">Phone:</label>
                        <input type="tel" id="phone" name="phone" value="<?= $phone ?>" placeholder="Enter phone number" class="p-2 focus:outline-none border rounded">
                    </div>
                    <div class="flex flex-col col-span-1">
                        <label for="email">Email:</label>
                        <input type="email" id="email" name="email" value="<?= $email ?>" placeholder="Enter email" class="p-2 focus:outline-none border rounded">
                    </div>
                    <div class="flex flex-col col-span-1">
                        <label for="age">Age:</label>
                        <input type="number" id="age" name="age" value="<?= $age ?>" placeholder="Enter age" class="p-2 focus:outline-none border rounded">
                    </div>
                    <div class="flex flex-col col-span-1 md:col-span-2">
                        <label for="address">Address:</label>
                        <input type="text" id="address" name="address" value="<?= $address ?>" placeholder="Enter name" class="p-2 focus:outline-none border rounded">
                    </div>
                    <div class="flex flex-col col-span-1">
                        <label for="gender" class="font-semibold text-lg">Gender:</label>
                        <select name="gender" id="gender" class="p-2 focus:outline-none border rounded" class="p-2 focus:outline-none border rounded">
                            <option value="">Select gender</option>
                            <option value="male" <?php echo ($gender == 'male') ? 'selected' : ''; ?>>Male</option>
                            <option value="female" <?php echo ($gender == 'female') ? 'selected' : ''; ?>>Female</option>
                            <option value="other" <?php echo ($gender == 'other') ? 'selected' : ''; ?>>Other</option>
                        </select>
                    </div>
                    <div class="flex flex-col col-span-1">
                        <label for="profession" class="font-semibold text-lg">Profession:</label>
                        <select name="profession" id="profession" class="p-2 focus:outline-none border rounded">
                            <option value="">Select profession</option>
                            <option value="student" <?php echo ($profession == 'student') ? 'selected' : ''; ?>>Student</option>
                            <option value="teacher" <?php echo ($profession == 'teacher') ? 'selected' : ''; ?>>Teacher</option>
                            <option value="engineer" <?php echo ($profession == 'engineer') ? 'selected' : ''; ?>>Engineer</option>
                            <option value="other" <?php echo ($profession == 'other') ? 'selected' : ''; ?>>Other</option>
                        </select>
                    </div>
                </div>
                <div class="flex gap-3 justify-end">
                    <button type="submit" class="bg-blue-400 text-white font-semibold px-4 py-1 rounded cursor-pointer hover:bg-blue-500 transition-colors duration-200">Update Contact</button>
                    <a href="contacts.php" class=" text-slate-200 bg-neutral-700 font-semibold px-4 py-1 rounded cursor-pointer hover:bg-neutral-600 transition-colors duration-200">Cancel</a>
                </div>
            </form>
            </form>
        </section>
    </main>
</body>

</html>