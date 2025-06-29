<x-layout title="Statistik Siswa - Admin">
    <!-- Sidebar -->
    <x-sidebar-admin />
    
    <!-- Main Content -->
    <div class="flex-1 flex flex-col">
        <x-header title="Statistik Siswa Bimbingan" />
        
        <!-- Content -->
        <main class="flex-1 p-4 md:p-6">
            <div class="max-w-6xl mx-auto">
                <!-- Overview Cards -->
                <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
                    <!-- Total Siswa -->
                    <div class="bg-white rounded-xl shadow-lg overflow-hidden border border-gray-100">
                        <div class="bg-gradient-to-r from-blue-600 to-blue-800 text-white px-6 py-4">
                            <h3 class="text-lg font-semibold">Total Siswa</h3>
                        </div>
                        <div class="p-6 flex items-center justify-between">
                            <div>
                                <p class="text-3xl font-bold text-gray-800">{{ $totalStudents }}</p>
                                <p class="text-sm text-gray-500">Siswa Bimbingan</p>
                            </div>
                            <div class="bg-blue-100 p-3 rounded-full">
                                <i class="fas fa-users text-blue-600 text-xl"></i>
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
                                <p class="text-3xl font-bold text-gray-800">{{ $daysMissingJournal + $daysMissingAttendance }}</p>
                                <p class="text-sm text-gray-500">Hari ({{ $totalDays > 0 ? round((($daysMissingJournal + $daysMissingAttendance)/$totalDays)*100) : 0 }}%)</p>
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
                        </div>
                    </div>
                </div>
                
                <!-- Student Statistics -->
                <div class="bg-white rounded-xl shadow-lg overflow-hidden border border-gray-100 mb-6">
                    <div class="bg-gradient-to-r from-indigo-600 to-indigo-800 text-white px-6 py-4">
                        <h3 class="text-lg font-semibold">Statistik per Siswa</h3>
                    </div>
                    <div class="p-6">
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Siswa</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">DUDI</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jurnal</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Absensi</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kelengkapan</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($students as $student)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $student['name'] }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $student['dudi'] }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center gap-2">
                                                <span class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-800">{{ $student['verified_journals'] }}</span>
                                                <span class="px-2 py-1 text-xs rounded-full bg-yellow-100 text-yellow-800">{{ $student['pending_journals'] }}</span>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-2 py-1 text-xs rounded-full bg-blue-100 text-blue-800">{{ $student['total_attendances'] }}</span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="w-full bg-gray-200 rounded-full h-2.5">
                                                <div class="bg-green-500 h-2.5 rounded-full" style="width: {{ $student['completeness_percentage'] }}%"></div>
                                            </div>
                                            <span class="text-xs text-gray-500 mt-1">{{ $student['completeness_percentage'] }}%</span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <a href="#" class="text-indigo-600 hover:text-indigo-900">Detail</a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
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
                            <div class="flex items-start space-x-4">
                                <div class="flex-shrink-0 bg-blue-100 text-blue-600 p-2 rounded-full">
                                    <i class="fas fa-user"></i>
                                </div>
                                <div class="flex-1">
                                    <div class="flex justify-between">
                                        <h4 class="font-medium text-gray-800">{{ $activity['student']->name }}</h4>
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
                    </div>
                </div>
            </div>
        </main>
    </div>
</x-layout>