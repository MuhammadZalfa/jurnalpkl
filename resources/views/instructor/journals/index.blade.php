<!-- resources/views/instructor/journals/index.blade.php -->
<x-layout title="Jurnal Siswa - Jurnal PKL">
    <x-sidebar-instructor />
    
    <div class="flex-1 flex flex-col">
        <x-header-instructor title="Jurnal Siswa" />
        
        <main class="flex-1 p-4 md:p-6">
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-2xl font-bold text-gray-800">Jurnal Siswa Bimbingan</h1>
            </div>
            
            <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Siswa</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Divisi</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($journals as $journal)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">{{ $journal->user->name }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-500">{{ $journal->date->format('d M Y') }}</div>
                                    <div class="text-xs text-gray-400">Hari ke-{{ $journal->day_number }}</div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm text-gray-600 line-clamp-2">{{ $journal->job_name }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 py-1 text-xs rounded-full {{ $journal->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 'bg-green-100 text-green-800' }}">
                                        {{ $journal->status === 'pending' ? 'Menunggu' : 'Disetujui' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    <a href="{{ route('instructor.journals.show', $journal->id) }}" 
                                       class="text-blue-600 hover:text-blue-900 mr-3">
                                        Detail
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="px-6 py-4 text-center text-sm text-gray-500">
                                    Tidak ada jurnal siswa
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                
                @if($journals->hasPages())
                <div class="px-6 py-4">
                    {{ $journals->links() }}
                </div>
                @endif
            </div>
        </main>
    </div>
</x-layout>