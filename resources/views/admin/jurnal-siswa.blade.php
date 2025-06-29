<x-layout title="Jurnal Siswa - Jurnal PKL">
    <x-sidebar-admin />
    <div class="flex-1 flex flex-col">
        <x-header-admin title="Jurnal Siswa: {{ $student->name }}" />

        <main class="flex-1 p-4 md:p-6">
            <!-- Tombol kembali -->
            <div class="mb-4">
                <a href="{{ route('admin.dashboard') }}" class="text-blue-600 hover:text-blue-800">
                    &larr; Kembali ke Dashboard
                </a>
            </div>

            <!-- Daftar Jurnal -->
            <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                <div class="bg-blue-600 text-white px-6 py-4">
                    <h3 class="text-lg font-semibold">Jurnal Siswa: {{ $student->name }}</h3>
                </div>
                <div class="p-6">
                    @if($journals->count() > 0)
                        <div class="space-y-4">
                            @foreach($journals as $journal)
                                <div class="border border-gray-200 rounded-lg p-4 hover:shadow-md transition-shadow duration-200">
                                    <div class="flex justify-between">
                                        <div>
                                            <p class="font-medium">Hari ke-{{ $journal->day_number }}: {{ $journal->job_name }}</p>
                                            <p class="text-gray-600 text-sm">{{ $journal->date->format('d M Y') }}</p>
                                        </div>
                                        <span class="{{ $journal->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 'bg-green-100 text-green-800' }} px-3 py-1 rounded-full text-sm">
                                            {{ $journal->status === 'pending' ? 'Menunggu' : 'Disetujui' }}
                                        </span>
                                    </div>
                                    <p class="mt-2 text-gray-700">{{ $journal->activity }}</p>
                                    <div class="mt-3">
                                        <a href="{{ route('admin.jurnal.detail', $journal->id) }}" class="text-blue-600 hover:text-blue-800 text-sm font-medium">Lihat Detail</a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="mt-4">
                            {{ $journals->links() }}
                        </div>
                    @else
                        <div class="text-center py-8">
                            <div class="mb-4">
                                <i class="fas fa-book-open text-gray-400 text-5xl"></i>
                            </div>
                            <p class="text-gray-500 text-lg">
                                {{ $student->name }} belum membuat jurnal
                            </p>
                            <p class="text-gray-400 mt-2">
                                Belum ada jurnal yang dicatat untuk siswa ini
                            </p>
                        </div>
                    @endif
                </div>
            </div>
        </main>
    </div>
</x-layout>