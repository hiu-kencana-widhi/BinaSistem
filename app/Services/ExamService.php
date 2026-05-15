<?php

namespace App\Services;

use App\Models\Exam;
use App\Models\Question;
use App\Models\ExamAnswer;

class ExamService
{
    /**
     * Calculate the percentage score of a student for a specific exam.
     *
     * @param int $examId
     * @param int $studentId
     * @return float|int
     */
    public function calculateScore($examId, $studentId)
    {
        // Get all questions for this exam
        $questions = Question::where('exam_id', $examId)->get();
        
        $totalQuestions = $questions->count();
        if ($totalQuestions === 0) {
            return 0;
        }

        // Get all student answers for this exam
        $answers = ExamAnswer::where('exam_id', $examId)
            ->where('student_id', $studentId)
            ->get()
            ->keyBy('question_id');

        $correctCount = 0;

        foreach ($questions as $question) {
            if (isset($answers[$question->id])) {
                $studentAnswer = strtoupper($answers[$question->id]->answer_char);
                $correctAnswer = strtoupper($question->correct_answer_char);
                
                if ($studentAnswer === $correctAnswer) {
                    $correctCount++;
                }
            }
        }

        // Calculate percentage (0-100)
        $score = ($correctCount / $totalQuestions) * 100;

        return round($score, 2);
    }
}
