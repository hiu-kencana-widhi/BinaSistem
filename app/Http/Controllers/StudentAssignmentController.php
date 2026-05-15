<?php

namespace App\Http\Controllers;

use App\Models\Assignment;
use App\Models\AssignmentSubmission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use RealRashid\SweetAlert\Facades\Alert;

class StudentAssignmentController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        $assignments = Assignment::with(['subject', 'teacher'])
            ->whereIn('classroom_id', $user->classroomsAsStudent->pluck('id'))
            ->latest()
            ->get()
            ->map(function ($assignment) use ($user) {
                $assignment->submission = AssignmentSubmission::where('assignment_id', $assignment->id)
                    ->where('student_id', $user->id)
                    ->first();
                return $assignment;
            });

        return view('murid.assignments.index', compact('assignments'));
    }

    public function show(Assignment $assignment)
    {
        $user = Auth::user();

        if (!$user->classroomsAsStudent->contains('id', $assignment->classroom_id)) {
            abort(403, 'Unauthorized access.');
        }

        $submission = AssignmentSubmission::where('assignment_id', $assignment->id)
            ->where('student_id', $user->id)
            ->first();

        return view('murid.assignments.show', compact('assignment', 'submission'));
    }

    public function storeSubmission(Request $request, Assignment $assignment)
    {
        $user = Auth::user();

        // 1. Validasi Kelas
        if (!$user->classroomsAsStudent->contains('id', $assignment->classroom_id)) {
            abort(403);
        }

        // 2. Validasi Due Date
        if ($assignment->due_date && Carbon::now()->greaterThan($assignment->due_date)) {
            Alert::error('Gagal', 'Tenggat waktu pengumpulan sudah lewat.');
            return back();
        }

        $request->validate([
            'file' => 'required|file|mimes:pdf,doc,docx,zip,rar|max:20480', // 20MB
        ]);

        $path = $request->file('file')->store('submissions', 'public');

        AssignmentSubmission::updateOrCreate(
            ['assignment_id' => $assignment->id, 'student_id' => $user->id],
            [
                'file_path' => $path,
                'submitted_at' => Carbon::now()
            ]
        );

        Alert::success('Berhasil', 'Tugas berhasil dikumpulkan.');
        return back();
    }
}
