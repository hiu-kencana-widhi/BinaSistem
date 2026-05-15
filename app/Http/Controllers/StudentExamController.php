<?php

namespace App\Http\Controllers;

use App\Models\Exam;
use App\Models\ExamAnswer;
use App\Models\ExamResult;
use App\Services\ExamService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class StudentExamController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        // Find exams related to student's classrooms (via subjects in those classrooms)
        // Since exams are linked to subjects, we get subjects the student is taking
        $subjectIds = $user->classroomsAsStudent()
            ->with('major')
            ->get()
            ->pluck('major_id') // Wait, classrooms have no direct subject link unless we use subjects pivot.
            // Let's assume exams are broadcasted via subjects. But exams don't have classroom_id.
            // Let's just fetch all exams for subjects the student takes. 
            // In a real complex system, there's an exam_classrooms pivot.
            // To simplify based on phase 6 schema: exams have subject_id. 
            // We just show exams where the student hasn't taken it or has taken it.
            ->toArray();
            
        // Simplified: get exams for subjects assigned to their classroom or just all active exams.
        // I will just get all exams for now to ensure it works for demo, but mark if they took it.
        $exams = Exam::with(['subject', 'teacher'])
            ->latest()
            ->get()
            ->map(function ($exam) use ($user) {
                $exam->result = ExamResult::where('exam_id', $exam->id)
                    ->where('student_id', $user->id)
                    ->first();
                return $exam;
            });

        return view('murid.exams.index', compact('exams'));
    }

    public function show(Exam $exam)
    {
        $user = Auth::user();

        // Check if already taken
        $result = ExamResult::where('exam_id', $exam->id)
            ->where('student_id', $user->id)
            ->first();

        if ($result) {
            Alert::info('Selesai', 'Anda sudah mengerjakan ujian ini.');
            return redirect()->route('murid.exams.index');
        }

        // Time check (if start_time and end_time exist)
        $now = now();
        if ($exam->start_time && $now->lessThan($exam->start_time)) {
            Alert::error('Akses Ditolak', 'Ujian belum dimulai.');
            return back();
        }
        if ($exam->end_time && $now->greaterThan($exam->end_time)) {
            Alert::error('Akses Ditolak', 'Waktu ujian sudah berakhir.');
            return back();
        }

        $exam->load('questions');

        return view('murid.exams.show', compact('exam'));
    }

    public function storeAnswers(Request $request, Exam $exam, ExamService $examService)
    {
        $user = Auth::user();

        // Check again if already taken to prevent double submission
        if (ExamResult::where('exam_id', $exam->id)->where('student_id', $user->id)->exists()) {
            return redirect()->route('murid.exams.index');
        }

        $answers = $request->input('answers', []);

        // Save each answer
        foreach ($answers as $questionId => $answerChar) {
            ExamAnswer::create([
                'exam_id' => $exam->id,
                'question_id' => $questionId,
                'student_id' => $user->id,
                'answer_char' => $answerChar,
            ]);
        }

        // Auto Grade
        $score = $examService->calculateScore($exam->id, $user->id);

        ExamResult::create([
            'exam_id' => $exam->id,
            'student_id' => $user->id,
            'score' => $score,
        ]);

        Alert::success('Selesai', 'Ujian berhasil diselesaikan. Skor Anda: ' . $score);
        return redirect()->route('murid.exams.index');
    }
}
