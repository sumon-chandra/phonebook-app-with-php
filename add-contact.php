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

<body class="min-w-full min-h-screen bg-slate-200 text-neutral-700">
    <main class="lg:w-1/2 lg:p-0 p-3 m-auto">
        <header class="text-center pt-10">
            <h1 class="flex items-center justify-center gap-4 text-4xl font-bold">
                <i class="fa-solid fa-address-book"></i>
                <span>Add contact</span>
            </h1>
        </header>
        <section class="space-y-4 overflow-x-auto">
            <form action="includes/contact-form-handler.php" method="post" class="flex flex-col gap-3">
                <div class="flex flex-col">
                    <label for="name">Name:</label>
                    <input type="text" id="name" name="name" required>
                </div>
                <div class="flex flex-col">
                    <label for="phone">Phone:</label>
                    <input type="tel" id="phone" name="phone" required>
                </div>
                <div class="flex flex-col">
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" required>
                </div>
                <div class="flex flex-col">
                    <label for="address">Address:</label>
                    <input type="text" id="address" name="address">
                </div>
                <div class="flex justify-end">
                    <button type="submit" class="bg-blue-400 text-white font-semibold px-4 py-1 rounded cursor-pointer hover:bg-blue-500 transition-colors duration-200">Add Contact</button>
                </div>
            </form>
            </form>
        </section>
    </main>
</body>

</html>