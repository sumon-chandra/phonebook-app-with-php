<?php
require_once "includes/db.php";
require_once "includes/config-session.php";
// require_once "./includes/contacts/get-contact.php";

// Check if the user is logged in
if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    die();
};

if (isset($_GET["id"])) {
    try {
        $id = $_GET['id'];

        // Get the contact
        $query = "SELECT * FROM contacts WHERE id = $id";
        $statement = $pdo->prepare($query);
        $statement->execute();
        $contact = $statement->fetch(PDO::FETCH_ASSOC);

        // Get professions
        $query = "SELECT * FROM professions WHERE contact_id = :contact_id";
        $statement = $pdo->prepare($query);
        $statement->bindParam(":contact_id", $contact["id"]);
        $statement->execute();
        $profession = $statement->fetch(PDO::FETCH_ASSOC);

        // Get genders
        $query = "SELECT * FROM genders WHERE contact_id = :contact_id";
        $statement = $pdo->prepare($query);
        $statement->bindParam(":contact_id", $contact["id"]);
        $statement->execute();
        $gender = $statement->fetch(PDO::FETCH_ASSOC);

        // Get blood groups
        $query = "SELECT * FROM blood_groups WHERE contact_id = :contact_id";
        $statement = $pdo->prepare($query);
        $statement->bindParam(":contact_id", $contact["id"]);
        $statement->execute();
        $blood_group = $statement->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $error) {
        header("Location: contacts.php");
        die("Failed to load contact" . $error->getMessage());
    }
} else {
    header("Location: contacts.php");
    die();
}

$name = htmlspecialchars($contact["name"]);
$email = htmlspecialchars($contact["email"]);
$phone_number = htmlspecialchars($contact["phone_number"]);
$age = htmlspecialchars($contact["age"]);
$profession = htmlspecialchars($profession["profession"]);
$gender = htmlspecialchars($gender["gender"]);
$bloodGroup = htmlspecialchars($blood_group["blood_group"]);
$avatar = htmlspecialchars($contact["avatar"]);
$id = $contact["id"];

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <script defer src="js/script.js"></script>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://kit.fontawesome.com/3930858232.js" crossorigin="anonymous"></script>
    <title>Contacts - Phone book app</title>
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
        <section class=" mt-10">
            <div class="flex flex-col items-start gap-2">
                <div class="mx-auto text-center">
                    <?php if (!empty($contact['avatar'])) : ?>
                        <img src="<?= $avatar ?>" alt="Avatar" class="rounded-full mx-auto" style="max-width: 100px;">
                    <?php else : ?>
                        <i class="fas fa-user-circle fa-5x"></i>
                    <?php endif; ?>
                    <h3 class="text-lg font-bold"><?= htmlspecialchars($contact['name']) ?></h3>
                </div>

                <div class="flex flex-col gap-4 font-semibold text-lg">
                    <p>Email: <?= $email ?></p>
                    <p>Phone Number: <?= $phone_number ?></p>
                    <p>Age: <?= $age ? $age . "Years old" : "N/A" ?></p>
                    <p>Profession: <?= $profession ?  ucfirst($profession) : "N/A" ?></p>
                    <p>Gender: <?= $gender ?  ucfirst($gender) : "N/A" ?></p>
                    <p>Blood Group: <?= $bloodGroup ?  $bloodGroup : "N/A" ?></p>
                </div>
                <div class="flex justify-center gap-2 mt-8">
                    <a href="update-contact.php?id=<?= $id ?>" class="bg-neutral-700 text-white font-semibold px-4 py-2 rounded cursor-pointer hover:bg-neutral-600 transition-colors duration-200">Edit</a>
                </div>
            </div>
        </section>
    </main>
</body>

</html>