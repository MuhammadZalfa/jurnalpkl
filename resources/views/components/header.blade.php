<!-- Mobile Header -->
<header class="bg-green-800 md:hidden">
    <div class="flex items-center justify-between p-4">
        <button id="mobile-menu-button" class="text-white focus:outline-none">
            <div class="hamburger w-6 h-5 flex flex-col justify-between">
                <span class="hamburger-line block w-full h-0.5 bg-white rounded"></span>
                <span class="hamburger-line block w-full h-0.5 bg-white rounded"></span>
                <span class="hamburger-line block w-full h-0.5 bg-white rounded"></span>
            </div>
        </button>
        <h1 class="text-white font-bold">Jurnal PKL</h1>
        <div class="w-6"></div>
    </div>
</header>

<!-- Desktop Header -->
<header class="bg-white shadow hidden md:block">
    <div class="flex justify-between items-center p-4">
        <div class="flex items-center space-x-4">
            <h2 class="text-xl font-bold text-gray-800">{{ $title ?? 'Dashboard' }}</h2>
            <div class="text-sm text-gray-500">
                <i class="far fa-calendar mr-1"></i>
                {{ now()->format('l, d F Y') }}
            </div>
        </div>
        <div class="flex items-center space-x-4">
            <button class="p-2 rounded-full hover:bg-gray-100 relative">
                <i class="far fa-bell text-gray-600"></i>
                <span class="absolute top-1 right-1 w-2 h-2 bg-red-500 rounded-full"></span>
            </button>
            <div class="flex items-center space-x-2">
                <div class="w-8 h-8 rounded-full bg-green-600 flex items-center justify-center text-white">
                    {{ substr(auth()->user()->name, 0, 1) }}
                </div>
                <span class="font-medium">{{ auth()->user()->name }}</span>
            </div>
        </div>
    </div>
</header>