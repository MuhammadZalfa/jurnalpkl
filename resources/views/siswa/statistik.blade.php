<x-layout title="Statistik PKL - Jurnal PKL">
    <!-- Sidebar -->
    <x-sidebar-student />
    
    <!-- Main Content -->
    <div class="flex-1 flex flex-col">
        <x-header title="Statistik PKL" />
        
        <!-- Content -->
        <main class="flex-1 p-4 md:p-6">
            <div class="max-w-6xl mx-auto">
                <!-- Warning Alert -->
                <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 mb-6 rounded-lg">
                    <div class="flex items-start">
                        <div class="flex-shrink-0 mt-0.5">
                            <i class="fas fa-exclamation-circle text-yellow-500"></i>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-yellow-800">Penting!</h3>
                            <div class="mt-1 text-sm text-yellow-700">
                                <p>• Absensi dan jurnal harus diisi setiap hari PKL</p>
                                <p>• Absensi membuktikan kehadiran fisik Anda</p>
                                <p>• Jurnal mendokumentasikan kegiatan harian</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Consistency Check -->
                <div class="bg-white rounded-xl shadow-lg overflow-hidden border border-gray-100 mb-6">
                    <div class="bg-gradient-to-r from-purple-600 to-purple-800 text-white px-6 py-4">
                        <h3 class="text-lg font-semibold">Konsistensi Harian</h3>
                        <p class="text-purple-100 text-sm mt-1">Status kelengkapan laporan harian Anda</p>
                    </div>
                    <div class="p-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Days Missing Journal -->
                            <div class="border border-red-200 rounded-lg p-4 bg-red-50">
                                <div class="flex items-center justify-between mb-2">
                                    <h4 class="font-medium text-red-800 flex items-center">
                                        <i class="fas fa-book-medical mr-2"></i> Hari Tanpa Jurnal
                                    </h4>
                                    <span class="bg-red-100 text-red-800 px-2.5 py-1 rounded-full text-xs font-semibold">{{ $daysMissingJournalCount }} Hari</span>
                                </div>
                                <p class="text-sm text-red-600 mb-3">
                                    Anda absen tetapi belum mengisi jurnal pada hari-hari berikut:
                                </p>
                                <ul class="space-y-2">
                                    @forelse($daysMissingJournal as $attendance)
                                        <li class="flex items-start">
                                            <span class="bg-red-100 text-red-800 rounded-full p-1 mr-2">
                                                <i class="fas fa-calendar-day text-xs w-4 h-4 flex items-center justify-center"></i>
                                            </span>
                                            <div>
                                                <p class="text-sm font-medium text-red-800">{{ $attendance->date->translatedFormat('l, j F Y') }}</p>
                                                <p class="text-xs text-red-600">Absensi: Masuk ({{ $attendance->time_in }})</p>
                                            </div>
                                        </li>
                                    @empty
                                        <li class="text-sm text-gray-600">Tidak ada hari tanpa jurnal</li>
                                    @endforelse
                                </ul>
                                <div class="mt-3 pt-2 border-t border-red-200">
                                    <a href="{{ route('siswa.riwayat') }}" class="text-red-600 hover:text-red-800 text-sm font-medium flex items-center">
                                        <i class="fas fa-plus-circle mr-1"></i> Buat Jurnal untuk Hari Ini
                                    </a>
                                </div>
                            </div>
                            
                            <!-- Days Missing Attendance -->
                            <div class="border border-blue-200 rounded-lg p-4 bg-blue-50">
                                <div class="flex items-center justify-between mb-2">
                                    <h4 class="font-medium text-blue-800 flex items-center">
                                        <i class="fas fa-user-clock mr-2"></i> Hari Tanpa Absensi
                                    </h4>
                                    <span class="bg-blue-100 text-blue-800 px-2.5 py-1 rounded-full text-xs font-semibold">{{ $daysMissingAttendanceCount }} Hari</span>
                                </div>
                                <p class="text-sm text-blue-600 mb-3">
                                    Anda mengisi jurnal tetapi belum absen pada hari berikut:
                                </p>
                                <ul class="space-y-2">
                                    @forelse($daysMissingAttendance as $journal)
                                        <li class="flex items-start">
                                            <span class="bg-blue-100 text-blue-800 rounded-full p-1 mr-2">
                                                <i class="fas fa-calendar-day text-xs w-4 h-4 flex items-center justify-center"></i>
                                            </span>
                                            <div>
                                                <p class="text-sm font-medium text-blue-800">{{ $journal->date->translatedFormat('l, j F Y') }}</p>
                                                <p class="text-xs text-blue-600">Jurnal: "{{ Str::limit($journal->activity, 20) }}"</p>
                                            </div>
                                        </li>
                                    @empty
                                        <li class="text-sm text-gray-600">Tidak ada hari tanpa absensi</li>
                                    @endforelse
                                </ul>
                                <div class="mt-3 pt-2 border-t border-blue-200">
                                    <a href="{{ route('siswa.absensi') }}" class="text-blue-600 hover:text-blue-800 text-sm font-medium flex items-center">
                                        <i class="fas fa-edit mr-1"></i> Isi Absensi Hari Ini
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Overview Cards -->
                <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
                    <!-- Total Hari -->
                    <div class="bg-white rounded-xl shadow-lg overflow-hidden border border-gray-100">
                        <div class="bg-gradient-to-r from-blue-600 to-blue-800 text-white px-6 py-4">
                            <h3 class="text-lg font-semibold">Total Hari PKL</h3>
                        </div>
                        <div class="p-6 flex items-center justify-between">
                            <div>
                                <p class="text-3xl font-bold text-gray-800">{{ $totalDays }}</p>
                                <p class="text-sm text-gray-500">Hari Kerja</p>
                            </div>
                            <div class="bg-blue-100 p-3 rounded-full">
                                <i class="fas fa-calendar-alt text-blue-600 text-xl"></i>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Hari Lengkap -->
                    <div class="bg-white rounded-xl shadow-lg overflow-hidden border border-gray-100">
                        <div class="bg-gradient-to-r from-green-600 to-green-800 text-white px-6 py-4">
                            <h3 class="text-lg font-semibold">Hari Lengkap</h3>
                        </div>
                        <div class="p-6 flex items-center justify-between">
                            <div>
                                <p class="text-3xl font-bold text-gray-800">{{ $daysWithBoth }}</p>
                                <p class="text-sm text-gray-500">Hari ({{ $totalDays > 0 ? round(($daysWithBoth/$totalDays)*100) : 0 }}%)</p>
                            </div>
                            <div class="bg-green-100 p-3 rounded-full">
                                <i class="fas fa-check-double text-green-600 text-xl"></i>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Ketidaksesuaian -->
                    <div class="bg-white rounded-xl shadow-lg overflow-hidden border border-gray-100">
                        <div class="bg-gradient-to-r from-amber-600 to-amber-800 text-white px-6 py-4">
                            <h3 class="text-lg font-semibold">Ketidaksesuaian</h3>
                        </div>
                        <div class="p-6 flex items-center justify-between">
                            <div>
                                <p class="text-3xl font-bold text-gray-800">{{ $daysMissingJournalCount + $daysMissingAttendanceCount }}</p>
                                <p class="text-sm text-gray-500">Hari ({{ $totalDays > 0 ? round((($daysMissingJournalCount + $daysMissingAttendanceCount)/$totalDays)*100) : 0 }}%)</p>
                            </div>
                            <div class="bg-amber-100 p-3 rounded-full">
                                <i class="fas fa-exclamation-triangle text-amber-600 text-xl"></i>
                            </div>
                        </div>
                    </div>

                    <!-- Journal Status -->
                    <div class="bg-white rounded-xl shadow-lg overflow-hidden border border-gray-100">
                        <div class="bg-gradient-to-r from-purple-600 to-purple-800 text-white px-6 py-4">
                            <h3 class="text-lg font-semibold">Status Jurnal</h3>
                        </div>
                        <div class="p-6">
                            <div class="space-y-4">
                                <div>
                                    <div class="flex justify-between mb-1">
                                        <span class="text-sm font-medium text-gray-700">Terverifikasi</span>
                                        <span class="text-sm font-medium text-gray-700">{{ $verifiedJournals }}</span>
                                    </div>
                                    <div class="w-full bg-gray-200 rounded-full h-2.5">
                                        <div class="bg-green-500 h-2.5 rounded-full" style="width: {{ $verifiedJournals + $pendingJournals > 0 ? ($verifiedJournals/($verifiedJournals + $pendingJournals))*100 : 0 }}%"></div>
                                    </div>
                                </div>
                                <div>
                                    <div class="flex justify-between mb-1">
                                        <span class="text-sm font-medium text-gray-700">Menunggu</span>
                                        <span class="text-sm font-medium text-gray-700">{{ $pendingJournals }}</span>
                                    </div>
                                    <div class="w-full bg-gray-200 rounded-full h-2.5">
                                        <div class="bg-yellow-400 h-2.5 rounded-full" style="width: {{ $verifiedJournals + $pendingJournals > 0 ? ($pendingJournals/($verifiedJournals + $pendingJournals))*100 : 0 }}%"></div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="mt-6 pt-4 border-t border-gray-200">
                                <a href="{{ route('siswa.riwayat') }}" class="flex items-center justify-center px-4 py-2 bg-purple-100 text-purple-700 rounded-lg hover:bg-purple-200 transition duration-300">
                                    <i class="fas fa-book-open mr-2"></i> Lihat Semua Jurnal
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Recent Activity -->
                <div class="bg-white rounded-xl shadow-lg overflow-hidden border border-gray-100">
                    <div class="bg-gradient-to-r from-cyan-600 to-cyan-800 text-white px-6 py-4">
                        <h3 class="text-lg font-semibold">Aktivitas Terakhir</h3>
                    </div>
                    <div class="p-6">
                        <div class="space-y-4">
                            @foreach($recentActivities as $activity)
                                <!-- Activity Item -->
                                <div class="flex items-start space-x-4">
                                    <div class="flex-shrink-0 {{ 
                                        $activity['type'] === 'complete' ? 'bg-green-100 text-green-600' : 
                                        ($activity['type'] === 'missing_journal' ? 'bg-red-100 text-red-600' : 'bg-blue-100 text-blue-600') 
                                    }} p-2 rounded-full">
                                        <i class="fas {{
                                            $activity['type'] === 'complete' ? 'fa-check-double' : 
                                            ($activity['type'] === 'missing_journal' ? 'fa-book-medical' : 'fa-user-clock')
                                        }}"></i>
                                    </div>
                                    <div class="flex-1">
                                        <div class="flex justify-between">
                                            <h4 class="font-medium text-gray-800">
                                                @if($activity['type'] === 'complete')
                                                    Hari Lengkap
                                                @elseif($activity['type'] === 'missing_journal')
                                                    Tanpa Jurnal
                                                @else
                                                    Tanpa Absensi
                                                @endif
                                            </h4>
                                            <span class="text-sm text-gray-500">{{ \Carbon\Carbon::parse($activity['date'])->diffForHumans() }}</span>
                                        </div>
                                        <p class="text-sm text-gray-600">
                                            <span class="font-medium">Absensi:</span> 
                                            @if($activity['attendance'])
                                                Masuk ({{ $activity['attendance']->time_in }})
                                            @else
                                                Belum diisi
                                            @endif
                                            | 
                                            <span class="font-medium">Jurnal:</span> 
                                            @if($activity['journal'])
                                                "{{ Str::limit($activity['journal']->activity, 30) }}"
                                            @else
                                                Belum diisi
                                            @endif
                                        </p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        
                        <div class="mt-6 text-center">
                            <a href="#" class="text-cyan-600 hover:text-cyan-800 font-medium">
                                Lihat Semua Aktivitas <i class="fas fa-arrow-right ml-2"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</x-layout>