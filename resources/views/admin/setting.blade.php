<x-layout title="Pengaturan - Admin">
    <!-- Sidebar Admin -->
    <x-sidebar-admin />
    
    <div class="flex-1 flex flex-col">
        <x-header title="Pengaturan Admin" />
        
        <main class="flex-1 p-4 md:p-6">
            <div class="max-w-4xl mx-auto">
                <!-- Profile Card -->
                <div class="bg-white rounded-xl shadow-lg overflow-hidden border border-gray-100 mb-6">
                    <div class="bg-gradient-to-r from-blue-600 to-blue-800 text-white px-6 py-4">
                        <h3 class="text-lg font-semibold">Informasi Admin</h3>
                    </div>
                    <div class="p-6">
                        <div class="flex flex-col md:flex-row gap-6">
                            <!-- Photo -->
                            <div class="flex-shrink-0">
                                <div class="w-32 h-32 rounded-full bg-gray-200 flex items-center justify-center overflow-hidden">
                                    @if(Auth::user()->photo)
                                        <img src="{{ asset('storage/' . Auth::user()->photo) }}" alt="Foto Profil" class="w-full h-full object-cover">
                                    @else
                                        <i class="fas fa-user text-gray-400 text-5xl"></i>
                                    @endif
                                </div>
                            </div>
                            
                            <!-- Profile Info -->
                            <div class="flex-1">
                                <div class="space-y-4">
                                    <div>
                                        <h4 class="text-lg font-semibold text-gray-800">{{ Auth::user()->name }}</h4>
                                        <p class="text-gray-600">{{ Auth::user()->email }}</p>
                                    </div>
                                    
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        <div>
                                            <p class="text-sm text-gray-500">NIP</p>
                                            <p class="font-medium">{{ Auth::user()->ni ?? '-' }}</p>
                                        </div>
                                        <div>
                                            <p class="text-sm text-gray-500">Jabatan</p>
                                            <p class="font-medium">Guru Pembimbing</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Change Password Card -->
                <div class="bg-white rounded-xl shadow-lg overflow-hidden border border-gray-100">
                    <div class="bg-gradient-to-r from-purple-600 to-purple-800 text-white px-6 py-4">
                        <h3 class="text-lg font-semibold">Ganti Password</h3>
                    </div>
                    <div class="p-6">
                        <form action="{{ route('admin.setting.update-password') }}" method="POST">
                            @csrf
                            @method('PUT')
                            
                            <div class="space-y-4">
                                <!-- Current Password -->
                                <div>
                                    <label for="current_password" class="block text-sm font-medium text-gray-700 mb-1">Password Saat Ini</label>
                                    <div class="relative">
                                        <input 
                                            type="password" 
                                            id="current_password" 
                                            name="current_password" 
                                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                            required
                                            placeholder="Masukkan password saat ini"
                                        >
                                        <button type="button" class="absolute right-3 top-2 text-gray-400 hover:text-gray-600 toggle-password">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                    </div>
                                    @error('current_password')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                
                                <!-- New Password -->
                                <div>
                                    <label for="new_password" class="block text-sm font-medium text-gray-700 mb-1">Password Baru</label>
                                    <div class="relative">
                                        <input 
                                            type="password" 
                                            id="new_password" 
                                            name="new_password" 
                                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                            required
                                            placeholder="Masukkan password baru"
                                        >
                                        <button type="button" class="absolute right-3 top-2 text-gray-400 hover:text-gray-600 toggle-password">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                    </div>
                                    <p class="mt-1 text-xs text-gray-500">
                                        Password minimal 8 karakter dan mengandung huruf besar, huruf kecil, angka, dan simbol.
                                    </p>
                                    @error('new_password')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                
                                <!-- Confirm New Password -->
                                <div>
                                    <label for="new_password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">Konfirmasi Password Baru</label>
                                    <div class="relative">
                                        <input 
                                            type="password" 
                                            id="new_password_confirmation" 
                                            name="new_password_confirmation" 
                                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                            required
                                            placeholder="Konfirmasi password baru"
                                        >
                                        <button type="button" class="absolute right-3 top-2 text-gray-400 hover:text-gray-600 toggle-password">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                    </div>
                                </div>
                                
                                <!-- Submit Button -->
                                <div class="pt-2">
                                    <button type="submit" class="px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition duration-300 flex items-center justify-center">
                                        <i class="fas fa-save mr-2"></i> Simpan Perubahan
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </main>
    </div>

    @if(session('success'))
        <x-notification type="success" message="{{ session('success') }}" />
    @endif

    @push('scripts')
        <script>
            // Toggle password visibility
            document.querySelectorAll('.toggle-password').forEach(button => {
                button.addEventListener('click', function() {
                    const input = this.previousElementSibling;
                    const icon = this.querySelector('i');
                    
                    if (input.type === 'password') {
                        input.type = 'text';
                        icon.classList.remove('fa-eye');
                        icon.classList.add('fa-eye-slash');
                    } else {
                        input.type = 'password';
                        icon.classList.remove('fa-eye-slash');
                        icon.classList.add('fa-eye');
                    }
                });
            });
        </script>
    @endpush
</x-layout>