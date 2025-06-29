<x-layout title="Daftar Jurnal - Jurnal PKL">
    <!-- Sidebar -->
    <x-sidebar-admin />
    
    <!-- Main Content -->
    <div class="flex-1 flex flex-col">
        <x-header title="Daftar Jurnal" />
        
        <!-- Content -->
        <main class="flex-1 p-4 md:p-6">
            <div class="max-w-6xl mx-auto">
                <!-- Card Utama -->
                <div class="bg-white rounded-xl shadow-lg overflow-hidden mb-6 border border-gray-100">
                    
                    <!-- Daftar Jurnal -->
                    <div class="p-6">
                        <!-- Filter dan Pencarian -->
                        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4">
                            <div class="w-full md:w-auto">
                                <label for="status-filter" class="sr-only">Filter Status</label>
                                <select id="status-filter" class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 shadow-sm">
                                    <option value="all">Semua Status</option>
                                    <option value="pending">Menunggu</option>
                                    <option value="approved">Disetujui</option>
                                </select>
                            </div>
                            <div class="relative w-full md:w-64">
                                <input type="text" id="search-input" placeholder="Cari jurnal..." 
                                       class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 shadow-sm">
                                <div class="absolute inset-y-0 left-0 flex items-center pl-3">
                                    <i class="fas fa-search text-gray-400"></i>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Tabel Jurnal -->
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Hari Ke-</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Siswa</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kegiatan</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @forelse($journals as $journal)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $journal->day_number }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $journal->date->format('d M Y') }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $journal->user->name }}</td>
                                        <td class="px-6 py-4 text-sm text-gray-500">{{ Str::limit($journal->activity, 50) }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if($journal->status === 'approved')
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Disetujui</span>
                                            @else
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">Menunggu</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                            <a href="{{ route('admin.jurnal.detail', $journal->id) }}" class="text-blue-600 hover:text-blue-900 mr-3"><i class="fas fa-eye"></i></a>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="6" class="px-6 py-4 text-center text-sm text-gray-500">
                                            Tidak ada jurnal yang ditemukan
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        
                        <!-- Pagination -->
                        <div class="flex items-center justify-between mt-6">
                            <div class="text-sm text-gray-500">
                                Menampilkan <span class="font-medium">{{ $journals->firstItem() }}</span> sampai <span class="font-medium">{{ $journals->lastItem() }}</span> dari <span class="font-medium">{{ $journals->total() }}</span> jurnal
                            </div>
                            <div class="flex space-x-2">
                                {{ $journals->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    @push('scripts')
    <script>
        // Filter by status
        document.getElementById('status-filter').addEventListener('change', function() {
            const status = this.value;
            window.location.href = "{{ route('admin.jurnal') }}" + (status !== 'all' ? `?status=${status}` : '');
        });
        
        // Set initial filter value
        const urlParams = new URLSearchParams(window.location.search);
        const statusParam = urlParams.get('status');
        if (statusParam) {
            document.getElementById('status-filter').value = statusParam;
        }
        
        // Search functionality
        document.getElementById('search-input').addEventListener('keyup', function(e) {
            if (e.key === 'Enter') {
                const searchTerm = this.value;
                window.location.href = "{{ route('admin.jurnal') }}" + (searchTerm ? `?search=${encodeURIComponent(searchTerm)}` : '');
            }
        });
    </script>
    @endpush
</x-layout>