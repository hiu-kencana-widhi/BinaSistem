<?php

namespace App\Http\Controllers;

use App\Models\Exam;
use App\Models\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class QuestionController extends Controller
{
    public function create(Request $request)
    {
        $examId = $request->query('exam_id');
        $exam = Exam::with('questions')->findOrFail($examId);

        if ($exam->teacher_id !== Auth::id()) abort(403);

        return view('guru.questions.create', compact('exam'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'exam_id' => 'required|exists:exams,id',
            'question_text' => 'required|string',
            'option_a' => 'required|string',
            'option_b' => 'required|string',
            'option_c' => 'required|string',
            'option_d' => 'required|string',
            'correct_answer_char' => 'required|in:A,B,C,D',
        ]);

        $exam = Exam::findOrFail($request->exam_id);
        if ($exam->teacher_id !== Auth::id()) abort(403);

        Question::create([
            'exam_id' => $request->exam_id,
            'question_text' => $request->question_text,
            'option_a' => $request->option_a,
            'option_b' => $request->option_b,
            'option_c' => $request->option_c,
            'option_d' => $request->option_d,
            'correct_answer_char' => $request->correct_answer_char,
        ]);

        Alert::success('Berhasil', 'Soal berhasil ditambahkan.');
        
        // Redirect back to the same form to allow repetitive additions
        return redirect()->route('guru.questions.create', ['exam_id' => $request->exam_id]);
    }

    public function destroy(Question $question)
    {
        if ($question->exam->teacher_id !== Auth::id()) abort(403);

        $examId = $question->exam_id;
        $question->delete();

        Alert::success('Berhasil', 'Soal dihapus.');
        return redirect()->route('guru.questions.create', ['exam_id' => $examId]);
    }
}
