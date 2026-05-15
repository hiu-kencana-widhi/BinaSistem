@extends('layouts.app')

@section('title', 'CBT Ujian Berlangsung')

@section('content')
<!-- Alpine component for timer -->
<div x-data="cbtTimer({{ $exam->duration_minutes }})" x-init="startTimer()" class="max-w-4xl mx-auto">
    
    <!-- Top Bar (Sticky) -->
    <div class="sticky top-0 z-50 bg-white border-b border-slate-200 shadow-sm px-6 py-4 flex justify-between items-center mb-8 rounded-b-xl">
        <div>
            <h1 class="text-xl font-bold text-slate-800">{{ $exam->title }}</h1>
            <p class="text-sm text-slate-500">{{ $exam->subject->name ?? 'Umum' }} • {{ $exam->questions->count() }} Soal</p>
        </div>
        
        <div class="flex items-center space-x-3">
            <div class="bg-slate-100 text-slate-700 px-4 py-2 rounded-lg font-mono font-bold text-xl flex items-center border border-slate-200" :class="{'text-red-600 bg-red-50 border-red-200': timeRemaining < 300}">
                <svg class="w-5 h-5 mr-2" :class="{'animate-pulse': timeRemaining < 300}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <span x-text="formatTime()"></span>
            </div>
            
            <button type="button" @click="submitExam()" class="bg-blue-600 hover:bg-blue-700 text-white font-medium px-6 py-2 rounded-lg shadow-sm transition-colors">
                Selesai Ujian
            </button>
        </div>
    </div>

    <!-- Exam Content -->
    <form id="exam-form" action="{{ route('murid.exams.store', $exam) }}" method="POST">
        @csrf
        
        <div class="space-y-8 pb-20">
            @forelse($exam->questions as $index => $question)
                <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden" id="question-{{ $question->id }}">
                    <div class="p-6">
                        <div class="flex items-start mb-6">
                            <span class="flex-shrink-0 w-8 h-8 flex items-center justify-center bg-slate-100 text-slate-700 font-bold rounded-full mr-4 border border-slate-200">
                                {{ $index + 1 }}
                            </span>
                            <div class="text-slate-800 font-medium text-lg pt-1">
                                {!! nl2br(e($question->question_text)) !!}
                            </div>
                        </div>

                        <div class="ml-12 space-y-3">
                            @foreach(['A' => $question->option_a, 'B' => $question->option_b, 'C' => $question->option_c, 'D' => $question->option_d] as $key => $option)
                                <label class="flex items-start p-3 border border-slate-200 rounded-lg cursor-pointer hover:bg-slate-50 transition-colors has-[:checked]:border-blue-500 has-[:checked]:bg-blue-50 has-[:checked]:ring-1 has-[:checked]:ring-blue-500">
                                    <input type="radio" name="answers[{{ $question->id }}]" value="{{ $key }}" class="mt-1 form-radio h-5 w-5 text-blue-600 border-slate-300 focus:ring-blue-500">
                                    <span class="ml-3 font-medium text-slate-700 w-8">{{ $key }}.</span>
                                    <span class="text-slate-700 flex-1">{{ $option }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>
                </div>
            @empty
                <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-10 text-center">
                    <p class="text-slate-500 font-medium">Ujian ini belum memiliki soal.</p>
                </div>
            @endforelse
        </div>
    </form>
</div>

<!-- Alpine Logic -->
<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('cbtTimer', (durationMinutes) => ({
            timeRemaining: durationMinutes * 60, // Convert to seconds
            interval: null,

            startTimer() {
                // Prevent going back
                history.pushState(null, null, location.href);
                window.onpopstate = function () {
                    history.go(1);
                };

                this.interval = setInterval(() => {
                    this.timeRemaining--;
                    
                    if (this.timeRemaining <= 0) {
                        clearInterval(this.interval);
                        this.forceSubmit();
                    }
                }, 1000);
            },

            formatTime() {
                const h = Math.floor(this.timeRemaining / 3600);
                const m = Math.floor((this.timeRemaining % 3600) / 60);
                const s = this.timeRemaining % 60;
                
                if (h > 0) {
                    return `${h.toString().padStart(2, '0')}:${m.toString().padStart(2, '0')}:${s.toString().padStart(2, '0')}`;
                }
                return `${m.toString().padStart(2, '0')}:${s.toString().padStart(2, '0')}`;
            },

            submitExam() {
                if (confirm('Anda yakin ingin menyelesaikan ujian sekarang? Jawaban tidak dapat diubah lagi.')) {
                    clearInterval(this.interval);
                    document.getElementById('exam-form').submit();
                }
            },

            forceSubmit() {
                alert('Waktu habis! Jawaban Anda akan dikirim secara otomatis.');
                document.getElementById('exam-form').submit();
            }
        }))
    })
</script>

<!-- Disable Right Click and Copy Paste for Security -->
<script>
    document.addEventListener('contextmenu', event => event.preventDefault());
    document.addEventListener('copy', event => {
        event.clipboardData.setData('text/plain', 'Menyontek tidak diizinkan!');
        event.preventDefault();
    });
</script>
@endsection
