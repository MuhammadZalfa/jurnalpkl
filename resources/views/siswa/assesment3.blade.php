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
                        <h1 class="text-xl font-semibold">Assesmen Bulanan 3</h1>
                        <p class="text-blue-100">Batas waktu pengisian: {{ \Carbon\Carbon::parse($assessment->due_date)->format('d F Y') }}</p>
                    </div>
                    
                    <div class="p-6">
                        <div class="space-y-8">
                            <!-- Assessment Table -->
                            <div class="overflow-x-auto">
                                <table class="w-full border-collapse">
                                    <thead>
                                        <tr class="bg-gray-100">
                                            <th class="border p-2 text-left">Element</th>
                                            <th class="border p-2 text-left">Capaian Perelement</th>
                                            <th class="border p-2 text-center">Skor</th>
                                            <th class="border p-2 text-left">Deskripsi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <!-- Section 1 -->
                                        <tr>
                                            <td class="border p-2 font-medium text-center">1.</td>
                                            <td class="border p-2 font-medium">Internalisasi dan Penerapakan soft skill</td>
                                            <td class="border p-2"></td>
                                            <td class="border p-2"></td>
                                        </tr>
                                        @foreach($softSkills as $skill => $data)
                                        <tr>
                                            <td class="border p-2"></td>
                                            <td class="border p-2">{{ $skill }}</td>
                                            <td class="border p-2 text-center font-medium">
                                                {{ $data['score'] ?? 0 }}
                                            </td>
                                            <td class="border p-2">
                                                {{ $data['description'] ?? '-' }}
                                            </td>
                                        </tr>
                                        @endforeach
                                        
                                        <!-- Section 2 -->
                                        <tr>
                                            <td class="border p-2 font-medium text-center">2.</td>
                                            <td class="border p-2 font-medium">Penerapan dan pengembangan hardskill</td>
                                            <td class="border p-2"></td>
                                            <td class="border p-2"></td>
                                        </tr>
                                        @foreach($hardSkills as $skill => $data)
                                        <tr>
                                            <td class="border p-2"></td>
                                            <td class="border p-2">{{ $skill }}</td>
                                            <td class="border p-2 text-center font-medium">
                                                {{ $data['score'] ?? 0 }}
                                            </td>
                                            <td class="border p-2">
                                                {{ $data['description'] ?? '-' }}
                                            </td>
                                        </tr>
                                        @endforeach
                                        
                                        <!-- Section 3 -->
                                        <tr>
                                            <td class="border p-2 font-medium text-center">3.</td>
                                            <td class="border p-2 font-medium">Penyiapan kemandirian berwirausaha</td>
                                            <td class="border p-2"></td>
                                            <td class="border p-2"></td>
                                        </tr>
                                        @foreach($entrepreneurship as $skill => $data)
                                        <tr>
                                            <td class="border p-2"></td>
                                            <td class="border p-2">{{ $skill }}</td>
                                            <td class="border p-2 text-center font-medium">
                                                {{ $data['score'] ?? 0 }}
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