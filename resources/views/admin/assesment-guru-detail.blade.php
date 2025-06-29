<x-layout title="Detail Assesment - Admin">
    <x-sidebar-admin />
    
    <div class="flex-1 flex flex-col" x-data="assessmentTabs">
        <x-header title="Detail Assesment" :subtitle="$assessment->student->name" />
        
        <main class="flex-1 p-4 md:p-6">
            <div class="flex border-b border-gray-200 mb-6">
                <button @click="activeTab = 1" :class="{ 'border-b-2 border-blue-500 text-blue-600': activeTab === 1 }" 
                    class="px-4 py-2 font-medium text-sm focus:outline-none">
                    Assesmen Bulanan 1
                </button>
                <button @click="activeTab = 2" :class="{ 'border-b-2 border-blue-500 text-blue-600': activeTab === 2 }" 
                    class="px-4 py-2 font-medium text-sm focus:outline-none">
                    Assesmen Bulanan 2
                </button>
                <button @click="activeTab = 3" :class="{ 'border-b-2 border-blue-500 text-blue-600': activeTab === 3 }" 
                    class="px-4 py-2 font-medium text-sm focus:outline-none">
                    Assesmen Bulanan 3
                </button>
            </div>

            <div x-show="activeTab === 1" class="bg-white rounded-lg shadow p-6 mb-6">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-semibold">Assesmen Bulanan 1</h3>
                    @if($assessment->monthly1 && $assessment->monthly1->dudi_approved)
                        <span class="px-3 py-1 text-sm rounded-full bg-blue-100 text-blue-800">Approved DUDI</span>
                    @elseif($assessment->monthly1)
                        <span class="px-3 py-1 text-sm rounded-full bg-yellow-100 text-yellow-800">Pending DUDI Approval</span>
                    @endif
                </div>
                
                @if($assessment->monthly1)
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <h4 class="font-medium text-gray-700 mb-3 border-b pb-2">Soft Skills</h4>
                            <div class="space-y-4">
                                <div>
                                    <p class="font-medium">Kehadiran:</p>
                                    <p>{{ $assessment->monthly1->attendance }} - {{ $assessment->monthly1->attendance_desc }}</p>
                                </div>
                                <div>
                                    <p class="font-medium">Penampilan:</p>
                                    <p>{{ $assessment->monthly1->appearance }} - {{ $assessment->monthly1->appearance_desc }}</p>
                                </div>
                                <div>
                                    <p class="font-medium">Komitmen:</p>
                                    <p>{{ $assessment->monthly1->commitment }} - {{ $assessment->monthly1->commitment_desc }}</p>
                                </div>
                                <div>
                                    <p class="font-medium">Sopan Santun:</p>
                                    <p>{{ $assessment->monthly1->politeness }} - {{ $assessment->monthly1->politeness_desc }}</p>
                                </div>
                                <div>
                                    <p class="font-medium">Inisiatif:</p>
                                    <p>{{ $assessment->monthly1->initiative }} - {{ $assessment->monthly1->initiative_desc }}</p>
                                </div>
                                <div>
                                    <p class="font-medium">Kerja Sama:</p>
                                    <p>{{ $assessment->monthly1->teamwork }} - {{ $assessment->monthly1->teamwork_desc }}</p>
                                </div>
                                <div>
                                    <p class="font-medium">Disiplin:</p>
                                    <p>{{ $assessment->monthly1->discipline }} - {{ $assessment->monthly1->discipline_desc }}</p>
                                </div>
                                <div>
                                    <p class="font-medium">Komunikasi:</p>
                                    <p>{{ $assessment->monthly1->communication }} - {{ $assessment->monthly1->communication_desc }}</p>
                                </div>
                                <div>
                                    <p class="font-medium">Kepedulian Sosial:</p>
                                    <p>{{ $assessment->monthly1->social_care }} - {{ $assessment->monthly1->social_care_desc }}</p>
                                </div>
                                <div>
                                    <p class="font-medium">K3LH:</p>
                                    <p>{{ $assessment->monthly1->k3lh }} - {{ $assessment->monthly1->k3lh_desc }}</p>
                                </div>
                            </div>
                        </div>
                        
                        <div>
                            <h4 class="font-medium text-gray-700 mb-3 border-b pb-2">Hard Skills</h4>
                            <div class="space-y-4">
                                <div>
                                    <p class="font-medium">Keahlian:</p>
                                    <p>{{ $assessment->monthly1->expertise }} - {{ $assessment->monthly1->expertise_desc }}</p>
                                </div>
                                <div>
                                    <p class="font-medium">Inovasi:</p>
                                    <p>{{ $assessment->monthly1->innovation }} - {{ $assessment->monthly1->innovation_desc }}</p>
                                </div>
                                <div>
                                    <p class="font-medium">Produktivitas:</p>
                                    <p>{{ $assessment->monthly1->productivity }} - {{ $assessment->monthly1->productivity_desc }}</p>
                                </div>
                                <div>
                                    <p class="font-medium">Penguasaan Alat:</p>
                                    <p>{{ $assessment->monthly1->tool_mastery }} - {{ $assessment->monthly1->tool_mastery_desc }}</p>
                                </div>
                            </div>
                            
                            <div class="mt-6">
                                <h4 class="font-medium text-gray-700 mb-3 border-b pb-2">Nilai</h4>
                                <div class="space-y-2">
                                    <div class="flex justify-between">
                                        <span>Soft Skills:</span>
                                        <span class="font-medium">{{ $assessment->monthly1->soft_skills_score }}</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span>Hard Skills:</span>
                                        <span class="font-medium">{{ $assessment->monthly1->hard_skills_score }}</span>
                                    </div>
                                    <div class="flex justify-between border-t pt-2">
                                        <span class="font-medium">Nilai Akhir:</span>
                                        <span class="font-bold">{{ $assessment->monthly1->final_score }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="md:col-span-2">
                            <h4 class="font-medium text-gray-700 mb-3 border-b pb-2">Feedback</h4>
                            <div class="space-y-4">
                                @if($assessment->monthly1->dudi_comments)
                                <div>
                                    <p class="font-medium">Komentar DUDI:</p>
                                    <p class="bg-gray-50 p-3 rounded">{{ $assessment->monthly1->dudi_comments }}</p>
                                </div>
                                @endif
                                
                                <div>
                                    <p class="font-medium">Komentar Pembimbing:</p>
                                    <form id="commentForm1" action="{{ route('admin.assessment.comment', ['assessment' => $assessment->id, 'type' => 'monthly1']) }}" method="POST">
                                        @csrf
                                        <textarea name="pembimbing_comments" rows="3" 
                                            class="w-full border rounded-md p-2" 
                                            placeholder="Masukkan komentar pembimbing...">{{ old('pembimbing_comments', $assessment->monthly1->pembimbing_comments) }}</textarea>
                                        <div class="flex justify-end mt-2 space-x-2">
                                            @if($assessment->monthly1->pembimbing_comments)
                                            <button type="button" onclick="deleteComment('commentForm1')" 
                                                class="px-4 py-2 bg-red-100 text-red-700 rounded-md hover:bg-red-200">
                                                Hapus Komentar
                                            </button>
                                            @endif
                                            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                                                {{ $assessment->monthly1->pembimbing_comments ? 'Update Komentar' : 'Simpan Komentar' }}
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @else
                    <p class="text-gray-500">Belum dikerjakan</p>
                @endif
            </div>
            
            <div x-show="activeTab === 2" class="bg-white rounded-lg shadow p-6 mb-6">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-semibold">Assesmen Bulanan 2</h3>
                    @if($assessment->monthly2 && $assessment->monthly2->dudi_approved)
                        <span class="px-3 py-1 text-sm rounded-full bg-blue-100 text-blue-800">Approved DUDI</span>
                    @elseif($assessment->monthly2)
                        <span class="px-3 py-1 text-sm rounded-full bg-yellow-100 text-yellow-800">Pending DUDI Approval</span>
                    @endif
                </div>
                
                @if($assessment->monthly2)
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <h4 class="font-medium text-gray-700 mb-3 border-b pb-2">Soft Skills</h4>
                            <div class="space-y-4">
                                <div>
                                    <p class="font-medium">Kehadiran:</p>
                                    <p>{{ $assessment->monthly2->attendance }} - {{ $assessment->monthly2->attendance_desc }}</p>
                                </div>
                                <div>
                                    <p class="font-medium">Penampilan:</p>
                                    <p>{{ $assessment->monthly2->appearance }} - {{ $assessment->monthly2->appearance_desc }}</p>
                                </div>
                                <div>
                                    <p class="font-medium">Komitmen:</p>
                                    <p>{{ $assessment->monthly2->commitment }} - {{ $assessment->monthly2->commitment_desc }}</p>
                                </div>
                                <div>
                                    <p class="font-medium">Sopan Santun:</p>
                                    <p>{{ $assessment->monthly2->manners }} - {{ $assessment->monthly2->manners_desc }}</p>
                                </div>
                                <div>
                                    <p class="font-medium">Inisiatif:</p>
                                    <p>{{ $assessment->monthly2->initiative }} - {{ $assessment->monthly2->initiative_desc }}</p>
                                </div>
                                <div>
                                    <p class="font-medium">Kerja Sama:</p>
                                    <p>{{ $assessment->monthly2->teamwork }} - {{ $assessment->monthly2->teamwork_desc }}</p>
                                </div>
                                <div>
                                    <p class="font-medium">Disiplin:</p>
                                    <p>{{ $assessment->monthly2->discipline }} - {{ $assessment->monthly2->discipline_desc }}</p>
                                </div>
                                <div>
                                    <p class="font-medium">Komunikasi:</p>
                                    <p>{{ $assessment->monthly2->communication }} - {{ $assessment->monthly2->communication_desc }}</p>
                                </div>
                                <div>
                                    <p class="font-medium">Kepedulian Sosial:</p>
                                    <p>{{ $assessment->monthly2->social_care }} - {{ $assessment->monthly2->social_care_desc }}</p>
                                </div>
                                <div>
                                    <p class="font-medium">K3LH:</p>
                                    <p>{{ $assessment->monthly2->k3lh }} - {{ $assessment->monthly2->k3lh_desc }}</p>
                                </div>
                            </div>
                        </div>
                        
                        <div>
                            <h4 class="font-medium text-gray-700 mb-3 border-b pb-2">Hard Skills</h4>
                            <div class="space-y-4">
                                <div>
                                    <p class="font-medium">Keahlian:</p>
                                    <p>{{ $assessment->monthly2->expertise }} - {{ $assessment->monthly2->expertise_desc }}</p>
                                </div>
                                <div>
                                    <p class="font-medium">Inovasi:</p>
                                    <p>{{ $assessment->monthly2->innovation }} - {{ $assessment->monthly2->innovation_desc }}</p>
                                </div>
                                <div>
                                    <p class="font-medium">Produktivitas:</p>
                                    <p>{{ $assessment->monthly2->productivity }} - {{ $assessment->monthly2->productivity_desc }}</p>
                                </div>
                                <div>
                                    <p class="font-medium">Penguasaan Alat:</p>
                                    <p>{{ $assessment->monthly2->tool_mastery }} - {{ $assessment->monthly2->tool_mastery_desc }}</p>
                                </div>
                            </div>
                            
                            <div class="mt-6">
                                <h4 class="font-medium text-gray-700 mb-3 border-b pb-2">Nilai</h4>
                                <div class="space-y-2">
                                    <div class="flex justify-between">
                                        <span>Soft Skills:</span>
                                        <span class="font-medium">{{ $assessment->monthly2->soft_skills_score }}</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span>Hard Skills:</span>
                                        <span class="font-medium">{{ $assessment->monthly2->hard_skills_score }}</span>
                                    </div>
                                    <div class="flex justify-between border-t pt-2">
                                        <span class="font-medium">Nilai Akhir:</span>
                                        <span class="font-bold">{{ $assessment->monthly2->final_score }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="md:col-span-2">
                            <h4 class="font-medium text-gray-700 mb-3 border-b pb-2">Feedback</h4>
                            <div class="space-y-4">
                                @if($assessment->monthly2->dudi_comments)
                                <div>
                                    <p class="font-medium">Komentar DUDI:</p>
                                    <p class="bg-gray-50 p-3 rounded">{{ $assessment->monthly2->dudi_comments }}</p>
                                </div>
                                @endif
                                
                                <div>
                                    <p class="font-medium">Komentar Pembimbing:</p>
                                    <form id="commentForm2" action="{{ route('admin.assessment.comment', ['assessment' => $assessment->id, 'type' => 'monthly2']) }}" method="POST">
                                        @csrf
                                        <textarea name="pembimbing_comments" rows="3" 
                                            class="w-full border rounded-md p-2" 
                                            placeholder="Masukkan komentar pembimbing...">{{ old('pembimbing_comments', $assessment->monthly2->pembimbing_comments) }}</textarea>
                                        <div class="flex justify-end mt-2 space-x-2">
                                            @if($assessment->monthly2->pembimbing_comments)
                                            <button type="button" onclick="deleteComment('commentForm2')" 
                                                class="px-4 py-2 bg-red-100 text-red-700 rounded-md hover:bg-red-200">
                                                Hapus Komentar
                                            </button>
                                            @endif
                                            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                                                {{ $assessment->monthly2->pembimbing_comments ? 'Update Komentar' : 'Simpan Komentar' }}
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @else
                    <p class="text-gray-500">Belum dikerjakan</p>
                @endif
            </div>
            
            <div x-show="activeTab === 3" class="bg-white rounded-lg shadow p-6 mb-6">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-semibold">Assesmen Bulanan 3</h3>
                    @if($assessment->monthly3 && $assessment->monthly3->dudi_approved)
                        <span class="px-3 py-1 text-sm rounded-full bg-blue-100 text-blue-800">Approved DUDI</span>
                    @elseif($assessment->monthly3)
                        <span class="px-3 py-1 text-sm rounded-full bg-yellow-100 text-yellow-800">Pending DUDI Approval</span>
                    @endif
                </div>
                
                @if($assessment->monthly3)
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <h4 class="font-medium text-gray-700 mb-3 border-b pb-2">Soft Skills</h4>
                            <div class="space-y-4">
                                <div>
                                    <p class="font-medium">Kehadiran:</p>
                                    <p>{{ $assessment->monthly3->attendance }} - {{ $assessment->monthly3->attendance_desc }}</p>
                                </div>
                                <div>
                                    <p class="font-medium">Penampilan:</p>
                                    <p>{{ $assessment->monthly3->appearance }} - {{ $assessment->monthly3->appearance_desc }}</p>
                                </div>
                                <div>
                                    <p class="font-medium">Komitmen:</p>
                                    <p>{{ $assessment->monthly3->commitment }} - {{ $assessment->monthly3->commitment_desc }}</p>
                                </div>
                                <div>
                                    <p class="font-medium">Sopan Santun:</p>
                                    <p>{{ $assessment->monthly3->manners }} - {{ $assessment->monthly3->manners_desc }}</p>
                                </div>
                                <div>
                                    <p class="font-medium">Inisiatif:</p>
                                    <p>{{ $assessment->monthly3->initiative }} - {{ $assessment->monthly3->initiative_desc }}</p>
                                </div>
                                <div>
                                    <p class="font-medium">Kerja Sama:</p>
                                    <p>{{ $assessment->monthly3->teamwork }} - {{ $assessment->monthly3->teamwork_desc }}</p>
                                </div>
                                <div>
                                    <p class="font-medium">Disiplin:</p>
                                    <p>{{ $assessment->monthly3->discipline }} - {{ $assessment->monthly3->discipline_desc }}</p>
                                </div>
                                <div>
                                    <p class="font-medium">Komunikasi:</p>
                                    <p>{{ $assessment->monthly3->communication }} - {{ $assessment->monthly3->communication_desc }}</p>
                                </div>
                                <div>
                                    <p class="font-medium">Kepedulian Sosial:</p>
                                    <p>{{ $assessment->monthly3->social_care }} - {{ $assessment->monthly3->social_care_desc }}</p>
                                </div>
                                <div>
                                    <p class="font-medium">K3LH:</p>
                                    <p>{{ $assessment->monthly3->k3lh }} - {{ $assessment->monthly3->k3lh_desc }}</p>
                                </div>
                            </div>
                        </div>
                        
                        <div>
                            <h4 class="font-medium text-gray-700 mb-3 border-b pb-2">Hard Skills</h4>
                            <div class="space-y-4">
                                <div>
                                    <p class="font-medium">Keahlian:</p>
                                    <p>{{ $assessment->monthly3->expertise }} - {{ $assessment->monthly3->expertise_desc }}</p>
                                </div>
                                <div>
                                    <p class="font-medium">Inovasi:</p>
                                    <p>{{ $assessment->monthly3->innovation }} - {{ $assessment->monthly3->innovation_desc }}</p>
                                </div>
                                <div>
                                    <p class="font-medium">Produktivitas:</p>
                                    <p>{{ $assessment->monthly3->productivity }} - {{ $assessment->monthly3->productivity_desc }}</p>
                                </div>
                                <div>
                                    <p class="font-medium">Penguasaan Alat:</p>
                                    <p>{{ $assessment->monthly3->tool_mastery }} - {{ $assessment->monthly3->tool_mastery_desc }}</p>
                                </div>
                            </div>
                            
                            <div class="mt-6">
                                <h4 class="font-medium text-gray-700 mb-3 border-b pb-2">Nilai</h4>
                                <div class="space-y-2">
                                    <div class="flex justify-between">
                                        <span>Soft Skills:</span>
                                        <span class="font-medium">{{ $assessment->monthly3->soft_skills_score }}</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span>Hard Skills:</span>
                                        <span class="font-medium">{{ $assessment->monthly3->hard_skills_score }}</span>
                                    </div>
                                    <div class="flex justify-between border-t pt-2">
                                        <span class="font-medium">Nilai Akhir:</span>
                                        <span class="font-bold">{{ $assessment->monthly3->final_score }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="md:col-span-2">
                            <h4 class="font-medium text-gray-700 mb-3 border-b pb-2">Feedback</h4>
                            <div class="space-y-4">
                                @if($assessment->monthly3->dudi_comments)
                                <div>
                                    <p class="font-medium">Komentar DUDI:</p>
                                    <p class="bg-gray-50 p-3 rounded">{{ $assessment->monthly3->dudi_comments }}</p>
                                </div>
                                @endif
                                
                                <div>
                                    <p class="font-medium">Komentar Pembimbing:</p>
                                    <form id="commentForm3" action="{{ route('admin.assessment.comment', ['assessment' => $assessment->id, 'type' => 'monthly3']) }}" method="POST">
                                        @csrf
                                        <textarea name="pembimbing_comments" rows="3" 
                                            class="w-full border rounded-md p-2" 
                                            placeholder="Masukkan komentar pembimbing...">{{ old('pembimbing_comments', $assessment->monthly3->pembimbing_comments) }}</textarea>
                                        <div class="flex justify-end mt-2 space-x-2">
                                            @if($assessment->monthly3->pembimbing_comments)
                                            <button type="button" onclick="deleteComment('commentForm3')" 
                                                class="px-4 py-2 bg-red-100 text-red-700 rounded-md hover:bg-red-200">
                                                Hapus Komentar
                                            </button>
                                            @endif
                                            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                                                {{ $assessment->monthly3->pembimbing_comments ? 'Update Komentar' : 'Simpan Komentar' }}
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @else
                    <p class="text-gray-500">Belum dikerjakan</p>
                @endif
            </div>
            
            <div class="flex justify-end">
                <a href="{{ route('admin.assesment') }}" class="px-4 py-2 bg-gray-200 text-gray-700 rounded hover:bg-gray-300">
                    Kembali ke Daftar
                </a>
            </div>
        </main>
    </div>

<script>
    function deleteComment(formId) {
        if (confirm('Apakah Anda yakin ingin menghapus komentar ini?')) {
            const form = document.getElementById(formId);
            const textarea = form.querySelector('textarea[name="pembimbing_comments"]');
            textarea.value = '';
            form.submit();
        }
    }
</script>


    <!-- Add Alpine.js for tab functionality -->
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('assessmentTabs', () => ({
                activeTab: 1,
                init() {
                    // Check URL hash for tab selection
                    const hash = window.location.hash;
                    if (hash === '#monthly2') {
                        this.activeTab = 2;
                    } else if (hash === '#monthly3') {
                        this.activeTab = 3;
                    }
                }
            }));
        });
    </script>
</x-layout>