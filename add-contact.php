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
            <form action="includes/add-contact-handler.php" method="post" class="flex flex-col gap-3 p-6 rounded-sm mt-10 bg-slate-100">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="flex flex-col col-span-1">
                        <label for="name" class="font-semibold text-lg">Name:</label>
                        <input type="text" id="name" name="name" autofocus required placeholder="Enter name" class="p-2 focus:outline-none border rounded">
                    </div>
                    <div class="flex flex-col col-span-1">
                        <label for="phone" class="font-semibold text-lg">Phone:</label>
                        <input type="tel" id="phone" name="phone" required placeholder="Enter phone number" class="p-2 focus:outline-none border rounded">
                    </div>
                    <div class="flex flex-col col-span-1">
                        <label for="email" class="font-semibold text-lg">Email:</label>
                        <input type="email" id="email" name="email" required placeholder="Enter email" class="p-2 focus:outline-none border rounded">
                    </div>
                    <div class="flex flex-col col-span-1">
                        <label for="age" class="font-semibold text-lg">Age:</label>
                        <input type="number" id="age" name="age" placeholder="Enter age" class="p-2 focus:outline-none border rounded">
                    </div>
                    <div class="flex flex-col md:col-span-2">
                        <label for="address" class="font-semibold text-lg">Address:</label>
                        <input type="text" id="address" name="address" placeholder="Enter address" class="p-2 focus:outline-none border rounded">
                    </div>
                    <div class="flex flex-col col-span-1">
                        <label for="gender" class="font-semibold text-lg">Gender:</label>
                        <select name="gender" id="gender" class="p-2 focus:outline-none border rounded">
                            <option value="">Select gender</option>
                            <option value="male">Male</option>
                            <option value="female">Female</option>
                            <option value="other">Other</option>
                        </select>
                    </div>
                    <div class="flex flex-col col-span-1">
                        <label for="profession" class="font-semibold text-lg">Profession:</label>
                        <select name="profession" id="profession" class="p-2 focus:outline-none border rounded">
                            <option value="">Select profession</option>
                            <option value="student">Student</option>
                            <option value="teacher">Teacher</option>
                            <option value="engineer">Engineer</option>
                            <option value="other">Other</option>
                        </select>
                    </div>
                </div>
                <div class="flex gap-3 justify-end">
                    <button type="submit" class="bg-blue-400 text-white font-semibold px-4 py-1 rounded cursor-pointer hover:bg-blue-500 transition-colors duration-200">Add Contact</button>
                    <a href="contacts.php" class=" text-slate-200 bg-neutral-700 font-semibold px-4 py-1 rounded cursor-pointer hover:bg-neutral-600 transition-colors duration-200">Cancel</a>
                </div>
            </form>
            </form>
        </section>
    </main>
</body>

</html>