<?php

namespace App\Http\Controllers;

use App\Models\Assignment;
use App\Models\Subject;
use App\Models\Classroom;
use App\Models\AssignmentSubmission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;

class AssignmentController extends Controller
{
    public function index()
    {
        $assignments = Assignment::with(['subject', 'classroom', 'submissions'])
            ->where('teacher_id', Auth::id())
            ->latest()
            ->paginate(10);
            
        return view('guru.assignments.index', compact('assignments'));
    }

    public function create()
    {
        $subjects = Subject::all();
        $classrooms = Auth::user()->classroomsAsTeacher;
        
        return view('guru.assignments.create', compact('subjects', 'classrooms'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'subject_id' => 'required|exists:subjects,id',
            'classroom_id' => 'required|exists:classrooms,id',
            'title' => 'required|string|max:255',
            'instructions' => 'nullable|string',
            'due_date' => 'nullable|date',
            'attachment' => 'nullable|file|mimes:pdf,doc,docx,zip|max:20480', // 20MB
        ]);

        $path = null;
        if ($request->hasFile('attachment')) {
            $path = $request->file('attachment')->store('assignments', 'public');
        }

        Assignment::create([
            'teacher_id' => Auth::id(),
            'subject_id' => $request->subject_id,
            'classroom_id' => $request->classroom_id,
            'title' => $request->title,
            'instructions' => $request->instructions,
            'due_date' => $request->due_date,
            'attachment_path' => $path,
        ]);

        Alert::success('Berhasil', 'Tugas berhasil dibuat');
        return redirect()->route('guru.assignments.index');
    }

    // View submissions related to an assignment
    public function show(Assignment $assignment)
    {
        if ($assignment->teacher_id !== Auth::id()) abort(403);

        // Load submissions and related students
        $assignment->load(['submissions.student']);
        
        return view('guru.assignments.show', compact('assignment'));
    }

    // Mass Grading
    public function massGrade(Request $request, Assignment $assignment)
    {
        if ($assignment->teacher_id !== Auth::id()) abort(403);

        $request->validate([
            'scores' => 'required|array',
            'scores.*' => 'nullable|numeric|min:0|max:100',
        ]);

        foreach ($request->scores as $submissionId => $score) {
            if ($score !== null) {
                AssignmentSubmission::where('id', $submissionId)
                    ->where('assignment_id', $assignment->id)
                    ->update(['score' => $score]);
            }
        }

        Alert::success('Berhasil', 'Nilai berhasil disimpan');
        return back();
    }
}
