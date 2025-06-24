<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile Settings</title>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans&display=swap" rel="stylesheet">
    @vite('resources/css/app.css')
    <style>
        body {
            font-family: 'Noto Sans', sans-serif;
        }
    </style>
</head>
<body class="bg-white text-gray-800">
    <div class="min-h-screen bg-white px-4 py-6">
        <div class="max-w-7xl mx-auto flex flex-row" x-data="{ tab: 'personal' }">

            <!-- Sidebar: reduced to 180px -->
            <aside class="w-[180px] border-r border-gray-200 p-3 space-y-2 bg-white">
                <button @click="tab = 'personal'" class="w-full text-left px-3 py-2 rounded hover:bg-blue-100"
                    :class="{ 'bg-blue-100 font-semibold': tab === 'personal' }">Personal details</button>
                <button @click="tab = 'security'" class="w-full text-left px-3 py-2 rounded hover:bg-blue-100"
                    :class="{ 'bg-blue-100 font-semibold': tab === 'security' }">Security settings</button>
                <button @click="tab = 'travellers'" class="w-full text-left px-3 py-2 rounded hover:bg-blue-100"
                    :class="{ 'bg-blue-100 font-semibold': tab === 'travellers' }">Other travellers</button>
                <button @click="tab = 'customisation'" class="w-full text-left px-3 py-2 rounded hover:bg-blue-100"
                    :class="{ 'bg-blue-100 font-semibold': tab === 'customisation' }">Customisation</button>
                <button @click="tab = 'payment'" class="w-full text-left px-3 py-2 rounded hover:bg-blue-100"
                    :class="{ 'bg-blue-100 font-semibold': tab === 'payment' }">Payment methods</button>
                <button @click="tab = 'privacy'" class="w-full text-left px-3 py-2 rounded hover:bg-blue-100"
                    :class="{ 'bg-blue-100 font-semibold': tab === 'privacy' }">Privacy & data</button>
            </aside>

            <!-- Content Section: fills remaining space -->
            <main class="flex-1 bg-white p-6 space-y-8">
                <!-- Personal details -->
                <section x-show="tab === 'personal'" x-cloak>
                    <h2 class="text-xl font-bold">Personal details</h2>
                    <!-- Add form or content here -->
                </section>

                <!-- Other Sections -->
                <section x-show="tab === 'security'" x-cloak>
                    <h2 class="text-xl font-bold">Security settings</h2>
                </section>
                <section x-show="tab === 'travellers'" x-cloak>
                    <h2 class="text-xl font-bold">Other travellers</h2>
                </section>
                <section x-show="tab === 'customisation'" x-cloak>
                    <h2 class="text-xl font-bold">Customisation preferences</h2>
                </section>
                <section x-show="tab === 'payment'" x-cloak>
                    <h2 class="text-xl font-bold">Payment methods</h2>
                </section>
                <section x-show="tab === 'privacy'" x-cloak>
                    <h2 class="text-xl font-bold">Privacy and data management</h2>
                </section>
            </main>

        </div>
    </div>
</body>

</html>
