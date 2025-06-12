<!-- resources/views/components/sidebar-student.blade.php -->
<div class="sidebar bg-green-800 text-white w-64 min-h-screen hidden md:block">
    <div class="p-5 border-b border-green-700">
        <div class="flex items-center space-x-3">
            <i class="fas fa-book-open text-2xl"></i>
            <h1 class="text-xl font-bold">Jurnal PKL</h1>
        </div>
        <p class="text-sm text-green-200 mt-1">Panel Siswa</p>
    </div>

    <div class="p-4 flex items-center space-x-3 border-b border-green-700">
        <div class="bg-green-600 w-10 h-10 rounded-full flex items-center justify-center">
            <i class="fas fa-user"></i>
        </div>
        <div>
            <p class="font-medium">{{ auth()->user()->name }}</p>
            <p class="text-xs text-green-200">{{ auth()->user()->jurusan ?? 'Jurusan' }}</p>
        </div>
    </div>

    <nav class="py-4">
        @php
            $currentRoute = request()->route()->getName();
        @endphp

        <a href="{{ route('siswa.dashboard') }}" 
           class="sidebar-item flex items-center space-x-3 py-3 px-6 {{ $currentRoute == 'siswa.dashboard' ? 'bg-green-700 border-l-4 border-white' : 'hover:bg-green-700' }}">
            <i class="fas fa-tachometer-alt"></i>
            <span>Dashboard</span>
        </a>
        
        <a href="{{ route('siswa.jurnal.create') }}" 
           class="sidebar-item flex items-center space-x-3 py-3 px-6 {{ $currentRoute == 'siswa.jurnal.create' ? 'bg-green-700 border-l-4 border-white' : 'hover:bg-green-700' }}">
            <i class="fas fa-plus-circle"></i>
            <span>Buat Jurnal Baru</span>
        </a>
        
        <a href="{{ route('siswa.absensi') }}" 
           class="sidebar-item flex items-center space-x-3 py-3 px-6 {{ $currentRoute == 'siswa.absensi' ? 'bg-green-700 border-l-4 border-white' : 'hover:bg-green-700' }}">
            <i class="fas fa-clipboard-list"></i>
            <span>Absen</span>
        </a>
        
        <a href="{{ route('siswa.riwayat') }}" 
           class="sidebar-item flex items-center space-x-3 py-3 px-6 {{ $currentRoute == 'siswa.riwayat' ? 'bg-green-700 border-l-4 border-white' : 'hover:bg-green-700' }}">
            <i class="fas fa-history"></i>
            <span>Riwayat Jurnal</span>
        </a>
        
        <a href="#" 
           class="sidebar-item flex items-center space-x-3 py-3 px-6 {{ $currentRoute == 'siswa.statistik' ? 'bg-green-700 border-l-4 border-white' : 'hover:bg-green-700' }}">
            <i class="fas fa-chart-line"></i>
            <span>Statistik Saya</span>
        </a>
        
        <a href="{{ route('profile.edit') }}" 
           class="sidebar-item flex items-center space-x-3 py-3 px-6 {{ $currentRoute == 'profile.edit' ? 'bg-green-700 border-l-4 border-white' : 'hover:bg-green-700' }}">
            <i class="fas fa-user-cog"></i>
            <span>Profil Saya</span>
        </a>
        
        <form method="POST" action="{{ route('logout') }}" class="sidebar-item flex items-center space-x-3 py-3 px-6 hover:bg-green-700">
            @csrf
            <button type="submit" class="w-full text-left">
                <i class="fas fa-sign-out-alt"></i>
                <span>Keluar</span>
            </button>
        </form>
    </nav>
</div>

<style>
    .sidebar-item {
        transition: all 0.3s ease;
    }
    .sidebar-item:hover {
        transform: translateX(3px);
    }
</style>