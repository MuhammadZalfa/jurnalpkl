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
                                <label for="filter" class="sr-only">Filter</label>
                                <select id="filter" class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 shadow-sm">
                                    <option value="all">Semua Jurnal</option>
                                    <option value="week">Minggu Ini</option>
                                    <option value="month">Bulan Ini</option>
                                </select>
                            </div>
                            <div class="relative w-full md:w-64">
                                <input type="text" placeholder="Cari jurnal..." 
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
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kegiatan</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    <!-- Contoh Data Jurnal -->
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">15</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">15 Juni 2023</td>
                                        <td class="px-6 py-4 text-sm text-gray-500">Membuat desain UI untuk aplikasi mobile</td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Disetujui</span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                            <a href="{{ route('admin.jurnal.detail') }}" class="text-blue-600 hover:text-blue-900 mr-3"><i class="fas fa-eye"></i></a>
                                        </td>
                                    </tr>
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">14</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">14 Juni 2023</td>
                                        <td class="px-6 py-4 text-sm text-gray-500">Mempelajari framework React Native</td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">Menunggu</span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                            <a href="{{ route('admin.jurnal.detail') }}" class="text-blue-600 hover:text-blue-900 mr-3"><i class="fas fa-eye"></i></a>
                                        </td>
                                    </tr>
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">13</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">13 Juni 2023</td>
                                        <td class="px-6 py-4 text-sm text-gray-500">Debugging aplikasi web perusahaan</td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">Ditolak</span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                            <a href="{{ route('admin.jurnal.detail') }}" class="text-blue-600 hover:text-blue-900 mr-3"><i class="fas fa-eye"></i></a>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        
                        <!-- Pagination -->
                        <div class="flex items-center justify-between mt-6">
                            <div class="text-sm text-gray-500">
                                Menampilkan <span class="font-medium">1</span> sampai <span class="font-medium">3</span> dari <span class="font-medium">10</span> jurnal
                            </div>
                            <div class="flex space-x-2">
                                <button class="px-3 py-1 border border-gray-300 rounded-lg text-gray-600 hover:bg-gray-50 disabled:opacity-50" disabled>
                                    <i class="fas fa-chevron-left"></i>
                                </button>
                                <button class="px-3 py-1 border border-blue-500 bg-blue-50 text-blue-600 rounded-lg font-medium">
                                    1
                                </button>
                                <button class="px-3 py-1 border border-gray-300 rounded-lg text-gray-600 hover:bg-gray-50">
                                    2
                                </button>
                                <button class="px-3 py-1 border border-gray-300 rounded-lg text-gray-600 hover:bg-gray-50">
                                    3
                                </button>
                                <button class="px-3 py-1 border border-gray-300 rounded-lg text-gray-600 hover:bg-gray-50">
                                    <i class="fas fa-chevron-right"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    @push('scripts')
    <script>
        // Fungsi untuk pencarian
        document.querySelector('input[type="text"]').addEventListener('input', function(e) {
            const searchTerm = e.target.value.toLowerCase();
            const rows = document.querySelectorAll('tbody tr');
            
            rows.forEach(row => {
                const text = row.textContent.toLowerCase();
                if (text.includes(searchTerm)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });

        // Fungsi untuk filter
        document.getElementById('filter').addEventListener('change', function(e) {
            const filterValue = e.target.value;
            // Implementasi filter berdasarkan pilihan
            console.log('Filter by:', filterValue);
            // Di sini Anda bisa menambahkan logika filter sesuai kebutuhan
        });
    </script>
    @endpush
</x-layout>