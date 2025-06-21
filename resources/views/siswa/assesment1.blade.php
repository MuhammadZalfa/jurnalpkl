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
                        <h1 class="text-xl font-semibold">Assesmen Bulanan 1</h1>
                        <p class="text-blue-100">Batas waktu pengisian: {{ \Carbon\Carbon::parse($assessment->due_date)->format('d F Y') }}</p>
                    </div>
                    
                    <div class="p-6">
                        <div class="space-y-8">
                            <!-- Assessment Table -->
                            <div class="overflow-x-auto">
                                <table class="w-full border-collapse">
                                    <thead>
                                        <tr class="bg-gray-100">
                                            <th class="border p-2 text-left w-1/5">Element</th>
                                            <th class="border p-2 text-left w-2/5">Tujuan Pembelajaran/Indikator</th>
                                            <th class="border p-2 text-center w-1/10">Kurang</th>
                                            <th class="border p-2 text-center w-1/10">Cukup</th>
                                            <th class="border p-2 text-center w-1/10">Baik</th>
                                            <th class="border p-2 text-left w-1/5">Deskripsi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <!-- Section 1 - Soft Skills -->
                                        <tr>
                                            <td class="border p-2 font-medium" rowspan="11">Menerapkan soft skills yang dibutuhkan dalam dunia kerja (tempat PKL)</td>
                                        </tr>
                                        @foreach($softSkills as $skill => $value)
                                        <tr>
                                            <td class="border p-2">{{ $skill }}</td>
                                            <td class="border p-2 text-center">
                                                @if($value['value'] === 'Kurang')
                                                    <i class="fas fa-check text-green-500"></i>
                                                @endif
                                            </td>
                                            <td class="border p-2 text-center">
                                                @if($value['value'] === 'Cukup')
                                                    <i class="fas fa-check text-green-500"></i>
                                                @endif
                                            </td>
                                            <td class="border p-2 text-center">
                                                @if($value['value'] === 'Baik')
                                                    <i class="fas fa-check text-green-500"></i>
                                                @endif
                                            </td>
                                            <td class="border p-2">{{ $value['description'] ?? '-' }}</td>
                                        </tr>
                                        @endforeach

                                        <!-- Section 2 - Hard Skills -->
                                        <tr>
                                            <td class="border p-2 font-medium" rowspan="5">Penerapan dan pengembangan hardskill</td>
                                        </tr>
                                        @foreach($hardSkills as $skill => $value)
                                        <tr>
                                            <td class="border p-2">{{ $skill }}</td>
                                            <td class="border p-2 text-center">
                                                @if($value['value'] === 'Kurang')
                                                    <i class="fas fa-check text-green-500"></i>
                                                @endif
                                            </td>
                                            <td class="border p-2 text-center">
                                                @if($value['value'] === 'Cukup')
                                                    <i class="fas fa-check text-green-500"></i>
                                                @endif
                                            </td>
                                            <td class="border p-2 text-center">
                                                @if($value['value'] === 'Baik')
                                                    <i class="fas fa-check text-green-500"></i>
                                                @endif
                                            </td>
                                            <td class="border p-2">{{ $value['description'] ?? '-' }}</td>
                                        </tr>
                                        @endforeach

                                        <!-- Section 3 - Entrepreneurship -->
                                        <tr>
                                            <td class="border p-2 font-medium" rowspan="5">Penyiapan kemandirian berwirausaha<br>Kemampuan dalam menyelesaikan project</td>
                                        </tr>
                                        @foreach($entrepreneurship as $skill => $value)
                                        <tr>
                                            <td class="border p-2">{{ $skill }}</td>
                                            <td class="border p-2 text-center">
                                                @if($value['value'] === 'Kurang')
                                                    <i class="fas fa-check text-green-500"></i>
                                                @endif
                                            </td>
                                            <td class="border p-2 text-center">
                                                @if($value['value'] === 'Cukup')
                                                    <i class="fas fa-check text-green-500"></i>
                                                @endif
                                            </td>
                                            <td class="border p-2 text-center">
                                                @if($value['value'] === 'Baik')
                                                    <i class="fas fa-check text-green-500"></i>
                                                @endif
                                            </td>
                                            <td class="border p-2">{{ $value['description'] ?? '-' }}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            
                            <!-- Comments Section -->
                            <div class="mt-8">
                                <h2 class="text-lg font-semibold text-gray-800 mb-4">Komentar/Kesimpulan Instruktur DUDI/Pembimbing DUDI</h2>
                                <div class="bg-gray-50 p-4 rounded-md border border-gray-200">
                                    {{ $assessment->instructor_comments ?? 'Belum ada komentar' }}
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