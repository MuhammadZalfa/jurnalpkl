<x-layout title="Buat Jurnal Baru - Jurnal PKL">
    <!-- Sidebar -->
    <x-sidebar-student />
    
    <!-- Main Content -->
    <div class="flex-1 flex flex-col">
        <x-header title="Buat Jurnal Baru" />
        
        <!-- Content -->
        <main class="flex-1 p-4 md:p-6">
            <div class="max-w-4xl mx-auto">
                <!-- Card Utama -->
                <div class="bg-white rounded-xl shadow-lg overflow-hidden mb-6 border border-gray-100">
                    <div class="bg-gradient-to-r from-blue-600 to-blue-800 text-white px-6 py-4">
                        <h1 class="text-xl font-semibold">Form Jurnal Harian PKL</h1>
                        <p class="text-blue-100 text-sm mt-1">Isi detail kegiatan harian Anda selama PKL</p>
                    </div>
                    
                    <form action="{{ route('siswa.jurnal.store') }}" method="POST" class="p-6" enctype="multipart/form-data">
                        @csrf
                        <!-- Grid Dua Kolom untuk Tanggal dan Hari Ke- -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                            <!-- Tanggal -->
                            <div class="space-y-2">
                                <label for="date" class="block text-gray-700 font-medium">Tanggal Kegiatan</label>
                                <div class="relative">
                                    <input type="date" id="date" name="date" 
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 shadow-sm"
                                        required>
                                </div>
                            </div>
                            
                            <!-- Hari Ke- -->
                            <div class="space-y-2">
                                <label for="day_number" class="block text-gray-700 font-medium">Hari Ke-</label>
                                <div class="relative">
                                    <input type="number" id="day_number" name="day_number" min="1"
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 shadow-sm"
                                        placeholder="Contoh: 15" required>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Nama Pekerjaan -->
                        <div class="mb-6">
                            <label for="job_name" class="block text-gray-700 font-medium mb-2">Nama Pekerjaan</label>
                            <div class="relative">
                                <input type="text" id="job_name" name="job_name"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 shadow-sm"
                                    required>
                            </div>
                        </div>
                        
                        <!-- Kegiatan Harian -->
                        <div class="mb-6">
                            <label for="activity" class="block text-gray-700 font-medium mb-2">Kegiatan Harian</label>
                            <div class="relative">
                                <textarea id="activity" name="activity" rows="6"
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 shadow-sm"
                                        placeholder="Deskripsikan secara detail kegiatan yang Anda lakukan hari ini..."
                                        required></textarea>
                                <div class="absolute bottom-3 right-3 text-gray-400 text-sm">
                                    <span id="activity-counter">0</span>/500 kata
                                </div>
                            </div>
                        </div>
                        
                        <!-- Kendala -->
                        <div class="mb-6">
                            <label for="obstacle" class="block text-gray-700 font-medium mb-2">Kendala & Solusi</label>
                            <textarea id="obstacle" name="obstacle" rows="4"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 shadow-sm"
                                    placeholder="Deskripsikan kendala yang dihadapi dan solusi yang Anda terapkan (jika ada)"></textarea>
                        </div>
                        
                        <!-- Upload Foto Dokumentasi -->
                        <div class="mb-8">
                            <label class="block text-gray-700 font-medium mb-2">Dokumentasi Kegiatan</label>
                            <div class="border-2 border-dashed border-gray-300 rounded-xl p-6 text-center hover:border-blue-500 transition duration-300">
                                <div id="drop-area" class="cursor-pointer">
                                    <div class="flex flex-col items-center justify-center space-y-3">
                                        <i class="fas fa-cloud-upload-alt text-3xl text-blue-500"></i>
                                        <p class="text-gray-600">Seret & lepas foto disini atau klik untuk memilih</p>
                                        <p class="text-sm text-gray-500">Format: JPG, PNG (Maks. 5MB)</p>
                                        <input type="file" id="documentation" name="documentation[]" multiple 
                                            class="hidden" accept="image/*">
                                        <button type="button" onclick="document.getElementById('documentation').click()" 
                                                class="px-4 py-2 bg-blue-100 text-blue-600 rounded-lg hover:bg-blue-200 transition duration-300">
                                            Pilih File
                                        </button>
                                    </div>
                                </div>
                                <div id="file-list" class="mt-4 grid grid-cols-2 md:grid-cols-3 gap-3 hidden">
                                    <!-- Preview gambar akan muncul disini -->
                                </div>
                            </div>
                        </div>
                        
                        <!-- Tombol Aksi -->
                        <div class="flex flex-col md:flex-row justify-end space-y-3 md:space-y-0 md:space-x-4">
                            <a href="{{ route('siswa.dashboard') }}" 
                            class="px-6 py-3 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition duration-300 flex items-center justify-center">
                                <i class="fas fa-times mr-2"></i> Batal
                            </a>
                            <button type="submit" 
                                    class="px-6 py-3 bg-gradient-to-r from-blue-600 to-blue-800 text-white rounded-lg hover:from-blue-700 hover:to-blue-900 transition duration-300 flex items-center justify-center shadow-md hover:shadow-lg">
                                <i class="fas fa-paper-plane mr-2"></i> Kirim Jurnal
                            </button>
                        </div>
                    </form>
                </div>
                
                <!-- Panduan Modern -->
                <div class="bg-white rounded-xl shadow-lg overflow-hidden border border-gray-100">
                    <div class="bg-gradient-to-r from-indigo-600 to-indigo-800 text-white px-6 py-4 flex items-center">
                        <i class="fas fa-info-circle text-xl mr-3"></i>
                        <h3 class="text-lg font-semibold">Panduan Pengisian Jurnal</h3>
                    </div>
                    <div class="p-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="flex items-start space-x-3">
                                <div class="flex-shrink-0 bg-indigo-100 p-2 rounded-full">
                                    <i class="fas fa-check-circle text-indigo-600"></i>
                                </div>
                                <div>
                                    <h4 class="font-medium text-gray-800">Detail Kegiatan</h4>
                                    <p class="text-sm text-gray-600">Jelaskan kegiatan secara rinci termasuk tools yang digunakan.</p>
                                </div>
                            </div>
                            <div class="flex items-start space-x-3">
                                <div class="flex-shrink-0 bg-indigo-100 p-2 rounded-full">
                                    <i class="fas fa-camera text-indigo-600"></i>
                                </div>
                                <div>
                                    <h4 class="font-medium text-gray-800">Dokumentasi</h4>
                                    <p class="text-sm text-gray-600">Sertakan foto kegiatan sebagai bukti visual (maks. 5 foto).</p>
                                </div>
                            </div>
                            <div class="flex items-start space-x-3">
                                <div class="flex-shrink-0 bg-indigo-100 p-2 rounded-full">
                                    <i class="fas fa-exclamation-triangle text-indigo-600"></i>
                                </div>
                                <div>
                                    <h4 class="font-medium text-gray-800">Kendala</h4>
                                    <p class="text-sm text-gray-600">Deskripsikan masalah yang dihadapi dan solusi yang ditemukan.</p>
                                </div>
                            </div>
                            <div class="flex items-start space-x-3">
                                <div class="flex-shrink-0 bg-indigo-100 p-2 rounded-full">
                                    <i class="far fa-clock text-indigo-600"></i>
                                </div>
                                <div>
                                    <h4 class="font-medium text-gray-800">Ketepatan Waktu</h4>
                                    <p class="text-sm text-gray-600">Kirim jurnal sebelum pukul 23:59 WIB di hari yang sama.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    @push('scripts')
    <script>
        // Counter untuk textarea kegiatan
        document.getElementById('activity').addEventListener('input', function() {
            const count = this.value.split(/\s+/).filter(word => word.length > 0).length;
            document.getElementById('activity-counter').textContent = count;
        });

        // Handle file upload dan preview
        const dropArea = document.getElementById('drop-area');
        const fileInput = document.getElementById('documentation');
        const fileList = document.getElementById('file-list');

        ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
            dropArea.addEventListener(eventName, preventDefaults, false);
        });

        function preventDefaults(e) {
            e.preventDefault();
            e.stopPropagation();
        }

        ['dragenter', 'dragover'].forEach(eventName => {
            dropArea.addEventListener(eventName, highlight, false);
        });

        ['dragleave', 'drop'].forEach(eventName => {
            dropArea.addEventListener(eventName, unhighlight, false);
        });

        function highlight() {
            dropArea.classList.add('border-blue-500', 'bg-blue-50');
        }

        function unhighlight() {
            dropArea.classList.remove('border-blue-500', 'bg-blue-50');
        }

        dropArea.addEventListener('drop', handleDrop, false);
        fileInput.addEventListener('change', handleFiles, false);

        function handleDrop(e) {
            const dt = e.dataTransfer;
            const files = dt.files;
            fileInput.files = files;
            handleFiles({ target: fileInput });
        }

        function handleFiles(e) {
            const files = e.target.files;
            if (files.length > 0) {
                fileList.innerHTML = '';
                fileList.classList.remove('hidden');
                
                Array.from(files).slice(0, 5).forEach(file => {
                    if (file.type.startsWith('image/')) {
                        const reader = new FileReader();
                        reader.onload = function(e) {
                            const fileItem = document.createElement('div');
                            fileItem.className = 'relative group';
                            fileItem.innerHTML = `
                                <img src="${e.target.result}" class="w-full h-32 object-cover rounded-lg">
                                <div class="absolute inset-0 bg-black bg-opacity-50 opacity-0 group-hover:opacity-100 rounded-lg transition duration-300 flex items-center justify-center">
                                    <button type="button" class="text-white hover:text-red-300" onclick="removeFile(this)">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                                <div class="text-xs text-gray-500 truncate mt-1">${file.name}</div>
                            `;
                            fileList.appendChild(fileItem);
                        };
                        reader.readAsDataURL(file);
                    }
                });
            }
        }

        function removeFile(button) {
            const fileItem = button.closest('.relative');
            fileItem.remove();
            
            if (fileList.children.length === 0) {
                fileList.classList.add('hidden');
            }
        }
    </script>
    @endpush
</x-layout>