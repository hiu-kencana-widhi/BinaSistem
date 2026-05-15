<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Subject;
use App\Models\Attendance;
use App\Models\AcademicYear;
use App\Services\GradeService;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class ReportController extends Controller
{
    public function downloadRaport(Request $request, $studentId)
    {
        $student = User::with('classroomsAsStudent.major')->findOrFail($studentId);
        
        // Asumsi mengambil tahun ajaran aktif pertama atau dari request
        $academicYear = AcademicYear::where('is_active', true)->first();
        if (!$academicYear) {
            return back()->with('error', 'Tidak ada tahun ajaran aktif.');
        }

        $classroom = $student->classroomsAsStudent->first();
        if (!$classroom) {
            return back()->with('error', 'Murid belum dimasukkan ke kelas manapun.');
        }

        // Get subjects for the student (all subjects for simplicity or filter by major)
        $subjects = Subject::all();
        
        $gradeService = new GradeService();
        $reportData = [];
        $totalScore = 0;

        foreach ($subjects as $subject) {
            $finalScore = $gradeService->calculateFinalGrade($student->id, $subject->id, $academicYear->id);
            
            // Predikat
            $predicate = 'D';
            if ($finalScore >= 90) $predicate = 'A';
            elseif ($finalScore >= 80) $predicate = 'B';
            elseif ($finalScore >= 70) $predicate = 'C';

            $reportData[] = [
                'subject' => $subject,
                'score' => $finalScore,
                'predicate' => $predicate
            ];
            $totalScore += $finalScore;
        }

        $averageScore = count($subjects) > 0 ? round($totalScore / count($subjects), 2) : 0;

        // Rekap Absensi
        $attendances = [
            'H' => Attendance::where('student_id', $student->id)->where('classroom_id', $classroom->id)->where('status', 'H')->count(),
            'S' => Attendance::where('student_id', $student->id)->where('classroom_id', $classroom->id)->where('status', 'S')->count(),
            'I' => Attendance::where('student_id', $student->id)->where('classroom_id', $classroom->id)->where('status', 'I')->count(),
            'A' => Attendance::where('student_id', $student->id)->where('classroom_id', $classroom->id)->where('status', 'A')->count(),
        ];

        $data = [
            'student' => $student,
            'classroom' => $classroom,
            'academicYear' => $academicYear,
            'reportData' => $reportData,
            'averageScore' => $averageScore,
            'attendances' => $attendances,
            'date' => date('d F Y')
        ];

        $pdf = Pdf::loadView('admin.reports.raport_pdf', $data);
        return $pdf->download('raport_' . str_replace(' ', '_', strtolower($student->name)) . '.pdf');
    }
}
