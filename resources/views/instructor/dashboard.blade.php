<x-layout title="Dashboard Instruktur - Jurnal PKL">
    <x-sidebar-instructor />
    
    <div class="flex-1 flex flex-col">
        <x-header-instructor title="Dashboard" />
        
        <main class="flex-1 p-4 md:p-6">
            <h1 class="text-2xl font-bold text-gray-800 mb-6">Dashboard Instruktur {{ auth()->user()->name }}</h1>
            
            <!-- Debug Info -->
            @if(config('app.debug'))
            <div class="bg-blue-50 border-l-4 border-blue-400 p-4 mb-6 rounded">
                <div class="flex items-center">
                    <svg class="h-5 w-5 text-blue-400 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2h-1V9z" clip-rule="evenodd" />
                    </svg>
                    <span class="font-semibold">Debug Info:</span>
                </div>
                <div class="mt-2 text-sm text-blue-700">
                    <p>DUDI Anda: <span class="font-bold">{{ $instructorDudi ?? 'N/A' }}</span></p>
                    <p>Jumlah Siswa: {{ $studentCount }}</p>
                </div>
            </div>
            @endif
            
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
                    title="Siswa Bimbingan" 
                    :value="$studentCount" 
                />
                
                <x-stat-card 
                    color="yellow" 
                    icon="fa-clock" 
                    title="Jurnal Belum Dinilai" 
                    :value="$pendingJournalCount" 
                />
            </div>
            
            <!-- Students List -->
            <div class="bg-white rounded-xl shadow-lg overflow-hidden mb-6">
                <div class="bg-blue-600 text-white px-6 py-4">
                    <h3 class="text-lg font-semibold">Daftar Siswa Bimbingan Anda</h3>
                    <p class="text-sm opacity-80 mt-1">DUDI: {{ $instructorDudi }}</p>
                </div>
                <div class="p-6">
                    @if($students->isEmpty())
                    <div class="text-center py-8">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                        <h3 class="mt-2 text-sm font-medium text-gray-900">Tidak ada siswa</h3>
                        <p class="mt-1 text-sm text-gray-500">Tidak ditemukan siswa dengan DUDI yang sama dengan Anda.</p>
                    </div>
                    @else
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
                                @foreach($students as $student)
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
                                        <div class="flex space-x-4">
                                            <a href="{{ route('instructor.journals.student', $student->id) }}" class="text-blue-600 hover:text-blue-900">Jurnal</a>
                                            <a href="{{ route('instructor.attendances.student', $student->id) }}" class="text-green-600 hover:text-green-900">Absensi</a>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @endif
                </div>
            </div>
            
            <!-- Recent Attendances -->
            <div class="bg-white rounded-xl shadow-lg overflow-hidden mb-6">
                <div class="bg-blue-600 text-white px-6 py-4">
                    <h3 class="text-lg font-semibold">Daftar Hadir Terbaru</h3>
                </div>
                <div class="p-6">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Siswa</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jam Masuk</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jam Pulang</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Durasi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($recentAttendances as $attendance)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900">{{ $attendance->student->name }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-500">{{ $attendance->date->format('d M Y') }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-500">{{ $attendance->time_in }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-500">{{ $attendance->time_out ?? '-' }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-500">{{ $attendance->duration_formatted }}</div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-4 text-center text-sm text-gray-500">
                                        Tidak ada data kehadiran
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    @if($recentAttendances->count() > 0)
                    <a href="{{ route('instructor.attendances') }}" class="block mt-6 text-blue-600 hover:text-blue-800 font-medium text-center">
                        Lihat Semua Daftar Hadir <i class="fas fa-arrow-right ml-2"></i>
                    </a>
                    @endif
                </div>
            </div>
            
            <!-- Recent Journals -->
            <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                <div class="bg-blue-600 text-white px-6 py-4">
                    <h3 class="text-lg font-semibold">Jurnal Terbaru</h3>
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
                            <div class="flex items-center">
                                <span class="px-2 py-1 text-xs rounded-full 
                                    {{ $journal->status === 'approved' ? 'bg-green-100 text-green-800' : 
                                       ($journal->status === 'rejected' ? 'bg-red-100 text-red-800' : 'bg-yellow-100 text-yellow-800') }}">
                                    {{ $journal->status === 'approved' ? 'Disetujui' : 
                                      ($journal->status === 'rejected' ? 'Ditolak' : 'Menunggu') }}
                                </span>
                            </div>
                        </div>
                        @empty
                        <p class="text-gray-500 text-center">Tidak ada jurnal terbaru</p>
                        @endforelse
                    </div>
                    @if($recentJournals->count() > 0)
                    <a href="{{ route('instructor.journals') }}" class="block mt-6 text-blue-600 hover:text-blue-800 font-medium text-center">
                        Lihat Semua Jurnal <i class="fas fa-arrow-right ml-2"></i>
                    </a>
                    @endif
                </div>
            </div>
        </main>
    </div>
</x-layout>