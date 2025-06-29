<!-- Admin Sidebar -->
<div class="sidebar bg-blue-800 text-white w-64 min-h-screen hidden md:block">
    <div class="p-5 border-b border-blue-700">
        <div class="flex items-center space-x-3">
            <i class="fas fa-book-open text-2xl"></i>
            <h1 class="text-xl font-bold">Jurnal PKL</h1>
        </div>
        <p class="text-sm text-blue-200 mt-1">Administrator Panel</p>
    </div>

    <div class="p-4 flex items-center space-x-3 border-b border-blue-700">
        <div class="bg-blue-600 w-10 h-10 rounded-full flex items-center justify-center">
            <i class="fas fa-user"></i>
        </div>
        <div>
            <p class="font-medium">{{ auth()->user()->name }}</p>
            <p class="text-xs text-blue-200">Admin</p>
        </div>
    </div>

    <nav class="py-4">
        @php
            $currentRoute = request()->route()->getName();
        @endphp

        <a href="{{ route('admin.dashboard') }}" class="sidebar-item flex items-center space-x-3 py-3 px-6 {{ $currentRoute === 'admin.dashboard' ? 'bg-blue-700 border-l-4 border-white' : 'hover:bg-blue-700' }}">
            <i class="fas fa-tachometer-alt"></i>
            <span>Dashboard</span>
        </a>
        <a href="{{ route('admin.user-upload') }}" class="sidebar-item flex items-center space-x-3 py-3 px-6 {{ $currentRoute === 'admin.students' ? 'bg-blue-700 border-l-4 border-white' : 'hover:bg-blue-700' }}">
            <i class="fas fa-users"></i>
            <span>Manajemen Siswa</span>
        </a>
        <a href="{{ route('admin.jurnal') }}" class="sidebar-item flex items-center space-x-3 py-3 px-6 {{ $currentRoute === 'admin.jurnal' ? 'bg-blue-700 border-l-4 border-white' : 'hover:bg-blue-700' }}">
            <i class="fas fa-book"></i>
            <span>Verifikasi Jurnal</span>
        </a>
        <a href="{{ route('admin.statistik') }}" class="sidebar-item flex items-center space-x-3 py-3 px-6 {{ $currentRoute === 'admin.reports' ? 'bg-blue-700 border-l-4 border-white' : 'hover:bg-blue-700' }}">
            <i class="fas fa-chart-bar"></i>
            <span>Laporan & Statistik</span>
        </a>
        <a href="{{ route('admin.assesment') }}" class="sidebar-item flex items-center space-x-3 py-3 px-6 {{ $currentRoute === 'admin.assesment' ? 'bg-blue-700 border-l-4 border-white' : 'hover:bg-blue-700' }}">
            <i class="fas fa-puzzle-piece"></i>
            <span>Assesment</span>
        </a>
        <a href="{{ route('admin.settings') }}" class="sidebar-item flex items-center space-x-3 py-3 px-6 {{ $currentRoute === 'admin.settings' ? 'bg-blue-700 border-l-4 border-white' : 'hover:bg-blue-700' }}">
            <i class="fas fa-cog"></i>
            <span>Pengaturan</span>
        </a>
        <form method="POST" action="{{ route('logout') }}" class="sidebar-item flex items-center space-x-3 py-3 px-6 hover:bg-blue-700">
            @csrf
            <button type="submit" class="w-full text-left">
                <i class="fas fa-sign-out-alt"></i>
                <span>Keluar</span>
            </button>
        </form>
    </nav>
</div>

