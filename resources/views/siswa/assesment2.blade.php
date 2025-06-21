<x-layout title="Observasi - Jurnal PKL">
    <!-- Sidebar -->
    <x-sidebar-student />
    
    <!-- Main Content -->
    <div class="flex-1 flex flex-col">
        <x-header title="Assesment" />
        
        <!-- Content -->
        <main class="flex-1 p-4 md:p-6">
            <div class="max-w-5xl mx-auto">
                <div class="bg-white rounded-xl shadow-lg overflow-hidden mb-6">
                    <div class="bg-blue-600 text-white px-6 py-4">
                        <h1 class="text-xl font-semibold">Assesmen Bulanan 2</h1>
                        <p class="text-blue-100">Batas waktu pengisian: {{ \Carbon\Carbon::parse($assessment->due_date)->format('d F Y') }}</p>
                    </div>
                    
                    <div class="p-6">
                        <div class="space-y-8">
                            <!-- Assessment Table -->
                            <div class="overflow-x-auto">
                                <table class="w-full border-collapse">
                                    <thead>
                                        <tr class="bg-gray-100">
                                            <th class="border p-2 text-left w-1/12">Element</th>
                                            <th class="border p-2 text-left w-1/3">Capaian Perelement</th>
                                            <th class="border p-2 text-center w-1/12">Bobot</th>
                                            <th class="border p-2 text-left w-1/3">Deskripsi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <!-- Element 1: Internalisasi dan Penerapan soft skill -->
                                        <tr>
                                            <td class="border p-2 font-medium text-center" rowspan="11">1.</td>
                                            <td class="border p-2 font-bold">Internalisasi dan Penerapan soft skill</td>
                                            <td class="border p-2 text-center"></td>
                                            <td class="border p-2"></td>
                                        </tr>
                                        @foreach($softSkills as $skill => $data)
                                        <tr>
                                            <td class="border p-2">{{ $skill }}</td>
                                            <td class="border p-2 text-center font-medium">
                                                {{ $data['weight'] ?? 0 }}
                                            </td>
                                            <td class="border p-2">
                                                {{ $data['description'] ?? '-' }}
                                            </td>
                                        </tr>
                                        @endforeach
                                        
                                        <!-- Element 2: Penerapan dan pengembangan hardskill -->
                                        <tr>
                                            <td class="border p-2 font-medium text-center" rowspan="5">2.</td>
                                            <td class="border p-2 font-bold">Penerapan dan pengembangan hardskill</td>
                                            <td class="border p-2 text-center"></td>
                                            <td class="border p-2"></td>
                                        </tr>
                                        @foreach($hardSkills as $skill => $data)
                                        <tr>
                                            <td class="border p-2">{{ $skill }}</td>
                                            <td class="border p-2 text-center font-medium">
                                                {{ $data['weight'] ?? 0 }}
                                            </td>
                                            <td class="border p-2">
                                                {{ $data['description'] ?? '-' }}
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            
                            <!-- Instructor Notes -->
                            <div>
                                <h2 class="text-lg font-semibold text-gray-800 mb-4">Catatan Instruktur</h2>
                                <div class="bg-gray-50 p-4 rounded-md border border-gray-200">
                                    {{ $assessment->instructor_notes ?? 'Belum ada catatan' }}
                                </div>
                            </div>
                            
                            <!-- Back Button -->
                            <div class="flex justify-end pt-6">
                                <a href="{{ route('siswa.assesmen') }}" class="px-6 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition duration-300 flex items-center">
                                    <i class="fas fa-arrow-left mr-2"></i> Kembali
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</x-layout>