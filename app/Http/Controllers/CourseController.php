<?php

namespace App\Http\Controllers;
use App\Services\BaserowService;
use App\Models\Progress;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;


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

    public function show($id, BaserowService $baserow)
{
    $course = $baserow->find('content', $id);

    $allContent = collect($baserow->fetch('content'));

    // Modules: filter by Type object
    $modules = $allContent->filter(function($row) use ($id) {
        return
            ($row['Type']['value'] ?? null) === 'module' &&
            isset($row['Parent']) &&
            collect($row['Parent'])->pluck('id')->contains((int)$id);
    })->sortBy('Order')->values();

    // Lessons: filter by Type object and module ids
    $moduleIds = $modules->pluck('id')->all();
    $lessons = $allContent->filter(function($row) use ($moduleIds) {
        return
            ($row['Type']['value'] ?? null) === 'lesson' &&
            isset($row['Parent']) &&
            collect($row['Parent'])->pluck('id')->intersect($moduleIds)->isNotEmpty();
    })->sortBy('Order')->values();

    $lessonIds = $lessons->pluck('id')->all();

    // Fetch all quizzes (and filter by linked lesson id)
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

    // Questions: filter by linked quiz id (adjust filter if your field structure is different)
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

    return view('courses.show', compact('course', 'modules', 'lessons', 'quizzes', 'questions'));
}


}