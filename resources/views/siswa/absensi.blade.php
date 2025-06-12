<x-layout title="Absensi - Jurnal PKL">
    <!-- Sidebar -->
    <x-sidebar-student />
    
    <!-- Main Content -->
    <div class="flex-1 flex flex-col">
        <x-header title="Absensi Harian" />
        
        <!-- Content -->
        <main class="flex-1 p-4 md:p-6">
            <div class="max-w-4xl mx-auto">
                <!-- Card Absensi Hari Ini -->
                <div class="bg-white rounded-xl shadow-lg overflow-hidden mb-6 border border-gray-100">
                    <div class="bg-gradient-to-r from-blue-600 to-blue-800 text-white px-6 py-4">
                        <div class="flex justify-between items-center">
                            <div>
                                <h1 class="text-xl font-semibold">Absensi Hari Ini</h1>
                                <p class="text-blue-100 text-sm mt-1">{{ now('Asia/Jakarta')->translatedFormat('l, d F Y') }}</p>
                            </div>
                            <div class="text-right">
                                <p class="text-sm font-medium">Status</p>
                                <span class="inline-block px-3 py-1 rounded-full text-xs font-semibold bg-yellow-100 text-yellow-800">
                                    Belum Absen
                                </span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="p-6">
                        <!-- Form Absensi -->
                        <form action="#" method="POST">
                            @csrf
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                                <!-- Lokasi -->
                                <div class="space-y-2">
                                    <label class="block text-gray-700 font-medium">Lokasi Saat Ini</label>
                                    <div class="relative">
                                        <input type="text" id="location" name="location" 
                                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 shadow-sm"
                                               placeholder="Mendeteksi lokasi..." readonly>
                                        <button type="button" onclick="getLocation()" 
                                                class="absolute inset-y-0 right-0 flex items-center pr-3 text-blue-600 hover:text-blue-800">
                                            <i class="fas fa-location-arrow"></i>
                                        </button>
                                    </div>
                                </div>
                                
                                <!-- Waktu -->
                                <div class="space-y-2">
                                    <label class="block text-gray-700 font-medium">Waktu Saat Ini (WIB)</label>
                                    <div class="relative">
                                        <input type="text" id="current-time" 
                                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 shadow-sm bg-gray-50"
                                               value="{{ now('Asia/Jakarta')->format('H:i:s') }}" readonly>
                                        <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                            <i class="far fa-clock text-gray-400"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Jenis Absensi -->
                            <div class="mb-6">
                                <label class="block text-gray-700 font-medium mb-2">Jenis Absensi</label>
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                    <label class="flex items-center space-x-3 p-4 border rounded-lg cursor-pointer hover:bg-green-50 hover:border-green-300 transition-colors">
                                        <input type="radio" name="attendance_type" value="masuk" class="h-5 w-5 text-green-600" onchange="toggleReasonField()">
                                        <div>
                                            <span class="block font-medium text-green-700">Masuk</span>
                                            <span class="block text-sm text-gray-500">Hadir bekerja</span>
                                        </div>
                                    </label>
                                    
                                    <label class="flex items-center space-x-3 p-4 border rounded-lg cursor-pointer hover:bg-red-50 hover:border-red-300 transition-colors">
                                        <input type="radio" name="attendance_type" value="sakit" class="h-5 w-5 text-red-600" onchange="toggleReasonField()">
                                        <div>
                                            <span class="block font-medium text-red-700">Sakit</span>
                                            <span class="block text-sm text-gray-500">Tidak masuk karena sakit</span>
                                        </div>
                                    </label>
                                    
                                    <label class="flex items-center space-x-3 p-4 border rounded-lg cursor-pointer hover:bg-yellow-50 hover:border-yellow-300 transition-colors">
                                        <input type="radio" name="attendance_type" value="izin" class="h-5 w-5 text-yellow-600" onchange="toggleReasonField()">
                                        <div>
                                            <span class="block font-medium text-yellow-700">Izin</span>
                                            <span class="block text-sm text-gray-500">Tidak masuk dengan izin</span>
                                        </div>
                                    </label>
                                </div>
                            </div>
                            
                            <!-- Alasan (muncul untuk sakit/izin) -->
                            <div id="reason-field" class="mb-6 hidden">
                                <label for="reason" class="block text-gray-700 font-medium mb-2">
                                    <span id="reason-label">Alasan</span> <span class="text-red-500">*</span>
                                </label>
                                <textarea id="reason" name="reason" rows="3"
                                          class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 shadow-sm"
                                          placeholder="Jelaskan alasan Anda..."></textarea>
                                <p class="text-sm text-gray-500 mt-1">Wajib diisi untuk absensi sakit atau izin</p>
                            </div>
                            
                            <!-- Catatan -->
                            <div class="mb-6">
                                <label for="notes" class="block text-gray-700 font-medium mb-2">Catatan Tambahan (Opsional)</label>
                                <textarea id="notes" name="notes" rows="2"
                                          class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 shadow-sm"
                                          placeholder="Tambahkan catatan jika diperlukan..."></textarea>
                            </div>
                            
                            <!-- Foto Selfie (hanya untuk masuk kerja) -->
                            <div id="photo-field" class="mb-8 hidden">
                                <label class="block text-gray-700 font-medium mb-2">
                                    Foto Selfie <span class="text-red-500">*</span>
                                </label>
                                <div class="border-2 border-dashed border-gray-300 rounded-xl p-6 text-center hover:border-blue-500 transition duration-300">
                                    <div id="camera-area" class="cursor-pointer">
                                        <div id="camera-prompt" class="flex flex-col items-center justify-center space-y-3">
                                            <i class="fas fa-camera text-3xl text-blue-500"></i>
                                            <p class="text-gray-600">Klik untuk mengambil foto</p>
                                            <p class="text-sm text-gray-500">Pastikan wajah terlihat jelas</p>
                                        </div>
                                        <div id="camera-preview" class="hidden">
                                            <video id="video" width="320" height="240" autoplay class="mx-auto mb-3 rounded-lg"></video>
                                            <canvas id="canvas" width="320" height="240" class="hidden"></canvas>
                                            <button type="button" onclick="capturePhoto()" 
                                                    class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition duration-300">
                                                Ambil Foto
                                            </button>
                                        </div>
                                        <div id="photo-result" class="hidden">
                                            <img id="photo" src="" class="mx-auto mb-3 rounded-lg max-h-48">
                                            <input type="hidden" id="photo_data" name="photo">
                                            <button type="button" onclick="retakePhoto()" 
                                                    class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition duration-300 mr-2">
                                                Ambil Ulang
                                            </button>
                                            <button type="button" onclick="usePhoto()" 
                                                    class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition duration-300">
                                                Gunakan Foto Ini
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <p class="text-sm text-gray-500 mt-2">Wajib mengambil foto selfie untuk absensi masuk</p>
                            </div>
                            
                            <!-- Tombol Submit -->
                            <div class="flex justify-end">
                                <button type="submit" 
                                        class="px-6 py-3 bg-gradient-to-r from-blue-600 to-blue-800 text-white rounded-lg hover:from-blue-700 hover:to-blue-900 transition duration-300 flex items-center justify-center shadow-md hover:shadow-lg">
                                    <i class="fas fa-check-circle mr-2"></i> Submit Absensi
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
                
                <!-- Riwayat Absensi -->
                <div class="bg-white rounded-xl shadow-lg overflow-hidden border border-gray-100">
                    <div class="bg-gradient-to-r from-green-600 to-green-800 text-white px-6 py-4">
                        <h3 class="text-lg font-semibold">Riwayat Absensi 7 Hari Terakhir</h3>
                    </div>
                    <div class="p-6">
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Waktu</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Keterangan</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    <!-- Contoh Data -->
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">Senin, 10 Jun 2024</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">08:05:23 WIB</td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                Masuk
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-500">-</td>
                                    </tr>
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">Minggu, 9 Jun 2024</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">-</td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                                Sakit
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-500">Demam tinggi</td>
                                    </tr>
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">Sabtu, 8 Jun 2024</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">-</td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                                Izin
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-500">Acara keluarga</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        
                        <a href="#" class="block mt-6 text-green-600 hover:text-green-800 font-medium text-center">
                            Lihat Semua Riwayat <i class="fas fa-arrow-right ml-2"></i>
                        </a>
                    </div>
                </div>
            </div>
        </main>
    </div>

    @push('scripts')
    <script>
        // Update waktu secara real-time dengan zona waktu Indonesia
        function updateTime() {
            const now = new Date();
            // Format waktu untuk WIB (UTC+7)
            const options = {
                timeZone: 'Asia/Jakarta',
                hour12: false,
                hour: '2-digit',
                minute: '2-digit',
                second: '2-digit'
            };
            const timeString = now.toLocaleTimeString('id-ID', options);
            document.getElementById('current-time').value = timeString;
        }
        setInterval(updateTime, 1000);
        
        // Toggle field alasan dan foto berdasarkan jenis absensi
        function toggleReasonField() {
            const attendanceType = document.querySelector('input[name="attendance_type"]:checked');
            const reasonField = document.getElementById('reason-field');
            const photoField = document.getElementById('photo-field');
            const reasonLabel = document.getElementById('reason-label');
            const reasonTextarea = document.getElementById('reason');
            
            if (attendanceType) {
                const value = attendanceType.value;
                
                if (value === 'sakit' || value === 'izin') {
                    reasonField.classList.remove('hidden');
                    reasonTextarea.setAttribute('required', 'required');
                    
                    if (value === 'sakit') {
                        reasonLabel.textContent = 'Alasan Sakit';
                        reasonTextarea.placeholder = 'Jelaskan kondisi sakit Anda (contoh: demam, flu, sakit kepala, dll)...';
                    } else {
                        reasonLabel.textContent = 'Alasan Izin';
                        reasonTextarea.placeholder = 'Jelaskan alasan izin Anda (contoh: acara keluarga, keperluan pribadi, dll)...';
                    }
                    
                    // Sembunyikan field foto untuk sakit/izin
                    photoField.classList.add('hidden');
                    document.getElementById('photo_data').removeAttribute('required');
                } else {
                    reasonField.classList.add('hidden');
                    reasonTextarea.removeAttribute('required');
                    reasonTextarea.value = '';
                }
                
                if (value === 'masuk') {
                    // Tampilkan field foto untuk masuk
                    photoField.classList.remove('hidden');
                    document.getElementById('photo_data').setAttribute('required', 'required');
                } else {
                    photoField.classList.add('hidden');
                    document.getElementById('photo_data').removeAttribute('required');
                }
            }
        }
        
        // Geolokasi
        function getLocation() {
            if (navigator.geolocation) {
                document.getElementById('location').placeholder = "Mendeteksi lokasi...";
                navigator.geolocation.getCurrentPosition(
                    (position) => {
                        const lat = position.coords.latitude;
                        const lng = position.coords.longitude;
                        
                        // Reverse geocoding (contoh sederhana)
                        fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lng}`)
                            .then(response => response.json())
                            .then(data => {
                                const address = data.display_name || "Lokasi tidak diketahui";
                                document.getElementById('location').value = address;
                            })
                            .catch(() => {
                                document.getElementById('location').value = `${lat.toFixed(6)}, ${lng.toFixed(6)}`;
                            });
                    },
                    (error) => {
                        let message = "Gagal mendapatkan lokasi";
                        switch(error.code) {
                            case error.PERMISSION_DENIED:
                                message = "Izin lokasi ditolak";
                                break;
                            case error.POSITION_UNAVAILABLE:
                                message = "Informasi lokasi tidak tersedia";
                                break;
                            case error.TIMEOUT:
                                message = "Permintaan lokasi timeout";
                                break;
                        }
                        document.getElementById('location').value = message;
                    }
                );
            } else {
                document.getElementById('location').value = "Geolokasi tidak didukung di browser ini";
            }
        }
        
        // Kamera untuk selfie
        let stream = null;
        
        function startCamera() {
            document.getElementById('camera-prompt').classList.add('hidden');
            document.getElementById('camera-preview').classList.remove('hidden');
            
            navigator.mediaDevices.getUserMedia({ video: true, audio: false })
                .then(function(s) {
                    stream = s;
                    const video = document.getElementById('video');
                    video.srcObject = stream;
                })
                .catch(function(err) {
                    console.error("Error accessing camera: ", err);
                    alert("Tidak dapat mengakses kamera: " + err.message);
                });
        }
        
        function capturePhoto() {
            const video = document.getElementById('video');
            const canvas = document.getElementById('canvas');
            const context = canvas.getContext('2d');
            
            canvas.width = video.videoWidth;
            canvas.height = video.videoHeight;
            context.drawImage(video, 0, 0, canvas.width, canvas.height);
            
            // Stop kamera
            if (stream) {
                stream.getTracks().forEach(track => track.stop());
            }
            
            document.getElementById('camera-preview').classList.add('hidden');
            document.getElementById('photo-result').classList.remove('hidden');
            document.getElementById('photo').src = canvas.toDataURL('image/png');
        }
        
        function retakePhoto() {
            document.getElementById('photo-result').classList.add('hidden');
            startCamera();
        }
        
        function usePhoto() {
            const canvas = document.getElementById('canvas');
            document.getElementById('photo_data').value = canvas.toDataURL('image/jpeg', 0.8);
            document.getElementById('photo-result').classList.add('hidden');
            document.getElementById('camera-prompt').classList.remove('hidden');
            alert("Foto telah dipilih dan akan diupload saat submit");
        }
        
        // Event listener untuk membuka kamera
        document.getElementById('camera-area').addEventListener('click', function() {
            if (!document.getElementById('photo-result').classList.contains('hidden')) return;
            if (document.getElementById('photo-field').classList.contains('hidden')) return;
            startCamera();
        });
        
        // Validasi form sebelum submit
        document.querySelector('form').addEventListener('submit', function(e) {
            const attendanceType = document.querySelector('input[name="attendance_type"]:checked');
            
            if (!attendanceType) {
                e.preventDefault();
                alert('Silakan pilih jenis absensi terlebih dahulu!');
                return;
            }
            
            const value = attendanceType.value;
            
            // Validasi alasan untuk sakit/izin
            if ((value === 'sakit' || value === 'izin') && !document.getElementById('reason').value.trim()) {
                e.preventDefault();
                alert(`Alasan ${value} wajib diisi!`);
                document.getElementById('reason').focus();
                return;
            }
            
            // Validasi foto untuk masuk
            if (value === 'masuk' && !document.getElementById('photo_data').value) {
                e.preventDefault();
                alert('Foto selfie wajib diambil untuk absensi masuk!');
                return;
            }
        });
        
        // Auto-detect lokasi saat halaman dimuat
        window.addEventListener('load', function() {
            getLocation();
        });
    </script>
    @endpush
</x-layout>