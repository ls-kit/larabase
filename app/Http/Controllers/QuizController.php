<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\QuizUser;

class QuizController extends Controller
{
    public function submit(Request $request, $quizId)
    {
        $user = auth()->user();
        $baserow = new \App\Services\BaserowService();

        // Get current quiz and lesson ID (from POST or from quiz)
        $quiz = collect($baserow->fetch('quizzes'))->firstWhere('id', $quizId);

        $lessonId = $request->input('lesson_id');
        if (!$lessonId && isset($quiz['Lesson'][0]['id'])) {
            $lessonId = $quiz['Lesson'][0]['id'];
        }

        // Fetch all quizzes for this lesson
        $allQuizzes = collect($baserow->fetch('quizzes'));
        $lessonQuizIds = $allQuizzes
            ->filter(fn($q) => isset($q['Lesson'][0]['id']) && $q['Lesson'][0]['id'] == $lessonId)
            ->pluck('id')
            ->all();

        // Fetch all questions for these quizzes
        $allQuestions = collect($baserow->fetch('questions'));
        $allLessonQuestions = $allQuestions
            ->filter(fn($q) =>
                isset($q['Quiz']) &&
                collect($q['Quiz'])->pluck('id')->intersect($lessonQuizIds)->isNotEmpty()
            )
            ->values();

        $totalQuestionsForLesson = $allLessonQuestions->count();

        // Get the lesson row and its points
        $lesson = collect($baserow->fetch('content'))->first(function ($row) use ($lessonId) {
            return isset($row['id']) && $row['id'] == $lessonId &&
                ((is_array($row['Type']) && strtolower($row['Type']['value'] ?? '') === 'lesson') ||
                 (is_string($row['Type']) && strtolower($row['Type']) === 'lesson'));
        });
        $lessonPoints = $lesson['Lesson Points'] ?? 0;

        $pointsPerQuestion = $totalQuestionsForLesson > 0 ? round($lessonPoints / $totalQuestionsForLesson, 2) : 0;

        // Questions for this quiz
        $quizQuestions = $allQuestions
            ->filter(fn($q) =>
                isset($q['Quiz']) &&
                collect($q['Quiz'])->pluck('id')->contains($quizId)
            )
            ->values();

        $submittedAnswers = $request->input('answers', []);
        $correctCount = 0;

        foreach ($quizQuestions as $question) {
            $questionId = $question['id'];
            $correctAnswer = trim($question['Correct Answer'] ?? '');
            $userAnswer = trim($submittedAnswers[$questionId] ?? '');
            if (strcasecmp($correctAnswer, $userAnswer) == 0) {
                $correctCount++;
            }
        }
        $earnedPoints = round($pointsPerQuestion * $correctCount, 2);

        // --- Debugging block (REMOVE after development)
        // Place here if you want to debug submission:
        // dd([
        //     'lessonId' => $lessonId,
        //     'lessonPoints' => $lessonPoints,
        //     'totalQuestionsForLesson' => $totalQuestionsForLesson,
        //     'pointsPerQuestion' => $pointsPerQuestion,
        //     'quizQuestions' => $quizQuestions->pluck('id'),
        //     'correctCount' => $correctCount,
        //     'earnedPoints' => $earnedPoints,
        //     'submittedAnswers' => $submittedAnswers,
        // ]);

        QuizUser::updateOrCreate(
            ['user_id' => $user->id, 'quiz_id' => $quizId],
            [
                'status' => 'completed',
                'completed_at' => now(),
                'points' => $earnedPoints
            ]
        );

        return redirect()->back()->with('success', "Quiz submitted! You earned {$earnedPoints} points.");
    }
}
