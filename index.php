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

<body class="min-w-full min-h-screen bg-slate-200 text-neutral-700">
    <main class="lg:w-1/2 lg:p-0 p-3 m-auto">
        <header class="text-center pt-10">
            <h1 class="flex items-center justify-center gap-4 text-4xl font-bold">
                <i class="fa-solid fa-address-book"></i>
                <span>Phone Book App</span>
            </h1>
        </header>
        <section class="space-y-4 overflow-x-auto">
            <div class="flex justify-between items-start mt-10">
                <h3 class="text-xl font-semibold">Contacts</h3>
                <button class="bg-blue-400 text-white font-semibold px-4 py-1 rounded cursor-pointer hover:bg-blue-500 transition-colors duration-200">
                    <a href="add-contact.php">+ Add contact</a>
                </button>
            </div>
            <div class="border bg-white px-3 py-1 rounded font-semibold flex items-center justify-start gap-3">
                <i class="fa-solid fa-magnifying-glass"></i>
                <input type="text" placeholder="Search contacts" class="w-full focus:outline-none">
            </div>
            <table class="table-auto w-full overflow-x-scroll">
                <thead>
                    <tr>
                        <th class="text-start px-4 py-2">Name</th>
                        <th class="text-start px-4 py-2">Phone</th>
                        <th class="text-start px-4 py-2">Email</th>
                        <th class="text-start px-4 py-2">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white">
                    <tr class="border rounded">
                        <td class="px-4 py-2">John Deo</td>
                        <td class="px-4 py-2">+ 45634523</td>
                        <td class="px-4 py-2">johndeo@gmail.com</td>
                        <td class="px-4 py-2">Sylhet, Bangladesh</td>
                        <td class="px-4 py-2">
                            <button title="Edit contact" class="text-blue-400 font-semibold px-2 py-1 rounded cursor-pointer transition-colors duration-200">
                                <i class="fa-solid fa-pen-to-square"></i>
                            </button>
                            <button title="Delete contact" class="text-red-400 font-semibold px-2 py-1 rounded cursor-pointer transition-colors duration-200">
                                <i class="fa-solid fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </section>
    </main>
</body>

</html>