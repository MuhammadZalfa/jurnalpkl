<!-- resources/views/components/header-instructor.blade.php -->
<div class="bg-white shadow-sm">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center py-4">
            <div class="flex items-center">
                <!-- Mobile menu button -->
                <button @click="sidebarOpen = true" class="md:hidden text-gray-500 focus:outline-none">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
                <h1 class="text-xl font-semibold text-gray-800 ml-4 md:ml-0">Jurnal PKL</h1>
            </div>
            <div class="flex items-center space-x-4">
                <!-- Notifications -->
                <button class="text-gray-500 hover:text-gray-700 focus:outline-none">
                    <i class="fas fa-bell"></i>
                </button>
                <!-- User dropdown -->
                <div class="relative" x-data="{ open: false }">
                    <button @click="open = !open" class="flex items-center space-x-2 focus:outline-none">
                        <div class="bg-blue-600 text-white w-8 h-8 rounded-full flex items-center justify-center">
                            <i class="fas fa-user-tie"></i>
                        </div>
                        <span class="hidden md:inline text-gray-700">{{ auth()->user()->name }}</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>