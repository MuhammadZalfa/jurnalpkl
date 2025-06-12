<x-layout title="Dashboard Admin - Jurnal PKL">
    <!-- Sidebar -->
    <x-sidebar-admin />
    
    <!-- Main Content -->
    <div class="flex-1 flex flex-col">
        <x-header-admin title="Dashboard" />
        
        <!-- Content -->
        <main class="flex-1 p-4 md:p-6">
            <h1 class="text-2xl font-bold text-gray-800 mb-6">Dashboard Admin</h1>
            
            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <x-stat-card 
                    color="blue" 
                    icon="fa-book" 
                    title="Total Jurnal" 
                    value="128" 
                />
                
                <x-stat-card 
                    color="green" 
                    icon="fa-users" 
                    title="Total Siswa" 
                    value="42" 
                />
                
                <x-stat-card 
                    color="yellow" 
                    icon="fa-clock" 
                    title="Pending Approval" 
                    value="8" 
                />
            </div>
            
            <!-- Recent Activity -->
            <div class="bg-white rounded-xl shadow-lg overflow-hidden mb-6">
                <div class="bg-blue-600 text-white px-6 py-4">
                    <h3 class="text-lg font-semibold">Aktivitas Terbaru</h3>
                </div>
                <div class="p-6">
                    <div class="space-y-4">
                        @foreach([1,2,3] as $activity)
                        <div class="flex items-start">
                            <div class="bg-blue-100 text-blue-600 p-3 rounded-full mr-4">
                                <i class="fas fa-book"></i>
                            </div>
                            <div class="flex-1">
                                <p class="font-medium">Budi Santoso</p>
                                <p class="text-gray-600">Mengirim jurnal hari ke-{{ 15 + $activity }}</p>
                                <p class="text-sm text-gray-500">{{ $activity }} jam yang lalu</p>
                            </div>
                            <span class="bg-yellow-100 text-yellow-800 px-3 py-1 rounded-full text-sm">
                                Menunggu
                            </span>
                        </div>
                        @endforeach
                    </div>
                    <a href="#" class="block mt-6 text-blue-600 hover:text-blue-800 font-medium text-center">
                        Lihat Semua Aktivitas <i class="fas fa-arrow-right ml-2"></i>
                    </a>
                </div>
            </div>
        </main>
    </div>
</x-layout>