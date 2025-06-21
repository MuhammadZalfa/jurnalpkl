<x-layout title="Edit Jurnal - Jurnal PKL">
    <!-- Sidebar -->
    <style>
    .fade-out {
        animation: fadeOut 0.3s;
    }
    
    @keyframes fadeOut {
        from { opacity: 1; }
        to { opacity: 0; }
    }
</style>
    <x-sidebar-student />
    
    <!-- Main Content -->
    <div class="flex-1 flex flex-col">
        <x-header title="Edit Jurnal" />
        
        <!-- Content -->
        <main class="flex-1 p-4 md:p-6">
            <div class="max-w-4xl mx-auto">
                <div class="bg-white rounded-xl shadow-lg p-6">
                    <h2 class="text-xl font-bold text-gray-800 mb-4">Edit Jurnal Harian</h2>
                    
                    <form action="{{ route('siswa.jurnal.update', $journal->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Tanggal -->
                            <div>
                                <label for="date" class="block text-sm font-medium text-gray-700 mb-1">Tanggal</label>
                                <input type="date" id="date" name="date" value="{{ old('date', $journal->date) }}" class="w-full border-gray-300 rounded-lg focus:border-blue-500 focus:ring-blue-500">
                                @error('date')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <!-- Hari ke -->
                            <div>
                                <label for="day_number" class="block text-sm font-medium text-gray-700 mb-1">Hari ke</label>
                                <input type="number" id="day_number" name="day_number" value="{{ old('day_number', $journal->day_number) }}" min="1" class="w-full border-gray-300 rounded-lg focus:border-blue-500 focus:ring-blue-500">
                                @error('day_number')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <!-- Nama Pekerjaan -->
                            <div class="md:col-span-2">
                                <label for="job_name" class="block text-sm font-medium text-gray-700 mb-1">Nama Pekerjaan</label>
                                <input type="text" id="job_name" name="job_name" value="{{ old('job_name', $journal->job_name) }}" class="w-full border-gray-300 rounded-lg focus:border-blue-500 focus:ring-blue-500">
                                @error('job_name')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <!-- Aktivitas -->
                            <div class="md:col-span-2">
                                <label for="activity" class="block text-sm font-medium text-gray-700 mb-1">Aktivitas/Kegiatan</label>
                                <textarea id="activity" name="activity" rows="4" class="w-full border-gray-300 rounded-lg focus:border-blue-500 focus:ring-blue-500">{{ old('activity', $journal->activity) }}</textarea>
                                @error('activity')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <!-- Kendala dan Solusi -->
                            <div class="md:col-span-2">
                                <label for="obstacle" class="block text-sm font-medium text-gray-700 mb-1">Kendala dan Solusi</label>
                                <textarea id="obstacle" name="obstacle" rows="3" class="w-full border-gray-300 rounded-lg focus:border-blue-500 focus:ring-blue-500">{{ old('obstacle', $journal->obstacle) }}</textarea>
                                @error('obstacle')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <!-- Dokumentasi -->
                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-gray-700 mb-1">Dokumentasi (Maks. 5 Foto)</label>
                                <div class="flex items-center justify-center w-full">
                                    <label for="documentation" class="flex flex-col items-center justify-center w-full h-32 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 hover:bg-gray-100">
                                        <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                            <i class="fas fa-cloud-upload-alt text-3xl text-gray-400 mb-2"></i>
                                            <p class="text-sm text-gray-500">Klik untuk upload atau drag & drop</p>
                                            <p class="text-xs text-gray-500">Format: JPEG, PNG (Maks. 5MB per gambar)</p>
                                        </div>
                                        <input id="documentation" name="documentation[]" type="file" class="hidden" multiple accept="image/jpeg,image/png">
                                    </label>
                                </div>
                                @error('documentation')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                                
                                <!-- Tampilkan gambar yang sudah ada -->
                                @if($journal->images->count() > 0)
                                    <div class="mt-4">
                                        <p class="text-sm font-medium text-gray-700 mb-2">Dokumentasi Saat Ini:</p>
                                        <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                                            @foreach($journal->images as $image)
                                                <div class="relative">
                                                    <img src="{{ $image->image_url }}" alt="Dokumentasi" class="rounded-lg w-full h-32 object-cover">
                                                    <button type="button" 
                                                            class="absolute top-0 right-0 bg-red-500 text-white rounded-full p-1 text-xs" 
                                                            onclick="deleteImage({{ $image->id }})">
                                                        <i class="fas fa-times"></i>
                                                    </button>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                        
                        <div class="flex justify-end mt-6">
                            <a href="{{ route('siswa.riwayat') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-6 py-2 rounded-lg mr-2">Batal</a>
                            <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-2 rounded-lg">Simpan Perubahan</button>
                        </div>
                    </form>
                </div>
            </div>
        </main>
    </div>

    <script>
        async function deleteImage(imageId) {
            if (!confirm('Apakah Anda yakin ingin menghapus gambar ini?')) {
                return;
            }

            try {
                // Tampilkan loading indicator
                const button = document.querySelector(`button[onclick*="deleteImage(${imageId})"]`);
                if (button) {
                    button.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
                    button.disabled = true;
                }

                // Gunakan route() dengan parameter yang benar
                const url = `{{ route('siswa.jurnal.hapus-gambar', ['imageId' => 'REPLACE']) }}`.replace('REPLACE', imageId);
                
                // Kirim permintaan DELETE ke server
                const response = await fetch(url, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json',
                        'Content-Type': 'application/json'
                    }
                });

                if (!response.ok) {
                    throw new Error('Gagal menghapus gambar. Status: ' + response.status);
                }

                const data = await response.json();

                if (!data.success) {
                    throw new Error('Gagal menghapus gambar. Server melaporkan error.');
                }

                // Animasi fade out sebelum menghapus elemen
                const imageElements = document.querySelectorAll(`button[onclick*="deleteImage(${imageId})"]`);
                imageElements.forEach(element => {
                    const parent = element.closest('.relative');
                    if (parent) {
                        parent.style.transition = 'opacity 0.3s';
                        parent.style.opacity = '0';
                        
                        // Hapus elemen setelah animasi selesai
                        setTimeout(() => {
                            parent.remove();
                            showToast('success', 'Gambar berhasil dihapus');
                        }, 300);
                    }
                });

            } catch (error) {
                console.error('Error:', error);
                
                // Reset button state
                const buttons = document.querySelectorAll(`button[onclick*="deleteImage(${imageId})"]`);
                buttons.forEach(btn => {
                    btn.innerHTML = '<i class="fas fa-times"></i>';
                    btn.disabled = false;
                });
                
                showToast('error', error.message || 'Terjadi kesalahan saat menghapus gambar');
            }
        }

        // Fungsi untuk menampilkan notifikasi toast (tetap sama)
        function showToast(type, message) {
            // Implementasi toast tetap sama seperti sebelumnya
        }
    </script>
</x-layout>