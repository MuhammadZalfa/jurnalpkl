<!-- resources/views/instructor/attendances/index.blade.php -->
<x-layout title="Daftar Hadir - Jurnal PKL">
    <x-sidebar-instructor />
    
    <div class="flex-1 flex flex-col">
        <x-header-instructor title="Daftar Hadir" />
        
        <main class="flex-1 p-4 md:p-6">
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-2xl font-bold text-gray-800">Daftar Hadir Siswa</h1>
            </div>
            
            <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Siswa</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Keterangan</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jam Masuk</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jam Pulang</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Durasi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($attendances as $attendance)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">{{ $attendance->student->name }}</div>
                                </td>
                                <!-- Ganti kolom Keterangan di index.blade.php -->
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 py-1 text-xs rounded-full {{ $attendance->type_badge_class }}">
                                        {{ $attendance->type_label }}
                                    </span>
                                    @if($attendance->reason)
                                        <div class="text-xs text-gray-500 mt-1">Alasan: {{ $attendance->reason }}</div>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-500">{{ $attendance->date->format('d M Y') }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-500">{{ $attendance->time_in }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($attendance->type === \App\Models\Attendance::TYPE_PRESENT)
                                        <div class="text-sm text-gray-500">{{ $attendance->time_out ?? '-' }}</div>
                                    @else
                                        <div class="text-sm text-gray-400">-</div>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                @if($attendance->type === \App\Models\Attendance::TYPE_PRESENT)
                                    <div class="text-sm text-gray-500">{{ $attendance->duration_formatted }}</div>
                                @else
                                    <div class="text-sm text-gray-400">-</div>
                                @endif
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
                
                @if($attendances->hasPages())
                <div class="px-6 py-4">
                    {{ $attendances->links() }}
                </div>
                @endif
            </div>
        </main>
    </div>
</x-layout>