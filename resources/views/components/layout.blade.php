<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">

    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=yes"/>

    <title>{{ config('architect.name') }}</title>

    <link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.8.0/dist/alpine.min.js" defer></script>
</head>
<body class="">
<div x-data="{ sidebarOpen: false }" class="flex h-screen bg-gray-200">
    <div :class="sidebarOpen ? 'block' : 'hidden'" @click="sidebarOpen = false"
         class="fixed z-20 inset-0 bg-black opacity-50 transition-opacity lg:hidden"></div>

    <x-architect::layout.sidebar />

    <div class="flex-1 flex flex-col overflow-hidden">
        <x-architect::layout.header />

        <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-200">
            <div class="container mx-auto px-6 py-8">
                <h3 class="text-gray-700 text-3xl font-medium">Dashboard</h3>

                {{ $slot }}
            </div>
        </main>

        <div class="text-xs text-center text-gray-500 pb-2">
            Architect - Dev Build
        </div>
    </div>
</div>
</body>
</html>
