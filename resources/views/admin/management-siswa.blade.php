<x-layout title="Manajemen Siswa - Upload Data User">
    <!-- Sidebar -->
    <x-sidebar-admin />
    
    <!-- Main Content -->
    <div class="flex-1 flex flex-col">
        <x-header title="Upload Data User" />
        
        <!-- Content -->
        <main class="flex-1 p-4 md:p-6">
            <div class="max-w-6xl mx-auto">
                <!-- Card Utama -->
                <div class="bg-white rounded-xl shadow-lg overflow-hidden mb-6 border border-gray-100">
                    <div class="p-6">
                        @if (session('success'))
                            <div class="alert alert-success mb-4">
                                {{ session('success') }}
                            </div>
                        @endif

                        @if (session('error'))
                            <div class="alert alert-danger mb-4">
                                {{ session('error') }}
                            </div>
                        @endif

                        @if(!session('authenticated'))
                            <form method="POST" action="{{ route('admin.verify-access') }}">
                                @csrf
                                <div class="form-group mb-4">
                                    <label for="access_password" class="block text-sm font-medium text-gray-700 mb-1">Password Akses Admin</label>
                                    <input id="access_password" type="password" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 @error('access_password') border-red-500 @enderror" name="access_password" required>
                                    
                                    @error('access_password'))
                                        <p class="mt-1 text-sm text-red-600">
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                                        Verifikasi
                                    </button>
                                </div>
                            </form>
                        @else
                            <div class="alert alert-success mb-4">
                                Anda telah terautentikasi untuk mengupload data.
                            </div>

                            <!-- Tombol Upload CSV -->
                            <div class="mb-6">
                                <label for="csvUpload" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded flex items-center cursor-pointer w-fit">
                                    <i class="fas fa-upload mr-2"></i> Upload CSV
                                    <input id="csvUpload" type="file" accept=".csv" class="hidden">
                                </label>
                            </div>

                            <!-- Preview Modal -->
                            <div id="csvUploadModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
                                <div class="bg-white rounded-lg p-6 max-w-3xl w-full">
                                    <h3 class="text-xl font-bold mb-4">Preview Data CSV</h3>
                                    
                                    <div id="csvPreview" class="max-h-96 overflow-y-auto mb-4">
                                        <!-- Preview akan ditampilkan di sini -->
                                    </div>
                                    
                                    <div class="flex justify-between items-center mb-4">
                                        <div>
                                            <span id="rowCount" class="text-sm text-gray-600"></span>
                                            <span id="errorCount" class="text-sm text-red-600 hidden"></span>
                                        </div>
                                        <div>
                                            <button id="confirmUpload" class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">
                                                Konfirmasi Upload
                                            </button>
                                            <button id="cancelUpload" class="px-4 py-2 border border-gray-300 rounded hover:bg-gray-100 ml-2">
                                                Batal
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Format Panduan -->
                            <div class="mt-6 border-t pt-4">
                                <h5 class="text-lg font-medium mb-2">Format CSV:</h5>
                                <div class="overflow-x-auto">
                                    <table class="min-w-full divide-y divide-gray-200 border border-gray-200">
                                        <thead class="bg-gray-50">
                                            <tr>
                                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">name</th>
                                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ni</th>
                                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">password</th>
                                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">jurusan</th>
                                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">dudi</th>
                                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">pembimbing</th>
                                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">role</th>
                                            </tr>
                                        </thead>
                                        <tbody class="bg-white divide-y divide-gray-200">
                                            <tr>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Nama Lengkap</td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Nomor Induk</td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Password (bcrypt hash)</td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Jurusan</td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">DUDI</td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Pembimbing</td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">student/instructor/admin</td>
                                            </tr>
                                            <tr>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500" colspan="7">
                                                    <div class="text-red-600 font-medium">Catatan:</div>
                                                    <ul class="list-disc pl-5 mt-2 text-sm">
                                                        <li>Password harus dalam format bcrypt hash (contoh: $2y$10$...)</li>
                                                        <li>Kolom role wajib diisi dengan salah satu: student, instructor, admin</li>
                                                        <li>Kolom jurusan, dudi, dan pembimbing bisa dikosongkan untuk role non-student</li>
                                                        <li>Status user otomatis di-set sebagai <strong>active</strong></li>
                                                    </ul>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </main>
    </div>
    
    <!-- Include Libraries -->
    <script src="https://cdn.jsdelivr.net/npm/papaparse@5.3.0/papaparse.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const csvUpload = document.getElementById('csvUpload');
        const csvUploadModal = document.getElementById('csvUploadModal');
        const csvPreview = document.getElementById('csvPreview');
        const rowCount = document.getElementById('rowCount');
        const errorCount = document.getElementById('errorCount');
        const confirmUpload = document.getElementById('confirmUpload');
        const cancelUpload = document.getElementById('cancelUpload');
        
        let csvData = [];
        let validationErrors = [];
        
        // Handle CSV file selection
        csvUpload.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (!file) return;
            
            Papa.parse(file, {
                header: true,
                skipEmptyLines: true,
                complete: function(results) {
                    csvData = results.data;
                    validateCsvData(csvData);
                    displayPreview(csvData);
                    csvUploadModal.classList.remove('hidden');
                },
                error: function(error) {
                    Swal.fire({
                        title: 'Error Parsing CSV',
                        text: error.message,
                        icon: 'error'
                    });
                }
            });
        });
        
        // Validate CSV data
        function validateCsvData(data) {
            validationErrors = [];
            
            data.forEach((row, index) => {
                const errors = [];
                
                // Check required fields
                if (!row.name) errors.push('Nama wajib diisi');
                if (!row.ni) errors.push('NI wajib diisi');
                if (!row.password) errors.push('Password wajib diisi');
                if (!row.role) errors.push('Role wajib diisi');
                if (!row.jurusan) errors.push('Jurusan wajib diisi');
                
                // Di fungsi validateCsvData()
                if (row.role && !['student', 'instructor', 'admin'].includes(row.role.toLowerCase())) {
                    errors.push('Role harus: student, instructor, atau admin');
                }
                
                // Validate password format (updated regex)
                if (row.password && !/^\$2[abzy]\$\d{1,2}\$[.\/A-Za-z0-9]{53}$/.test(row.password)) {
                    errors.push('Format password tidak valid (harus bcrypt hash)');
                }
                
                if (errors.length > 0) {
                    validationErrors.push({
                        row: index + 1,
                        errors: errors
                    });
                }
            });
        }
        
        // Display CSV preview
        function displayPreview(data) {
            let html = `
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 border border-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Nama</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">NI</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Jurusan</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Role</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
            `;
            
            // Show first 10 rows
            const previewRows = data.slice(0, 10);
            
            previewRows.forEach((row, index) => {
                const hasError = validationErrors.some(err => err.row === index + 1);
                const errorClass = hasError ? 'bg-red-50' : '';
                
                html += `
                <tr class="${errorClass}">
                    <td class="px-4 py-2 whitespace-nowrap text-sm">${row.name || '-'}</td>
                    <td class="px-4 py-2 whitespace-nowrap text-sm">${row.ni || '-'}</td>
                    <td class="px-4 py-2 whitespace-nowrap text-sm">${row.jurusan || '-'}</td>
                    <td class="px-4 py-2 whitespace-nowrap text-sm">${row.role || '-'}</td>
                    <td class="px-4 py-2 whitespace-nowrap text-sm">
                        ${hasError ? '<span class="text-red-600">Error</span>' : '<span class="text-green-600">Valid</span>'}
                    </td>
                </tr>
                `;
            });
            
            if (data.length > 10) {
                html += `
                <tr>
                    <td colspan="5" class="px-4 py-2 text-center text-sm text-gray-500">
                        ... dan ${data.length - 10} baris lainnya
                    </td>
                </tr>
                `;
            }
            
            html += `
                    </tbody>
                </table>
            </div>
            `;
            
            csvPreview.innerHTML = html;
            rowCount.textContent = `Total baris: ${data.length}`;
            
            if (validationErrors.length > 0) {
                errorCount.classList.remove('hidden');
                errorCount.textContent = ` | Baris dengan error: ${validationErrors.length}`;
            }
        }
        
        // Confirm upload
        confirmUpload.addEventListener('click', function() {
            if (validationErrors.length > 0) {
                Swal.fire({
                    title: 'Ada Error di Data',
                    html: `Terdapat ${validationErrors.length} baris dengan error. <br>Anda tetap dapat melanjutkan, tetapi baris dengan error akan diabaikan.`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Lanjutkan Upload',
                    cancelButtonText: 'Perbaiki Data'
                }).then((result) => {
                    if (result.isConfirmed) {
                        uploadData();
                    }
                });
            } else {
                uploadData();
            }
        });
        
        // Cancel upload
        cancelUpload.addEventListener('click', function() {
            csvUploadModal.classList.add('hidden');
            csvData = [];
            validationErrors = [];
            csvUpload.value = '';
        });
        
        // Upload data to server
        function uploadData() {
            // Filter out rows with errors
            const validData = csvData.filter((row, index) => {
                return !validationErrors.some(err => err.row === index + 1);
            }).map(row => ({
                ...row,
                status: 'active',
                role: row.role.toLowerCase(),
                jurusan: row.jurusan || '', // Pastikan jurusan tidak null
                pembimbing: row.pembimbing || null
            }));

            Swal.fire({
                title: 'Mengupload Data',
                html: `Sedang mengupload ${validData.length} data...`,
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                    
                    // Send data to server
                    fetch('{{ route("admin.upload-users-ajax") }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify({ data: validData })
                    })
                    .then(response => {
                        if (!response.ok) {
                            return response.json().then(err => Promise.reject(err));
                        }
                        return response.json();
                    })
                    .then(data => {
                        if (data.success) {
                            let message = `Berhasil menambahkan ${data.inserted} user baru`;
                            
                            if (data.errors && data.errors.length > 0) {
                                message += `<br><br>Beberapa error terjadi:<br>`;
                                message += data.errors.slice(0, 5).map(err => 
                                    typeof err === 'object' ? JSON.stringify(err) : err
                                ).join('<br>');
                                
                                if (data.errors.length > 5) {
                                    message += `<br>... dan ${data.errors.length - 5} error lainnya`;
                                }
                            }
                            
                            Swal.fire({
                                title: 'Sukses!',
                                html: message,
                                icon: 'success'
                            }).then(() => {
                                window.location.reload();
                            });
                        } else {
                            let errorMessage = data.message || 'Terjadi kesalahan saat mengupload data';
                            
                            if (data.errors) {
                                errorMessage += '<br><br>';
                                if (Array.isArray(data.errors)) {
                                    errorMessage += data.errors.slice(0, 5).join('<br>');
                                } else {
                                    errorMessage += JSON.stringify(data.errors);
                                }
                            }
                            
                            Swal.fire({
                                title: 'Error!',
                                html: errorMessage,
                                icon: 'error'
                            });
                        }
                    })
                    .catch(error => {
                        let errorMessage = 'Terjadi kesalahan saat mengirim data';
                        if (error.errors) {
                            errorMessage += '<br>' + Object.values(error.errors).join('<br>');
                        } else if (error.message) {
                            errorMessage += '<br>' + error.message;
                        }
                        
                        Swal.fire({
                            title: 'Error!',
                            html: errorMessage,
                            icon: 'error'
                        });
                    });
                }
            });
        }
    });
    </script>
</x-layout>