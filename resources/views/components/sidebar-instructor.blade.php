<!-- resources/views/components/sidebar-instructor.blade.php -->
<div class="sidebar bg-blue-800 text-white w-64 min-h-screen hidden md:block">
    <div class="p-5 border-b border-blue-700">
        <div class="flex items-center space-x-3">
            <i class="fas fa-book-open text-2xl"></i>
            <h1 class="text-xl font-bold">Jurnal PKL</h1>
        </div>
        <p class="text-sm text-blue-200 mt-1">Panel Instruktur</p>
    </div>

    <div class="p-4 flex items-center space-x-3 border-b border-blue-700">
        <div class="bg-blue-600 w-10 h-10 rounded-full flex items-center justify-center">
            <i class="fas fa-user-tie"></i>
        </div>
        <div>
            <p class="font-medium">{{ auth()->user()->name }}</p>
            <p class="text-xs text-blue-200">Instruktur</p>
        </div>
    </div>

    <nav class="py-4">
        @php
            $currentRoute = request()->route()->getName();
        @endphp

        <a href="{{ route('instructor.dashboard') }}" class="sidebar-item flex items-center space-x-3 py-3 px-6 {{ str_starts_with($currentRoute, 'instructor.dashboard') ? 'bg-blue-700 border-l-4 border-white' : 'hover:bg-blue-700' }}">
            <i class="fas fa-tachometer-alt"></i>
            <span>Dashboard</span>
        </a>
        <a href="{{ route('instructor.journals') }}" class="sidebar-item flex items-center space-x-3 py-3 px-6 {{ str_starts_with($currentRoute, 'instructor.journals') ? 'bg-blue-700 border-l-4 border-white' : 'hover:bg-blue-700' }}">
            <i class="fas fa-book"></i>
            <span>Jurnal Siswa</span>
        </a>
        <a href="{{ route('instructor.attendances') }}" class="sidebar-item flex items-center space-x-3 py-3 px-6 {{ str_starts_with($currentRoute, 'instructor.attendances') ? 'bg-blue-700 border-l-4 border-white' : 'hover:bg-blue-700' }}">
            <i class="fas fa-calendar-check"></i>
            <span>Daftar Hadir</span>
        </a>
        <a href="{{ route('instructor.assessments.index') }}" class="sidebar-item flex items-center space-x-3 py-3 px-6 {{ str_starts_with($currentRoute, 'instructor.assessments') ? 'bg-blue-700 border-l-4 border-white' : 'hover:bg-blue-700' }}">
            <i class="fas fa-puzzle-piece"></i>
            <span>Penilaian</span>
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