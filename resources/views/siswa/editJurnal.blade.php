<x-layout title="Edit Jurnal - Jurnal PKL">
    <!-- Sidebar -->
    <x-sidebar-student />
    
    <!-- Main Content -->
    <div class="flex-1 flex flex-col">
        <x-header title="Edit Jurnal" />
        
        <!-- Content -->
        <main class="flex-1 p-4 md:p-6">
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-2xl font-bold text-gray-800">Edit Jurnal</h1>
                <a href="{{ route('siswa.riwayat') }}" class="text-gray-600 hover:text-gray-900 flex items-center">
                    <i class="fas fa-arrow-left mr-2"></i> Kembali ke Riwayat
                </a>
            </div>
            
            <!-- Journal Card -->
            <div class="bg-white rounded-xl shadow-lg overflow-hidden mb-6">
                @php
                    // Dummy data
                    $journal = [
                        'id' => 1,
                        'day' => 15,
                        'date' => '2025-06-12',
                        'activity' => "Melakukan pembuatan modul aplikasi dengan Laravel dan Tailwind CSS.\nMempelajari konsep middleware dan autentikasi role-based.",
                        'obstacle' => "Beberapa masalah dalam implementasi authorization, tetapi sudah teratasi.",
                        'status' => 'pending',
                        'note' => 'Harap lebih detail dalam menjelaskan kendala yang dihadapi',
                        'photos' => [
                            'photo1.jpg',
                            'photo2.jpg'
                        ]
                    ];
                @endphp
                
                <div class="bg-yellow-600 text-white px-6 py-4">
                    <h3 class="text-lg font-semibold">Edit Jurnal Hari ke-{{ $journal['day'] }}</h3>
                </div>
                
                <div class="p-6">
                    <!-- Edit Form -->
                    <form action="{{ route('siswa.jurnal.update', $journal['id']) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        
                        <div class="grid grid-cols-1 gap-6 mb-6">
                            <div>
                                <label for="day" class="block text-sm font-medium text-gray-700 mb-1">Hari ke-</label>
                                <input type="number" id="day" name="day" value="{{ $journal['day'] }}" class="w-full border-gray-300 rounded-lg focus:border-blue-500 focus:ring-blue-500" required>
                            </div>
                            
                            <div>
                                <label for="date" class="block text-sm font-medium text-gray-700 mb-1">Tanggal</label>
                                <input type="date" id="date" name="date" value="{{ $journal['date'] }}" class="w-full border-gray-300 rounded-lg focus:border-blue-500 focus:ring-blue-500" required>
                            </div>
                            
                            <div>
                                <label for="activity" class="block text-sm font-medium text-gray-700 mb-1">Kegiatan</label>
                                <textarea id="activity" name="activity" rows="4" class="w-full border-gray-300 rounded-lg focus:border-blue-500 focus:ring-blue-500" required>{{ $journal['activity'] }}</textarea>
                            </div>
                            
                            <div>
                                <label for="obstacle" class="block text-sm font-medium text-gray-700 mb-1">Kendala</label>
                                <textarea id="obstacle" name="obstacle" rows="2" class="w-full border-gray-300 rounded-lg focus:border-blue-500 focus:ring-blue-500">{{ $journal['obstacle'] }}</textarea>
                            </div>
                            
                            <!-- Foto Dokumentasi -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Foto Dokumentasi</label>
                                
                                <!-- Preview Foto yang sudah ada -->
                                @if(!empty($journal['photos']))
                                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-4">
                                        @foreach($journal['photos'] as $photo)
                                            <div class="relative group">
                                                <img src="{{ asset('storage/jurnal_photos/'.$photo) }}" alt="Dokumentasi" class="w-full h-32 object-cover rounded-lg">
                                                <div class="absolute inset-0 bg-black bg-opacity-50 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity">
                                                    <button type="button" class="text-white bg-red-500 rounded-full p-2" onclick="confirmDeletePhoto('{{ $photo }}')">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @endif
                                
                                <!-- Upload Foto Baru -->
                                <div class="mt-2">
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Tambah Foto Baru</label>
                                    <div class="mt-1 flex items-center">
                                        <input type="file" name="photos[]" id="photos" class="hidden" multiple accept="image/*">
                                        <label for="photos" class="cursor-pointer bg-white py-2 px-3 border border-gray-300 rounded-lg shadow-sm text-sm leading-4 font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                            <i class="fas fa-camera mr-2"></i> Pilih File
                                        </label>
                                        <span id="file-chosen" class="ml-3 text-sm text-gray-500">Belum ada file dipilih</span>
                                    </div>
                                    <p class="mt-1 text-xs text-gray-500">Upload foto dokumentasi kegiatan (max 5 foto, format JPG/PNG)</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="flex justify-end space-x-3">
                            <a href="{{ route('siswa.riwayat', $journal['id']) }}" class="bg-gray-200 hover:bg-gray-300 text-gray-800 px-4 py-2 rounded-lg">
                                Batal
                            </a>
                            <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg">
                                Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </main>
    </div>

    <!-- JavaScript untuk tampilan file dan konfirmasi hapus -->
    <script>
        // Menampilkan nama file yang dipilih
        const fileInput = document.getElementById('photos');
        const fileChosen = document.getElementById('file-chosen');
        
        fileInput.addEventListener('change', function(e) {
            if (this.files.length > 0) {
                if (this.files.length > 5) {
                    alert('Maksimal 5 file yang dapat diupload');
                    this.value = '';
                    fileChosen.textContent = 'Belum ada file dipilih';
                } else {
                    fileChosen.textContent = this.files.length + ' file dipilih';
                }
            } else {
                fileChosen.textContent = 'Belum ada file dipilih';
            }
        });

        // Konfirmasi hapus foto
        function confirmDeletePhoto(photoName) {
            if (confirm('Apakah Anda yakin ingin menghapus foto ini?')) {
                // Lakukan AJAX request untuk menghapus foto
                alert('Foto ' + photoName + ' akan dihapus');
                // window.location.href = '/delete-jurnal-photo/' + photoName;
            }
        }
    </script>
</x-layout>