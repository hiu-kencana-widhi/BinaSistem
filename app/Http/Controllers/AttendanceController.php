<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Classroom;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use RealRashid\SweetAlert\Facades\Alert;

class AttendanceController extends Controller
{
    public function index(Request $request)
    {
        // Get classrooms the teacher is teaching or as wali_kelas
        $classrooms = Auth::user()->classroomsAsTeacher;
        
        $selectedClassroom = null;
        $students = collect();
        $date = $request->get('date', date('Y-m-d'));
        $attendances = [];

        if ($request->has('classroom_id')) {
            $selectedClassroom = Classroom::with('students')->findOrFail($request->classroom_id);
            $students = $selectedClassroom->students;
            
            // Get existing attendances for the date
            $attendances = Attendance::where('classroom_id', $selectedClassroom->id)
                ->where('date', $date)
                ->get()
                ->keyBy('student_id');
        }

        return view('guru.attendances.index', compact('classrooms', 'selectedClassroom', 'students', 'date', 'attendances'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'classroom_id' => 'required|exists:classrooms,id',
            'date' => 'required|date',
            'status' => 'required|array',
            'status.*' => 'in:H,S,I,A'
        ]);

        $classroomId = $request->classroom_id;
        $date = $request->date;

        foreach ($request->status as $studentId => $status) {
            Attendance::updateOrCreate(
                [
                    'student_id' => $studentId,
                    'classroom_id' => $classroomId,
                    'date' => $date,
                ],
                [
                    'status' => $status
                ]
            );
        }

        Alert::success('Berhasil', 'Data absensi berhasil disimpan.');
        return back();
    }
}
