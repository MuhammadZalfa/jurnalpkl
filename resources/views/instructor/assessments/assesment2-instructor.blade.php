<x-layout title="Penilaian Bulanan 2 - Instructor">
    <x-sidebar-instructor />
    
    <div class="flex-1 flex flex-col">
        <x-header-instructor title="Penilaian Bulanan 2" />
        
        <main class="flex-1 p-4 md:p-6">
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-2xl font-bold text-gray-800">Penilaian Siswa: {{ $assessment->student->name }}</h1>
                <div class="text-sm text-gray-600">
                    DUDI: {{ $assessment->dudi_name }} | 
                    Batas: {{ $assessment->due_date->format('d M Y') }}
                </div>
            </div>
            
            <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                <form action="{{ route('instructor.assessment2.update', $assessment->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Element</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Indikator</th>
                                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Bobot</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Deskripsi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                <!-- Soft Skills -->
                                <tr>
                                    <td class="px-6 py-4 font-medium text-center">1</td>
                                    <td class="px-6 py-4 font-medium">Soft Skills</td>
                                    <td class="px-6 py-4"></td>
                                    <td class="px-6 py-4"></td>
                                </tr>
                                @foreach($softSkills as $skill => $field)
                                <tr>
                                    <td class="px-6 py-4"></td>
                                    <td class="px-6 py-4">{{ $skill }}</td>
                                    <td class="px-6 py-4 text-center">
                                        <input type="number" name="{{ $field }}_weight" min="0" max="100" 
                                            class="w-20 border rounded px-2 py-1 text-center"
                                            value="{{ $assessment->monthly2->{$field.'_weight'} ?? 0 }}">
                                    </td>
                                    <td class="px-6 py-4">
                                        <input type="text" name="{{ $field }}_desc" class="w-full border rounded px-2 py-1" 
                                            value="{{ $assessment->monthly2->{$field.'_desc'} ?? '' }}">
                                    </td>
                                </tr>
                                @endforeach

                                <!-- Hard Skills -->
                                <tr>
                                    <td class="px-6 py-4 font-medium text-center">2</td>
                                    <td class="px-6 py-4 font-medium">Hard Skills</td>
                                    <td class="px-6 py-4"></td>
                                    <td class="px-6 py-4"></td>
                                </tr>
                                @foreach($hardSkills as $skill => $field)
                                <tr>
                                    <td class="px-6 py-4"></td>
                                    <td class="px-6 py-4">{{ $skill }}</td>
                                    <td class="px-6 py-4 text-center">
                                        <input type="number" name="{{ $field }}_weight" min="0" max="100" 
                                            class="w-20 border rounded px-2 py-1 text-center"
                                            value="{{ $assessment->monthly2->{$field.'_weight'} ?? 0 }}">
                                    </td>
                                    <td class="px-6 py-4">
                                        <input type="text" name="{{ $field }}_desc" class="w-full border rounded px-2 py-1" 
                                            value="{{ $assessment->monthly2->{$field.'_desc'} ?? '' }}">
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    
                    <!-- Feedback Section -->
                    <div class="p-6 border-t">
                        <h2 class="text-lg font-semibold text-gray-800 mb-4">Feedback</h2>
                        <textarea name="dudi_comments" rows="3" class="w-full border rounded-md p-2" 
                            placeholder="Masukkan komentar untuk siswa...">{{ old('dudi_comments', $assessment->monthly2->dudi_comments ?? '') }}</textarea>
                        
                        <div class="mt-4 flex items-center">
                            <input type="hidden" name="dudi_approved" value="0">
                            <input type="checkbox" name="dudi_approved" id="dudi_approved" 
                                value="1" {{ (old('dudi_approved', $assessment->monthly2->dudi_approved ?? false)) ? 'checked' : '' }}
                                class="h-5 w-5 text-blue-600 rounded border-gray-300 focus:ring-blue-500">
                            <label for="dudi_approved" class="ml-2 block text-sm text-gray-900">
                                Setujui penilaian ini
                            </label>
                        </div>
                    </div>
                    
                    <!-- Action Buttons -->
                    <div class="px-6 py-4 bg-gray-50 flex justify-end space-x-4">
                        <a href="{{ route('instructor.assessments.index') }}" class="px-4 py-2 border rounded-md">
                            Kembali
                        </a>
                        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                            Simpan Penilaian
                        </button>
                    </div>
                </form>
            </div>
        </main>
    </div>
</x-layout>