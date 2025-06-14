<?php

namespace App\Http\Controllers;
use App\Services\BaserowService;
use App\Models\Progress;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

use App\Models\QuizUser;
use App\Models\LessonUser;



class CourseController extends Controller
{
    public function index(BaserowService $baserow)
    {

   $courses = collect($baserow->fetch('content'))
    ->filter(function($row) {
        return in_array('course', $row['Type'] ?? []);
    })
    ->values();

    // Pass the filtered list to the Blade view
    return view('courses.index', compact('courses'));
    }

    public function explore(BaserowService $baserow)
    {

   $courses = collect($baserow->fetch('content'))
    ->filter(function($row) {
        return in_array('course', $row['Type'] ?? []);
    })
    ->values();

    // Pass the filtered list to the Blade view
    return view('explore', compact('courses'));
    }

    public function show($id, BaserowService $baserow)
    {
        $course = $baserow->find('content', $id);
        $allContent = collect($baserow->fetch('content'));

        $modules = $allContent->filter(function($row) use ($id) {
            return
                ($row['Type']['value'] ?? null) === 'module' &&
                isset($row['Parent']) &&
                collect($row['Parent'])->pluck('id')->contains((int)$id);
        })->sortBy('Order')->values();

        $moduleIds = $modules->pluck('id')->all();
        $lessons = $allContent->filter(function($row) use ($moduleIds) {
            return
                ($row['Type']['value'] ?? null) === 'lesson' &&
                isset($row['Parent']) &&
                collect($row['Parent'])->pluck('id')->intersect($moduleIds)->isNotEmpty();
        })->sortBy('Order')->values();

        $lessonIds = $lessons->pluck('id')->all();

        $allQuizzes = collect($baserow->fetch('quizzes'));
        $quizzes = $allQuizzes->filter(function($q) use ($lessonIds) {
            if (!isset($q['Lesson'])) return false;
            foreach ($q['Lesson'] as $lesson) {
                if (isset($lesson['id']) && in_array($lesson['id'], $lessonIds)) {
                    return true;
                }
            }
            return false;
        })->sortBy('Order')->values();

        $quizIds = $quizzes->pluck('id')->all();

        $userId = auth()->id();
        $quizPoints = [];
        foreach ($quizzes as $quiz) {
            $userQuiz = QuizUser::where('user_id', $userId)->where('quiz_id', $quiz['id'])->first();
            $quizPoints[$quiz['id']] = $userQuiz ? $userQuiz->points : 0;
        }

        $allQuestions = collect($baserow->fetch('questions'));
        $questions = $allQuestions->filter(function($q) use ($quizIds) {
            if (!isset($q['Quiz'])) return false;
            foreach ($q['Quiz'] as $quiz) {
                if (isset($quiz['id']) && in_array($quiz['id'], $quizIds)) {
                    return true;
                }
            }
            return false;
        })->values();

        $completedQuizIds = QuizUser::where('user_id', $userId)
            ->where('status', 'completed')
            ->pluck('quiz_id')
            ->toArray();

        $completedLessonIds = LessonUser::where('user_id', $userId)
            ->where('status', 'completed')
            ->pluck('lesson_id')
            ->toArray();

        // Optional: build user lesson points array for view
        $userLessonPoints = [];
        foreach ($lessons as $lesson) {
            $userLesson = LessonUser::where('user_id', $userId)->where('lesson_id', $lesson['id'])->first();
            $userLessonPoints[$lesson['id']] = $userLesson ? $userLesson->points : 0;
        }


        $lessonQuestionCounts = [];
        foreach ($lessons as $lesson) {
            $lessonId = $lesson['id'];
            // Find all quizzes for this lesson
            $quizzesForLesson = $allQuizzes->filter(function($quiz) use ($lessonId) {
                if (!isset($quiz['Lesson'])) return false;
                foreach ($quiz['Lesson'] as $l) {
                    if (isset($l['id']) && $l['id'] == $lessonId) return true;
                }
                return false;
            })->pluck('id')->all();

            // Find all questions for these quizzes
            $questionsForLesson = $allQuestions->filter(function($q) use ($quizzesForLesson) {
                if (!isset($q['Quiz'])) return false;
                foreach ($q['Quiz'] as $qz) {
                    if (isset($qz['id']) && in_array($qz['id'], $quizzesForLesson)) return true;
                }
                return false;
            });

            $lessonQuestionCounts[$lessonId] = $questionsForLesson->count();
        }


        $completedModuleIds = [];
        foreach ($modules as $module) {
            $moduleLessonList = $lessons->filter(function($l) use ($module) {
                return isset($l['Parent']) && collect($l['Parent'])->pluck('id')->contains($module['id']);
            })->pluck('id')->all();
            // All lessons in this module must be completed
            if (!empty($moduleLessonList) && !array_diff($moduleLessonList, $completedLessonIds)) {
                $completedModuleIds[] = $module['id'];
            }
        }





    $userPayment = null;
    $userHasAccess = false;
    $paymentPendingOrRejected = false;

    if (auth()->check() && $course['Price'] > 0) {
        $payments = collect($baserow->fetch('payments'))
            ->filter(function ($row) use ($course) {
                return (isset($row['User ID']) && $row['User ID'] == auth()->id())
                    && (isset($row['Course ID']) && $row['Course ID'] == $course['id']);
            });

        $userPayment = $payments->sortByDesc('id')->first();

        // **This is the correct way to extract the status value:**
        $statusValue = '';
        if ($userPayment && isset($userPayment['Status'])) {
            $status = $userPayment['Status'];
            if (is_array($status) && isset($status['value'])) {
                $statusValue = $status['value'];
            } else {
                $statusValue = $status;
            }
        }

        $userHasAccess = $userPayment && $statusValue === 'Approved';
        $paymentPendingOrRejected = $userPayment && $statusValue !== 'Approved';
    } elseif (auth()->check() && $course['Price'] == 0) {
        $userHasAccess = true;
    }

        // dd($userHasAccess, $paymentPendingOrRejected, $userPayment);
        // dd($course['Price'], $userPayment);
        // dd($userHasAccess, $paymentPendingOrRejected);



         // ===== NEW PROGRESS CALCULATION CODE =====
        $moduleProgress = [];
        $lessonProgressData = [];

        // Calculate module progress
        foreach ($modules as $module) {
            $moduleLessonIds = $lessons->filter(function($lesson) use ($module) {
                return isset($lesson['Parent']) && 
                       collect($lesson['Parent'])->pluck('id')->contains($module['id']);
            })->pluck('id')->toArray();

            if (empty($moduleLessonIds)) {
                $moduleProgress[$module['id']] = 0;
                continue;
            }

            $completedCount = count(array_intersect($moduleLessonIds, $completedLessonIds));
            $moduleProgress[$module['id']] = round(($completedCount / count($moduleLessonIds)) * 100);
        }

        // Calculate lesson progress
        foreach ($lessons as $lesson) {
            $lessonQuizIds = $quizzes->filter(function($quiz) use ($lesson) {
                if (!isset($quiz['Lesson'])) return false;
                foreach ($quiz['Lesson'] as $l) {
                    if (isset($l['id']) && $l['id'] == $lesson['id']) {
                        return true;
                    }
                }
                return false;
            })->pluck('id')->toArray();

            if (empty($lessonQuizIds)) {
                $lessonProgressData[$lesson['id']] = 0;
                continue;
            }

            $completedCount = count(array_intersect($lessonQuizIds, $completedQuizIds));
            $lessonProgressData[$lesson['id']] = round(($completedCount / count($lessonQuizIds)) * 100);
        }
        // ===== END NEW PROGRESS CALCULATION =====


// dd($userPayment);
        return view('courses.show', compact(
            'course',
            'modules',
            'lessons',
            'quizzes',
            'questions',
            'completedQuizIds',
            'completedLessonIds',
            'quizPoints',
            'userLessonPoints',
            'completedModuleIds',
            'userPayment',
            'userHasAccess',
            'paymentPendingOrRejected',
            'moduleProgress',         
            'lessonProgressData'      
        ));
    }


}