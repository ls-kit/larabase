<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;


use App\Models\LessonUser;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class LessonController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function completeLesson($lessonId)
    {
        $user = auth()->user();

        // Fetch lesson points dynamically from Baserow
        $baserow = app(\App\Services\BaserowService::class);
        
        // $lesson = collect($baserow->fetch('content'))->first(function ($row) use ($lessonId) {
        //     return isset($row['id'], $row['Type']['value'])
        //         && $row['id'] == $lessonId
        //         && strtolower($row['Type']['value']) === 'lesson';
        // });
        // $points = $lesson['Lesson Points'] ?? 0;





            // Fetch all quizzes for this lesson
        $allQuizzes = collect($baserow->fetch('quizzes'))->filter(function ($quiz) use ($lessonId) {
            if (!isset($quiz['Lesson'])) return false;
            foreach ($quiz['Lesson'] as $lesson) {
                if (isset($lesson['id']) && $lesson['id'] == $lessonId) return true;
            }
            return false;
        });

        $quizIds = $allQuizzes->pluck('id')->all();

        // Sum points earned in all quizzes for this lesson
        $totalEarned = \App\Models\QuizUser::where('user_id', $user->id)
            ->whereIn('quiz_id', $quizIds)
            ->sum('points');


        LessonUser::updateOrCreate(
            ['user_id' => $user->id, 'lesson_id' => $lessonId],
            [
                'status' => 'completed',
                'completed_at' => now(),
                'points' => $totalEarned
            ]
        );

        return redirect()->back()->with('success', 'Lesson completed! You earned {$totalEarned} points.');
    }

    public function userProgress()
    {
        $user = Auth::user();

        $today = LessonUser::where('user_id', $user->id)
            ->whereDate('completed_at', Carbon::today())
            ->count();

        $lastWeek = LessonUser::where('user_id', $user->id)
            ->whereBetween('completed_at', [Carbon::now()->subWeek(), Carbon::now()])
            ->count();

        $monthData = LessonUser::where('user_id', $user->id)
            ->whereMonth('completed_at', Carbon::now()->month)
            ->get()
            ->groupBy(function($item) {
                return Carbon::parse($item->completed_at)->format('Y-m-d');
            });

        $totalPoints = LessonUser::where('user_id', $user->id)->sum('points');

        return view('progress.index', compact('today', 'lastWeek', 'monthData', 'totalPoints'));
    }
}
