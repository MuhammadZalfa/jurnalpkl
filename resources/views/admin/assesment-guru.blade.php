<x-layout title="Assesment Siswa - Admin">
    <x-sidebar-admin />
    
    <div class="flex-1 flex flex-col">
        <x-header title="Assesment Siswa" />
        
        <main class="flex-1 p-4 md:p-6">
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-xl font-semibold mb-4">Daftar Assesment Siswa Bimbingan</h2>
                
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Siswa</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">DUDI</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Assesmen 1</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Assesmen 2</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Assesmen 3</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($assessments as $studentAssessments)
                                @php
                                    $assessment = $studentAssessments->first();
                                    $student = $assessment->student;
                                @endphp
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $student->name }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $student->dudi }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if($assessment->monthly1)
                                            <div class="flex items-center gap-2">
                                                <span class="px-2 py-1 text-sm rounded-full bg-green-100 text-green-800">Selesai</span>
                                                @if($assessment->status === 'approved')
                                                    <span class="px-2 py-1 text-xs rounded-full bg-blue-100 text-blue-800">Approved</span>
                                                @else
                                                    <span class="px-2 py-1 text-xs rounded-full bg-yellow-100 text-yellow-800">Pending</span>
                                                @endif
                                            </div>
                                        @else
                                            <span class="px-2 py-1 text-sm rounded-full bg-red-100 text-red-800">Belum</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if($assessment->monthly2)
                                            <div class="flex items-center gap-2">
                                                <span class="px-2 py-1 text-sm rounded-full bg-green-100 text-green-800">Selesai</span>
                                                @if($assessment->status === 'approved')
                                                    <span class="px-2 py-1 text-xs rounded-full bg-blue-100 text-blue-800">Approved</span>
                                                @else
                                                    <span class="px-2 py-1 text-xs rounded-full bg-yellow-100 text-yellow-800">Pending</span>
                                                @endif
                                            </div>
                                        @else
                                            <span class="px-2 py-1 text-sm rounded-full bg-red-100 text-red-800">Belum</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if($assessment->monthly3)
                                            <div class="flex items-center gap-2">
                                                <span class="px-2 py-1 text-sm rounded-full bg-green-100 text-green-800">Selesai</span>
                                                @if($assessment->status === 'approved')
                                                    <span class="px-2 py-1 text-xs rounded-full bg-blue-100 text-blue-800">Approved</span>
                                                @else
                                                    <span class="px-2 py-1 text-xs rounded-full bg-yellow-100 text-yellow-800">Pending</span>
                                                @endif
                                            </div>
                                        @else
                                            <span class="px-2 py-1 text-sm rounded-full bg-red-100 text-red-800">Belum</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <a href="{{ route('admin.assesment.detail', $assessment->id) }}" class="text-blue-600 hover:text-blue-900">Detail</a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-4 text-center text-gray-500">
                                        Tidak ada data assessment
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
    </div>
</x-layout>