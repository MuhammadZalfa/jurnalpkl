<x-layout title="Dashboard Siswa - Jurnal PKL">
    <!-- Sidebar -->
    <x-sidebar-student />
    
    <!-- Main Content -->
    <div class="flex-1 flex flex-col">
        <x-header title="Dashboard" />
        
        <!-- Content -->
        <main class="flex-1 p-4 md:p-6">
            <h1 class="text-2xl font-bold text-gray-800 mb-6">Dashboard Siswa</h1>
            
            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-blue-500">
                    <div class="flex items-center">
                        <div class="bg-blue-100 p-3 rounded-lg mr-4">
                            <i class="fas fa-paper-plane text-blue-600 text-xl"></i>
                        </div>
                        <div>
                            <p class="text-gray-600">Jurnal Terkirim</p>
                            <p class="text-3xl font-bold">{{ $totalJournals }}</p>
                        </div>
                    </div>
                </div>
                
                <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-green-500">
                    <div class="flex items-center">
                        <div class="bg-green-100 p-3 rounded-lg mr-4">
                            <i class="fas fa-check-circle text-green-600 text-xl"></i>
                        </div>
                        <div>
                            <p class="text-gray-600">Jurnal Disetujui</p>
                            <p class="text-3xl font-bold">{{ $approvedJournals }}</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Action Buttons -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-8">
                <a href="{{ route('siswa.jurnal.create') }}" class="bg-gradient-to-r from-blue-500 to-blue-700 text-white p-6 rounded-xl shadow flex items-center justify-center transition duration-300 hover:shadow-lg">
                    <div class="text-center">
                        <i class="fas fa-plus-circle text-3xl mb-2"></i>
                        <span class="text-xl font-medium">Buat Jurnal Baru</span>
                    </div>
                </a>
                
                <a href="{{ route('siswa.riwayat') }}" class="bg-gradient-to-r from-green-500 to-green-700 text-white p-6 rounded-xl shadow flex items-center justify-center transition duration-300 hover:shadow-lg">
                    <div class="text-center">
                        <i class="fas fa-history text-3xl mb-2"></i>
                        <span class="text-xl font-medium">Lihat Riwayat Jurnal</span>
                    </div>
                </a>
            </div>
            
            <!-- Recent Journal -->
            <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                <div class="bg-green-600 text-white px-6 py-4">
                    <h3 class="text-lg font-semibold">Jurnal Terbaru</h3>
                </div>
                <div class="p-6">
                    @if($latestJournal)
                        <div class="border rounded-lg overflow-hidden mb-4">
                            <div class="bg-gray-50 px-4 py-3 border-b flex justify-between items-center">
                                <div>
                                    <span class="font-medium">Jurnal Hari ke-{{ $latestJournal->day_number }}</span>
                                    <span class="ml-3 text-sm text-gray-500">
                                        <i class="far fa-calendar mr-1"></i>{{ $latestJournal->date->format('d F Y') }}
                                    </span>
                                </div>
                                <span class="px-3 py-1 rounded-full text-sm 
                                    {{ $latestJournal->status === 'approved' ? 'bg-green-100 text-green-800' : 
                                       ($latestJournal->status === 'rejected' ? 'bg-red-100 text-red-800' : 'bg-yellow-100 text-yellow-800') }}">
                                    {{ $latestJournal->status === 'approved' ? 'Disetujui' : 
                                       ($latestJournal->status === 'rejected' ? 'Ditolak' : 'Menunggu Persetujuan') }}
                                </span>
                            </div>
                            <div class="p-4">
                                <div class="mb-3">
                                    <p class="font-medium text-gray-700 mb-1">Kegiatan:</p>
                                    <p class="text-gray-700">{{ $latestJournal->activity }}</p>
                                </div>
                                <div>
                                    <p class="font-medium text-gray-700 mb-1">Kendala:</p>
                                    <p class="text-gray-700">{{ $latestJournal->obstacle }}</p>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="text-center py-6 text-gray-500">
                            <i class="fas fa-book-open fa-2x mb-2"></i>
                            <p>Belum ada jurnal yang dibuat</p>
                        </div>
                    @endif
                    
                    <a href="{{ route('siswa.riwayat') }}" class="block mt-6 text-green-600 hover:text-green-800 font-medium text-center">
                        Lihat Semua Jurnal <i class="fas fa-arrow-right ml-2"></i>
                    </a>
                </div>
            </div>
        </main>
    </div>
</x-layout>