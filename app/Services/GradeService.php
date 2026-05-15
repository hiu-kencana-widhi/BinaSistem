<?php

namespace App\Services;

use App\Models\Grade;
use App\Models\AssignmentSubmission;
use App\Models\ExamResult;

class GradeService
{
    /**
     * Menghitung nilai akhir untuk murid pada mapel tertentu.
     * Rumus: 20% Rata-rata Tugas + 30% UTS + 50% UAS
     *
     * @param int $studentId
     * @param int $subjectId
     * @param int $academicYearId
     * @return float
     */
    public function calculateFinalGrade($studentId, $subjectId, $academicYearId)
    {
        // 1. Hitung Rata-rata Tugas (Dari submissions)
        // Assignment terkait subject_id dan submission-nya dinilai
        $avgTugas = AssignmentSubmission::where('student_id', $studentId)
            ->whereHas('assignment', function ($q) use ($subjectId) {
                $q->where('subject_id', $subjectId);
            })
            ->avg('score') ?? 0;

        // 2. Ambil nilai UTS (Bisa dari grades manual atau exam_results. Kita asumsikan grades)
        $utsGrade = Grade::where('student_id', $studentId)
            ->where('subject_id', $subjectId)
            ->where('academic_year_id', $academicYearId)
            ->where('tipe_nilai', 'UTS')
            ->first();
        $uts = $utsGrade ? $utsGrade->skor : 0;

        // 3. Ambil nilai UAS
        $uasGrade = Grade::where('student_id', $studentId)
            ->where('subject_id', $subjectId)
            ->where('academic_year_id', $academicYearId)
            ->where('tipe_nilai', 'UAS')
            ->first();
        $uas = $uasGrade ? $uasGrade->skor : 0;

        // 4. Kalkulasi Akhir
        // Jika UTS/UAS tidak ada di tabel grades manual, kita bisa coba cari dari exam_results jika ada ujian terkait mapel ini.
        // Untuk sistem Enterprise, kita fallback ke exam_results jika manual tidak ada.
        if (!$utsGrade) {
            $utsExam = ExamResult::where('student_id', $studentId)
                ->whereHas('exam', function ($q) use ($subjectId) {
                    $q->where('subject_id', $subjectId)->where('title', 'like', '%UTS%');
                })->first();
            $uts = $utsExam ? $utsExam->score : 0;
        }

        if (!$uasGrade) {
            $uasExam = ExamResult::where('student_id', $studentId)
                ->whereHas('exam', function ($q) use ($subjectId) {
                    $q->where('subject_id', $subjectId)->where('title', 'like', '%UAS%');
                })->first();
            $uas = $uasExam ? $uasExam->score : 0;
        }

        // Rumus: 20% Tugas + 30% UTS + 50% UAS
        $finalScore = ($avgTugas * 0.20) + ($uts * 0.30) + ($uas * 0.50);

        return round($finalScore, 2);
    }
}
