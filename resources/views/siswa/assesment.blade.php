<x-layout title="Assesment - Jurnal PKL">
    <!-- Sidebar -->
    <x-sidebar-student />
    
    <!-- Main Content -->
    <div class="flex-1 flex flex-col">
        <x-header title="Assesment" />
        
        <!-- Content -->
        <main class="flex-1 p-4 md:p-6">
            <h1 class="text-2xl font-bold text-gray-800 mb-6">Assesment Siswa</h1>
            
            @if($monthly1 || $monthly2 || $monthly3)
                <!-- Card Assessment yang Sudah Disetujui/Belum Dikerjakan -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                    @if($monthly1 && $monthly1->status !== 'completed')
                        <div class="bg-white rounded-xl shadow-lg overflow-hidden border-t-4 border-orange-500 h-full">
                            <div class="bg-orange-500 text-white px-6 py-4">
                                <h3 class="text-lg font-semibold">Assesmen Bulanan 1</h3>
                            </div>
                            <div class="p-6 flex flex-col h-full">
                                <div class="mb-4">
                                    <p class="font-medium text-gray-700 mb-1">Batas Waktu:</p>
                                    <p class="text-gray-600">{{ \Carbon\Carbon::parse($monthly1->due_date)->format('d F Y') }}</p>
                                </div>
                                <div class="mb-4">
                                    <p class="font-medium text-gray-700 mb-1">Status:</p>
                                    <span class="inline-block px-3 py-1 rounded-full text-sm font-medium 
                                        {{ $monthly1->status === 'approved' ? 'bg-blue-100 text-blue-800' : 'bg-orange-100 text-orange-800' }}">
                                        {{ $monthly1->status === 'approved' ? 'Disetujui' : 'Belum Di Nilai' }}
                                    </span>
                                </div>
                                <div class="">
                                    <a href="{{ route('siswa.assesmen.monthly1.show', ['id' => $monthly1->id]) }}" 
                                    class="block text-center bg-orange-500 hover:bg-orange-600 text-white font-medium py-2 px-4 rounded-lg transition duration-300">
                                        {{ $monthly1->status === 'approved' ? 'Lihat Assesmen' : 'Lihat Assesmen' }}
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endif

                    @if($monthly2 && $monthly2->status !== 'completed')
                        <div class="bg-white rounded-xl shadow-lg overflow-hidden border-t-4 border-orange-500 h-full">
                            <div class="bg-orange-500 text-white px-6 py-4">
                                <h3 class="text-lg font-semibold">Assesmen Bulanan 2</h3>
                            </div>
                            <div class="p-6 flex flex-col h-full">
                                <div class="mb-4">
                                    <p class="font-medium text-gray-700 mb-1">Batas Waktu:</p>
                                    <p class="text-gray-600">{{ \Carbon\Carbon::parse($monthly2->due_date)->format('d F Y') }}</p>
                                </div>
                                <div class="mb-4">
                                    <p class="font-medium text-gray-700 mb-1">Status:</p>
                                    <span class="inline-block px-3 py-1 rounded-full text-sm font-medium 
                                        {{ $monthly2->status === 'approved' ? 'bg-blue-100 text-blue-800' : 'bg-orange-100 text-orange-800' }}">
                                        {{ $monthly2->status === 'approved' ? 'Disetujui' : 'Belum Di Nilai' }}
                                    </span>
                                </div>
                                <div class="">
                                    <a href="{{ route('siswa.assesmen.monthly2.show', ['id' => $monthly2->id]) }}" 
                                    class="block text-center bg-orange-500 hover:bg-orange-600 text-white font-medium py-2 px-4 rounded-lg transition duration-300">
                                        {{ $monthly2->status === 'approved' ? 'Lihat Assesmen' : 'Lihat Assesmen' }}
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endif

                    @if($monthly3 && $monthly3->status !== 'completed')
                        <div class="bg-white rounded-xl shadow-lg overflow-hidden border-t-4 border-orange-500 h-full">
                            <div class="bg-orange-500 text-white px-6 py-4">
                                <h3 class="text-lg font-semibold">Assesmen Bulanan 3</h3>
                            </div>
                            <div class="p-6 flex flex-col h-full">
                                <div class="mb-4">
                                    <p class="font-medium text-gray-700 mb-1">Batas Waktu:</p>
                                    <p class="text-gray-600">{{ \Carbon\Carbon::parse($monthly3->due_date)->format('d F Y') }}</p>
                                </div>
                                <div class="mb-4">
                                    <p class="font-medium text-gray-700 mb-1">Status:</p>
                                    <span class="inline-block px-3 py-1 rounded-full text-sm font-medium 
                                        {{ $monthly3->status === 'approved' ? 'bg-blue-100 text-blue-800' : 'bg-orange-100 text-orange-800' }}">
                                        {{ $monthly3->status === 'approved' ? 'Disetujui' : 'Belum Di Nilai' }}
                                    </span>
                                </div>
                                <div class="">
                                    <a href="{{ route('siswa.assesmen.monthly3.show', ['id' => $monthly3->id]) }}" 
                                    class="block text-center bg-orange-500 hover:bg-orange-600 text-white font-medium py-2 px-4 rounded-lg transition duration-300">
                                        {{ $monthly3->status === 'approved' ? 'Lihat Assesmen' : 'Lihat Assesmen' }}
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Card Assessment yang Menunggu Persetujuan -->
                @if(($monthly1 && $monthly1->status === 'completed') || 
                    ($monthly2 && $monthly2->status === 'completed') || 
                    ($monthly3 && $monthly3->status === 'completed'))
                    <h2 class="text-xl font-semibold text-gray-800 mb-4">Menunggu Persetujuan</h2>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                        @if($monthly1 && $monthly1->status === 'completed')
                            <div class="bg-white rounded-xl shadow-lg overflow-hidden border-t-4 border-green-500 h-full">
                                <div class="bg-green-500 text-white px-6 py-4">
                                    <h3 class="text-lg font-semibold">Assesmen Bulanan 1</h3>
                                </div>
                                <div class="p-6 flex flex-col h-full">
                                    <div class="mb-4">
                                        <p class="font-medium text-gray-700 mb-1">Batas Waktu:</p>
                                        <p class="text-gray-600">{{ \Carbon\Carbon::parse($monthly1->due_date)->format('d F Y') }}</p>
                                    </div>
                                    <div class="mb-4">
                                        <p class="font-medium text-gray-700 mb-1">Status:</p>
                                        <span class="inline-block px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                                            Menunggu Persetujuan
                                        </span>
                                    </div>
                                    <div class="">
                                        <a href="{{ route('siswa.assesmen.monthly1.show', ['id' => $monthly1->id]) }}" 
                                        class="block text-center bg-green-500 hover:bg-green-600 text-white font-medium py-2 px-4 rounded-lg transition duration-300">
                                            Lihat Assesmen
                                            <i class="fas fa-eye ml-2"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endif

                        @if($monthly2 && $monthly2->status === 'completed')
                            <div class="bg-white rounded-xl shadow-lg overflow-hidden border-t-4 border-green-500 h-full">
                                <div class="bg-green-500 text-white px-6 py-4">
                                    <h3 class="text-lg font-semibold">Assesmen Bulanan 2</h3>
                                </div>
                                <div class="p-6 flex flex-col h-full">
                                    <div class="mb-4">
                                        <p class="font-medium text-gray-700 mb-1">Batas Waktu:</p>
                                        <p class="text-gray-600">{{ \Carbon\Carbon::parse($monthly2->due_date)->format('d F Y') }}</p>
                                    </div>
                                    <div class="mb-4">
                                        <p class="font-medium text-gray-700 mb-1">Status:</p>
                                        <span class="inline-block px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                                            Menunggu Persetujuan
                                        </span>
                                    </div>
                                    <div class="">
                                        <a href="{{ route('siswa.assesmen.monthly2.show', ['id' => $monthly2->id]) }}" 
                                        class="block text-center bg-green-500 hover:bg-green-600 text-white font-medium py-2 px-4 rounded-lg transition duration-300">
                                            Lihat Assesmen
                                            <i class="fas fa-eye ml-2"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endif

                        @if($monthly3 && $monthly3->status === 'completed')
                            <div class="bg-white rounded-xl shadow-lg overflow-hidden border-t-4 border-green-500 h-full">
                                <div class="bg-green-500 text-white px-6 py-4">
                                    <h3 class="text-lg font-semibold">Assesmen Bulanan 3</h3>
                                </div>
                                <div class="p-6 flex flex-col h-full">
                                    <div class="mb-4">
                                        <p class="font-medium text-gray-700 mb-1">Batas Waktu:</p>
                                        <p class="text-gray-600">{{ \Carbon\Carbon::parse($monthly3->due_date)->format('d F Y') }}</p>
                                    </div>
                                    <div class="mb-4">
                                        <p class="font-medium text-gray-700 mb-1">Status:</p>
                                        <span class="inline-block px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                                            Menunggu Persetujuan
                                        </span>
                                    </div>
                                    <div class="">
                                        <a href="{{ route('siswa.assesmen.monthly3.show', ['id' => $monthly3->id]) }}" 
                                        class="block text-center bg-green-500 hover:bg-green-600 text-white font-medium py-2 px-4 rounded-lg transition duration-300">
                                            Lihat Assesmen
                                            <i class="fas fa-eye ml-2"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                @endif
            @else
                <div class="bg-white rounded-xl shadow-lg p-6 text-center">
                    <p class="text-gray-600">Belum ada assessment yang tersedia</p>
                </div>
            @endif
        </main>
    </div>
</x-layout>