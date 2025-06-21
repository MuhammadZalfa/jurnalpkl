<x-layout title="Detail Assesment - Admin">
    <!-- Sidebar -->
    <x-sidebar-admin />
    
    <div class="flex-1 flex flex-col">
        <x-header title="Detail Assesment" :subtitle="$assessment->student->name" />
        
        <main class="flex-1 p-4 md:p-6">
            <div class="bg-white rounded-lg shadow p-6 mb-6">
                <h3 class="text-lg font-semibold mb-4">Assesmen Bulanan 1</h3>
                @if($assessment->monthly1)
                    <!-- Tampilkan data assessment 1 -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <p class="font-medium">Kehadiran:</p>
                            <p>{{ $assessment->monthly1->attendance }} - {{ $assessment->monthly1->attendance_desc }}</p>
                        </div>
                        <!-- Tambahkan field lainnya -->
                    </div>
                @else
                    <p class="text-gray-500">Belum dikerjakan</p>
                @endif
            </div>
            
            <!-- Ulangi untuk assessment 2 dan 3 -->
        </main>
    </div>
</x-layout>