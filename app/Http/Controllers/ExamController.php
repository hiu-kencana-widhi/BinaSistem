<?php

namespace App\Http\Controllers;

use App\Models\Exam;
use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class ExamController extends Controller
{
    public function index()
    {
        $exams = Exam::with(['subject'])
            ->where('teacher_id', Auth::id())
            ->latest()
            ->paginate(10);
            
        return view('guru.exams.index', compact('exams'));
    }

    public function create()
    {
        $subjects = Subject::all();
        return view('guru.exams.create', compact('subjects'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'subject_id' => 'required|exists:subjects,id',
            'duration_minutes' => 'required|integer|min:1',
            'start_time' => 'nullable|date',
            'end_time' => 'nullable|date|after_or_equal:start_time',
        ]);

        $exam = Exam::create([
            'title' => $request->title,
            'duration_minutes' => $request->duration_minutes,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'subject_id' => $request->subject_id,
            'teacher_id' => Auth::id(),
        ]);

        Alert::success('Berhasil', 'Ujian berhasil dibuat. Silakan tambahkan soal.');
        return redirect()->route('guru.questions.create', ['exam_id' => $exam->id]);
    }

    public function show(Exam $exam)
    {
        if ($exam->teacher_id !== Auth::id()) abort(403);
        $exam->load('questions');
        return view('guru.exams.show', compact('exam'));
    }
}
