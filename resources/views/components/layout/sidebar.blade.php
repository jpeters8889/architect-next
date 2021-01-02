<div :class="sidebarOpen ? 'translate-x-0 ease-out' : '-translate-x-full ease-in'"
     class="fixed z-30 inset-y-0 left-0 w-64 transition duration-300 transform bg-gray-900 overflow-y-auto lg:translate-x-0 lg:static lg:inset-0">
    <div class="flex items-center justify-center mt-8">
        <!-- logo -->
        <div class="flex items-center">
            <span class="text-white text-2xl mx-2 font-semibold">Architect</span>
        </div>
    </div>

    <x-architect::layout.sidebar.navigation />
</div>
