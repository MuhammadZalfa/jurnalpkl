<x-layout title="Absensi - Jurnal PKL">
    <x-sidebar-student />
    
    <div class="flex-1 flex flex-col">
        <x-header title="Absensi Harian" />
        
        <main class="flex-1 p-4 md:p-6">
            <div class="max-w-4xl mx-auto">
                <!-- Session Messages -->
                @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-6">
                    {{ session('success') }}
                </div>
                @endif
                
                @if(session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-6">
                    {{ session('error') }}
                </div>
                @endif
                
                @if($errors->any())
                <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6">
                    <div class="font-bold">Terdapat kesalahan:</div>
                    <ul class="list-disc list-inside">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif
                
                <!-- Today's Attendance Card -->
                <div class="bg-white rounded-xl shadow-lg overflow-hidden mb-6 border border-gray-100">
                    <div class="bg-gradient-to-r from-blue-600 to-blue-800 text-white px-6 py-4">
                        <div class="flex justify-between items-center">
                            <div>
                                <h1 class="text-xl font-semibold">Absensi Hari Ini</h1>
                                <p class="text-blue-100 text-sm mt-1">{{ now('Asia/Jakarta')->translatedFormat('l, d F Y') }}</p>
                            </div>
                            <div class="text-right">
                                <p class="text-sm font-medium">Status</p>
                                @if($todayAttendance)
                                <span class="inline-block px-3 py-1 rounded-full text-xs font-semibold 
                                    {{ $todayAttendance->type === 'masuk' 
                                        ? ($todayAttendance->time_out ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800')
                                        : ($todayAttendance->type === 'sakit' ? 'bg-red-100 text-red-800' : 'bg-yellow-100 text-yellow-800') }}">
                                    {{ $todayAttendance->time_out ? 'Selesai' : ucfirst($todayAttendance->type) }}
                                </span>
                                @else
                                <span class="inline-block px-3 py-1 rounded-full text-xs font-semibold bg-yellow-100 text-yellow-800">
                                    Belum Absen
                                </span>
                                @endif
                            </div>
                        </div>
                    </div>
                    
                    <div class="p-6">
                        @if(!$todayAttendance)
                        <!-- Check-in Form -->
                        <form action="{{ route('siswa.absensi.store') }}" method="POST" id="attendance-form">
                            @csrf
                            
                            <div class="mb-6">
                                <label class="block text-gray-700 font-medium">Waktu Saat Ini (WIB)</label>
                                <input type="text" id="current-time" 
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg bg-gray-50"
                                       value="{{ now('Asia/Jakarta')->format('H:i:s') }}" readonly>
                            </div>
                            
                            <div class="mb-6">
                                <label class="block text-gray-700 font-medium mb-2">Jenis Absensi <span class="text-red-500">*</span></label>
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                    <label class="flex items-center space-x-3 p-4 border rounded-lg cursor-pointer hover:bg-green-50 hover:border-green-300 transition-colors">
                                        <input type="radio" name="attendance_type" value="masuk" class="h-5 w-5 text-green-600" 
                                               {{ old('attendance_type') === 'masuk' ? 'checked' : '' }} required>
                                        <div>
                                            <span class="block font-medium text-green-700">Masuk</span>
                                            <span class="block text-sm text-gray-500">Hadir bekerja</span>
                                        </div>
                                    </label>
                                    
                                    <label class="flex items-center space-x-3 p-4 border rounded-lg cursor-pointer hover:bg-red-50 hover:border-red-300 transition-colors">
                                        <input type="radio" name="attendance_type" value="sakit" class="h-5 w-5 text-red-600"
                                               {{ old('attendance_type') === 'sakit' ? 'checked' : '' }}>
                                        <div>
                                            <span class="block font-medium text-red-700">Sakit</span>
                                            <span class="block text-sm text-gray-500">Tidak masuk karena sakit</span>
                                        </div>
                                    </label>
                                    
                                    <label class="flex items-center space-x-3 p-4 border rounded-lg cursor-pointer hover:bg-yellow-50 hover:border-yellow-300 transition-colors">
                                        <input type="radio" name="attendance_type" value="izin" class="h-5 w-5 text-yellow-600"
                                               {{ old('attendance_type') === 'izin' ? 'checked' : '' }}>
                                        <div>
                                            <span class="block font-medium text-yellow-700">Izin</span>
                                            <span class="block text-sm text-gray-500">Tidak masuk dengan izin</span>
                                        </div>
                                    </label>
                                </div>
                                @error('attendance_type')
                                <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div id="reason-field" class="mb-6 {{ in_array(old('attendance_type'), ['sakit', 'izin']) ? '' : 'hidden' }}">
                                <label for="reason" class="block text-gray-700 font-medium mb-2">
                                    <span id="reason-label">
                                        @if(old('attendance_type') === 'sakit') Alasan Sakit
                                        @elseif(old('attendance_type') === 'izin') Alasan Izin
                                        @else Alasan
                                        @endif
                                    </span> (Opsional)
                                </label>
                                <textarea id="reason" name="reason" rows="3"
                                          class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 shadow-sm"
                                          placeholder="Opsional: Jelaskan alasan Anda...">{{ old('reason') }}</textarea>
                                <p class="text-sm text-gray-500 mt-1">Boleh diisi untuk absensi sakit atau izin</p>
                            </div>
                            
                            <div class="mb-6">
                                <label for="notes" class="block text-gray-700 font-medium mb-2">Catatan Tambahan (Opsional)</label>
                                <textarea id="notes" name="notes" rows="2"
                                          class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 shadow-sm"
                                          placeholder="Tambahkan catatan jika diperlukan...">{{ old('notes') }}</textarea>
                            </div>
                            
                            <div class="flex justify-end">
                                <button type="submit" id="submit-btn"
                                        class="px-6 py-3 bg-gradient-to-r from-blue-600 to-blue-800 text-white rounded-lg hover:from-blue-700 hover:to-blue-900 transition duration-300 flex items-center justify-center shadow-md hover:shadow-lg">
                                    <i class="fas fa-check-circle mr-2"></i> Submit Absensi
                                </button>
                            </div>
                        </form>
                        @elseif($todayAttendance->type === 'masuk' && !$todayAttendance->time_out)
                        <!-- Simplified Check-out Form -->
                        <form action="{{ route('siswa.absensi.store') }}" method="POST" id="checkout-form">
                            @csrf
                            <div class="bg-blue-50 border border-blue-200 rounded-lg p-6">
                                <div class="mb-4">
                                    <h3 class="text-lg font-medium text-blue-800 mb-2">Absen Pulang</h3>
                                    <p class="text-gray-600">Anda telah absen masuk pada:</p>
                                </div>
                                
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                                    <div>
                                        <label class="block text-gray-700 font-medium mb-1">Waktu Masuk</label>
                                        <div class="px-4 py-3 bg-gray-100 rounded-lg">
                                            {{ \Carbon\Carbon::parse($todayAttendance->time_in)->format('H:i:s') }} WIB
                                        </div>
                                    </div>
                                    <div>
                                        <label class="block text-gray-700 font-medium mb-1">Waktu Pulang</label>
                                        <div class="px-4 py-3 bg-gray-100 rounded-lg" id="current-time-checkout">
                                            {{ now('Asia/Jakarta')->format('H:i:s') }} WIB
                                        </div>
                                    </div>
                                </div>

                                <div class="flex justify-end">
                                    <button type="submit" id="checkout-btn"
                                            class="px-6 py-3 bg-gradient-to-r from-green-600 to-green-800 text-white rounded-lg hover:from-green-700 hover:to-green-900 transition duration-300 flex items-center justify-center shadow-md hover:shadow-lg">
                                        <i class="fas fa-sign-out-alt mr-2"></i> Konfirmasi Absen Pulang
                                    </button>
                                </div>
                            </div>
                        </form>
                        @else
                        <!-- Already completed attendance -->
                        <div class="bg-blue-50 border border-blue-200 rounded-lg p-6 text-center">
                            <i class="fas fa-check-circle text-4xl text-blue-500 mb-3"></i>
                            <h3 class="text-lg font-medium text-blue-800">Anda sudah melakukan absensi hari ini.</h3>
                            <p class="text-blue-600">Status: 
                                <span class="font-semibold">{{ ucfirst($todayAttendance->type) }}</span>
                            </p>
                            @if($todayAttendance->time_in)
                                <p class="mt-2">
                                    <span class="font-medium">Masuk:</span> 
                                    {{ \Carbon\Carbon::parse($todayAttendance->time_in)->format('H:i:s') }} WIB
                                </p>
                            @endif
                            @if($todayAttendance->time_out)
                                <p>
                                    <span class="font-medium">Pulang:</span> 
                                    {{ \Carbon\Carbon::parse($todayAttendance->time_out)->format('H:i:s') }} WIB
                                </p>
                                <p>
                                    <span class="font-medium">Durasi Kerja:</span> 
                                    <span class="font-semibold text-green-600">{{ $todayAttendance->duration_formatted }}</span>
                                </p>
                            @endif
                        </div>
                        @endif
                    </div>
                </div>
                
                <!-- Attendance History -->
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
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Masuk</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pulang</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Durasi</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Keterangan</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($attendances as $attendance)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ \Carbon\Carbon::parse($attendance->date)->translatedFormat('l, d F Y') }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $attendance->time_in ? \Carbon\Carbon::parse($attendance->time_in)->format('H:i:s') . ' WIB' : '-' }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $attendance->time_out ? \Carbon\Carbon::parse($attendance->time_out)->format('H:i:s') . ' WIB' : '-' }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                                {{ $attendance->type === 'masuk' 
                                                    ? ($attendance->time_out ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800')
                                                    : ($attendance->type === 'sakit' ? 'bg-red-100 text-red-800' : 'bg-yellow-100 text-yellow-800') }}">
                                                {{ $attendance->time_out ? 'Selesai' : ucfirst($attendance->type) }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            @if($attendance->time_out && $attendance->time_in)
                                                <span class="font-medium">{{ $attendance->duration_formatted }}</span>
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-500">
                                            {{ $attendance->notes ?? '-' }}
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    @push('scripts')
    <script>
        // Update current time
        function updateTime() {
            const now = new Date();
            const options = {
                timeZone: 'Asia/Jakarta',
                hour12: false,
                hour: '2-digit',
                minute: '2-digit',
                second: '2-digit'
            };
            const timeString = now.toLocaleTimeString('id-ID', options);
            
            // Update check-in time
            const currentTimeElement = document.getElementById('current-time');
            if (currentTimeElement) {
                currentTimeElement.value = timeString;
            }
            
            // Update check-out time
            const checkoutTimeElement = document.getElementById('current-time-checkout');
            if (checkoutTimeElement) {
                checkoutTimeElement.textContent = timeString + ' WIB';
            }
        }
        setInterval(updateTime, 1000);
        
        // Toggle reason field for check-in
        function toggleReasonField() {
            const type = document.querySelector('input[name="attendance_type"]:checked')?.value;
            const reasonField = document.getElementById('reason-field');
            const reasonLabel = document.getElementById('reason-label');
            
            if (type === 'sakit' || type === 'izin') {
                reasonField.classList.remove('hidden');
                reasonLabel.textContent = type === 'sakit' ? 'Alasan Sakit' : 'Alasan Izin';
            } else {
                reasonField.classList.add('hidden');
            }
        }
        
        // Initialize form
        document.addEventListener('DOMContentLoaded', function() {
            // Set up radio button events for check-in
            document.querySelectorAll('input[name="attendance_type"]').forEach(radio => {
                radio.addEventListener('change', toggleReasonField);
            });
            
            // Form submission for check-in
            const attendanceForm = document.getElementById('attendance-form');
            if (attendanceForm) {
                attendanceForm.addEventListener('submit', function() {
                    const submitBtn = document.getElementById('submit-btn');
                    submitBtn.disabled = true;
                    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Menyimpan...';
                });
            }
            
            // Form submission for check-out
            const checkoutForm = document.getElementById('checkout-form');
            if (checkoutForm) {
                checkoutForm.addEventListener('submit', function() {
                    const btn = document.getElementById('checkout-btn');
                    btn.disabled = true;
                    btn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Menyimpan...';
                });
            }
            
            // Initial field state
            toggleReasonField();
        });
    </script>
    @endpush
</x-layout> 