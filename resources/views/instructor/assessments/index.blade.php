<x-layout title="Daftar Assessment - Jurnal PKL">
    <x-sidebar-instructor />
    
    <div class="flex-1 flex flex-col">
        <x-header-instructor title="Daftar Assessment" />
        
        <main class="flex-1 p-4 md:p-6">
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-2xl font-bold text-gray-800">Daftar Assessment Siswa</h1>
                <div class="text-sm text-gray-600">
                    DUDI Anda: <span class="font-semibold">{{ $currentDudi }}</span>
                </div>
            </div>
            
            <!-- Assessment Period Info -->
            <div class="bg-blue-50 rounded-lg p-4 mb-6">
                <h2 class="text-lg font-semibold text-blue-800 mb-2">Periode Assessment</h2>
                <ul class="space-y-2">
                    @foreach($assessmentPeriods as $type => $period)
                    <li class="flex items-start">
                        <span class="inline-block bg-blue-100 text-blue-800 rounded-full px-3 py-1 text-sm font-medium mr-3">
                            {{ $period['name'] }}
                        </span>
                        <span class="text-gray-700">
                            {{ Carbon\Carbon::parse($period['start'])->format('d M Y') }} - 
                            {{ Carbon\Carbon::parse($period['end'])->format('d M Y') }}
                        </span>
                    </li>
                    @endforeach
                </ul>
            </div>
            
            <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <!-- Table header remains the same -->
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Siswa</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">DUDI</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Jenis</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Batas Waktu</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($assessments as $assessment)
                            <tr>
                                <!-- Student Column -->
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="text-sm font-medium text-gray-900">
                                            {{ $assessment->student->name }}
                                        </div>
                                    </div>
                                </td>
                                
                                <!-- DUDI Column -->
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">
                                        @if(in_array($assessment->student->dudi, $validDudis))
                                            {{ $assessment->student->dudi }}
                                        @else
                                            <span class="text-red-500">DUDI tidak valid</span>
                                        @endif
                                    </div>
                                </td>
                                
                                <!-- Assessment Type Column -->
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 py-1 text-xs rounded-full bg-blue-100 text-blue-800">
                                        {{ $assessmentPeriods[$assessment->type]['name'] ?? ucfirst($assessment->type) }}
                                    </span>
                                </td>
                                
                                <!-- Due Date Column -->
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">
                                        {{ $assessment->due_date->format('d M Y') }}
                                    </div>
                                    <div class="text-xs text-gray-500">
                                        @if($assessment->due_date->isPast())
                                            <span class="text-red-500">Berakhir {{ $assessment->due_date->diffForHumans() }}</span>
                                        @else
                                            Berakhir {{ $assessment->due_date->diffForHumans() }}
                                        @endif
                                    </div>
                                </td>
                                
                                <!-- Status Column -->
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($assessment->status === 'approved')
                                        <span class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-800">
                                            Disetujui
                                        </span>
                                    @elseif($assessment->status === 'rejected')
                                        <span class="px-2 py-1 text-xs rounded-full bg-red-100 text-red-800">
                                            Ditolak
                                        </span>
                                    @else
                                        @if($assessment->due_date->isPast())
                                            <span class="px-2 py-1 text-xs rounded-full bg-red-100 text-red-800">
                                                Melewati Batas
                                            </span>
                                        @else
                                            <span class="px-2 py-1 text-xs rounded-full bg-yellow-100 text-yellow-800">
                                                Menunggu
                                            </span>
                                        @endif
                                    @endif
                                </td>
                                
                                <!-- Action Column -->
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    @if($assessment->type === 'monthly1')
                                        <a href="{{ route('instructor.assessment1.show', $assessment) }}" 
                                           class="text-blue-600 hover:text-blue-900 mr-3"
                                           @if($assessment->due_date->addDays(3)->isPast()) disabled @endif>
                                            Lihat Assessment 1
                                        </a>
                                    @elseif($assessment->type === 'monthly2')
                                        <a href="{{ route('instructor.assessment2.show', $assessment) }}" 
                                           class="text-blue-600 hover:text-blue-900 mr-3"
                                           @if($assessment->due_date->addDays(3)->isPast()) disabled @endif>
                                            Lihat Assessment 2
                                        </a>
                                    @elseif($assessment->type === 'monthly3')
                                        <a href="{{ route('instructor.assessment3.show', $assessment) }}" 
                                           class="text-blue-600 hover:text-blue-900 mr-3"
                                           @if($assessment->due_date->addDays(3)->isPast()) disabled @endif>
                                            Lihat Assessment 3
                                        </a>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="px-6 py-4 text-center text-sm text-gray-500">
                                    Tidak ada data assessment
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                
                @if($assessments->hasPages())
                <div class="px-6 py-4 bg-gray-50 border-t">
                    {{ $assessments->links() }}
                </div>
                @endif
            </div>
        </main>
    </div>
</x-layout>