<x-layout title="Detail Jurnal - Jurnal PKL">
    <!-- Sidebar -->
    <x-sidebar-admin />
    
    <!-- Main Content -->
    <div class="flex-1 flex flex-col">
        <x-header title="Detail Jurnal Siswa" />
        
        <!-- Content -->
        <main class="flex-1 p-4 md:p-6">
            <div class="max-w-4xl mx-auto">
                <!-- Card Utama -->
                <div class="bg-white rounded-xl shadow-lg overflow-hidden mb-6 border border-gray-100">
                    <!-- Header dengan info siswa -->
                    <div class="bg-gradient-to-r from-blue-600 to-blue-800 text-white px-6 py-4">
                        <div class="flex items-center justify-between">
                            <div>
                                <h1 class="text-xl font-semibold">Jurnal Harian PKL</h1>
                                <div class="flex items-center mt-2">
                                    <div class="flex-shrink-0 h-10 w-10">
                                        <img class="h-10 w-10 rounded-full" src="https://via.placeholder.com/40" alt="">
                                    </div>
                                    <div class="ml-3">
                                        <p class="text-sm font-medium text-blue-100">Andi Wijaya</p>
                                        <p class="text-xs text-blue-200">XII RPL 1 - PT. Teknologi Maju</p>
                                    </div>
                                </div>
                            </div>
                            <div class="text-right">
                                <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">Menunggu</span>
                                <p class="text-xs text-blue-200 mt-1">Dikirim: 15 Juni 2023, 18:30 WIB</p>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Isi Jurnal -->
                    <div class="p-6">
                        <!-- Informasi Dasar -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                            <div>
                                <label class="block text-gray-500 text-sm font-medium mb-1">Hari Ke-</label>
                                <p class="text-gray-800 font-medium">15</p>
                            </div>
                            <div>
                                <label class="block text-gray-500 text-sm font-medium mb-1">Tanggal Kegiatan</label>
                                <p class="text-gray-800 font-medium">15 Juni 2023</p>
                            </div>
                        </div>
                        
                        <!-- Kegiatan -->
                        <div class="mb-6">
                            <label class="block text-gray-500 text-sm font-medium mb-2">Nama Pekerjaan</label>
                            <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                                <p class="text-gray-800">Membuat desain UI untuk aplikasi mobile perusahaan</p>
                            </div>
                        </div>
                        
                        <div class="mb-6">
                            <label class="block text-gray-500 text-sm font-medium mb-2">Detail Kegiatan</label>
                            <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                                <p class="text-gray-800 whitespace-pre-line">Hari ini saya membuat desain UI untuk aplikasi mobile perusahaan menggunakan Figma. Saya menyelesaikan 3 halaman utama:
- Halaman Login
- Halaman Dashboard
- Halaman Profil Pengguna

Saya juga melakukan diskusi dengan tim UX untuk memastikan desain sesuai dengan kebutuhan pengguna.</p>
                            </div>
                        </div>
                        
                        <!-- Kendala -->
                        <div class="mb-6">
                            <label class="block text-gray-500 text-sm font-medium mb-2">Kendala & Solusi</label>
                            <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                                <p class="text-gray-800 whitespace-pre-line">Kendala: 
- Warna yang dipilih terlihat kurang kontras pada perangkat mobile
- Beberapa komponen tidak konsisten

Solusi:
- Melakukan penyesuaian warna berdasarkan saran dari mentor
- Membuat komponen master di Figma untuk menjaga konsistensi</p>
                            </div>
                        </div>
                        
                        <!-- Dokumentasi -->
                        <div class="mb-8">
                            <label class="block text-gray-500 text-sm font-medium mb-3">Dokumentasi Kegiatan</label>
                            <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                                <a href="#" class="group relative block rounded-lg overflow-hidden border border-gray-200">
                                    <img src="https://via.placeholder.com/300" alt="Dokumentasi 1" class="w-full h-32 object-cover">
                                    <div class="absolute inset-0 bg-black bg-opacity-30 opacity-0 group-hover:opacity-100 transition duration-300 flex items-center justify-center">
                                        <i class="fas fa-search-plus text-white text-xl"></i>
                                    </div>
                                </a>
                                <a href="#" class="group relative block rounded-lg overflow-hidden border border-gray-200">
                                    <img src="https://via.placeholder.com/300" alt="Dokumentasi 2" class="w-full h-32 object-cover">
                                    <div class="absolute inset-0 bg-black bg-opacity-30 opacity-0 group-hover:opacity-100 transition duration-300 flex items-center justify-center">
                                        <i class="fas fa-search-plus text-white text-xl"></i>
                                    </div>
                                </a>
                                <a href="#" class="group relative block rounded-lg overflow-hidden border border-gray-200">
                                    <img src="https://via.placeholder.com/300" alt="Dokumentasi 3" class="w-full h-32 object-cover">
                                    <div class="absolute inset-0 bg-black bg-opacity-30 opacity-0 group-hover:opacity-100 transition duration-300 flex items-center justify-center">
                                        <i class="fas fa-search-plus text-white text-xl"></i>
                                    </div>
                                </a>
                            </div>
                        </div>
                        
                        <!-- Form Persetujuan -->
                        <div class="border-t border-gray-200 pt-6 mt-6">
                            <form action="{{ route('admin.jurnal.approve', 1) }}" method="POST">
                                @csrf
                                <div class="mb-4">
                                    <label for="status" class="block text-gray-700 font-medium mb-2">Status Persetujuan</label>
                                    <select id="status" name="status" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 shadow-sm">
                                        <option value="disetujui">Setujui</option>
                                        <option value="ditolak">Tolak</option>
                                    </select>
                                </div>
                                <div class="mb-4">
                                    <label for="feedback" class="block text-gray-700 font-medium mb-2">Feedback (Opsional)</label>
                                    <textarea id="feedback" name="feedback" rows="3" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 shadow-sm" placeholder="Berikan masukan untuk siswa..."></textarea>
                                </div>
                                <div class="flex justify-end space-x-3">
                                    <a href="{{ route('admin.jurnal') }}" class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition duration-300 flex items-center justify-center">
                                        <i class="fas fa-arrow-left mr-2"></i> Kembali
                                    </a>
                                    <button type="submit" class="px-6 py-2 bg-gradient-to-r from-green-600 to-green-700 text-white rounded-lg hover:from-green-700 hover:to-green-800 transition duration-300 flex items-center justify-center shadow-md hover:shadow-lg">
                                        <i class="fas fa-check-circle mr-2"></i> Simpan Status
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</x-layout>