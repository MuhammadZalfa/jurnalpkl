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
                    :value="$journalCount" 
                />
                
                <x-stat-card 
                    color="green" 
                    icon="fa-users" 
                    title="Total Siswa" 
                    :value="$studentCount" 
                />
                
                <x-stat-card 
                    color="yellow" 
                    icon="fa-clock" 
                    title="Pending Approval" 
                    :value="$pendingJournalCount" 
                />
            </div>
            
            <!-- Students List -->
            <div class="bg-white rounded-xl shadow-lg overflow-hidden mb-6">
                <div class="bg-blue-600 text-white px-6 py-4">
                    <h3 class="text-lg font-semibold">Daftar Siswa Bimbingan Anda</h3>
                </div>
                <div class="p-6">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">NISN</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jurusan</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">DUDI</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($students as $student)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="text-sm font-medium text-gray-900">{{ $student->name }}</div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-500">{{ $student->ni }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-500">{{ $student->jurusan }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-500">{{ $student->dudi }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        <a href="{{ route('admin.jurnal.student', $student->id) }}" class="text-blue-600 hover:text-blue-900">Lihat Jurnal</a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-4 text-center text-sm text-gray-500">
                                        Tidak ada siswa yang dibimbing
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            
            <!-- Recent Journals -->
            <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                <div class="bg-blue-600 text-white px-6 py-4">
                    <h3 class="text-lg font-semibold">Jurnal Terbaru dari Siswa Bimbingan</h3>
                </div>
                <div class="p-6">
                    <div class="space-y-4">
                        @forelse($recentJournals as $journal)
                        <div class="flex items-start">
                            <div class="bg-blue-100 text-blue-600 p-3 rounded-full mr-4">
                                <i class="fas fa-book"></i>
                            </div>
                            <div class="flex-1">
                                <p class="font-medium">{{ $journal->user->name }}</p>
                                <p class="text-gray-600">{{ $journal->activity }}</p>
                                <p class="text-sm text-gray-500">{{ $journal->date->format('d M Y') }} - Hari ke-{{ $journal->day_number }}</p>
                            </div>
                            <span class="{{ $journal->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 'bg-green-100 text-green-800' }} px-3 py-1 rounded-full text-sm">
                                {{ $journal->status === 'pending' ? 'Menunggu' : 'Disetujui' }}
                            </span>
                        </div>
                        @empty
                        <p class="text-gray-500 text-center">Tidak ada jurnal terbaru</p>
                        @endforelse
                    </div>
                    @if($recentJournals->count() > 0)
                    <a href="{{ route('admin.jurnal') }}" class="block mt-6 text-blue-600 hover:text-blue-800 font-medium text-center">
                        Lihat Semua Jurnal <i class="fas fa-arrow-right ml-2"></i>
                    </a>
                    @endif
                </div>
            </div>
        </main>
    </div>
</x-layout>