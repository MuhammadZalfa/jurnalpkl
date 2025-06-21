<x-layout title="Assesment Siswa - Admin">
    <!-- Sidebar -->
    <x-sidebar-admin />
    
    <div class="flex-1 flex flex-col">
        <x-header title="Assesment Siswa" />
        
        <main class="flex-1 p-4 md:p-6">
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-xl font-semibold mb-4">Daftar Assesment Siswa</h2>
                
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Siswa</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Assesmen 1</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Assesmen 2</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Assesmen 3</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($assessments as $assessment)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $assessment->student->name }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($assessment->monthly1)
                                        <span class="px-2 py-1 text-sm rounded-full bg-green-100 text-green-800">Selesai</span>
                                    @else
                                        <span class="px-2 py-1 text-sm rounded-full bg-red-100 text-red-800">Belum</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($assessment->monthly2)
                                        <span class="px-2 py-1 text-sm rounded-full bg-green-100 text-green-800">Selesai</span>
                                    @else
                                        <span class="px-2 py-1 text-sm rounded-full bg-red-100 text-red-800">Belum</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($assessment->monthly3)
                                        <span class="px-2 py-1 text-sm rounded-full bg-green-100 text-green-800">Selesai</span>
                                    @else
                                        <span class="px-2 py-1 text-sm rounded-full bg-red-100 text-red-800">Belum</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <a href="{{ route('admin.assesment.detail', $assessment->id) }}" class="text-blue-600 hover:text-blue-900">Detail</a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
    </div>
</x-layout>