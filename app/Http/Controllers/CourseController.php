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
        $courses = $baserow->fetch('courses');
        return view('courses.index', compact('courses'));
    }
public function show($courseId, BaserowService $baserow)
{
    // 1) Grab IDs from config
    $tableId = config('baserow.tables.modules');
    $fieldId = config('baserow.fields.modules.course');
    $url     = config('baserow.url');

    // 2) Call the API with filter__field_{fieldId}__link_row_has
    $response = Http::withHeaders([
        'Authorization' => "Token " . config('baserow.token'),
        'Content-Type'  => 'application/json',
    ])->get("{$url}/rows/table/{$tableId}/", [
        'user_field_names'                                     => 'true',
        "filter__field_{$fieldId}__link_row_has"               => $courseId,
        // you can also use link_row_has_not, link_row_contains, etc.
    ]);

    $response->throw();
    $modules = $response->json()['results'] ?? [];

    // 3) Fetch the course for its name
    $course  = $baserow->find('courses', $courseId);

    return view('courses.show', compact('course','modules'));
}



    // public function show($courseId, BaserowService $baserow)
    // {
    //     $course = $baserow->find('courses', $courseId);
    //     return view('courses.show', compact('course'));
    // }
    // public function show($courseId, BaserowService $baserow)
    // {
    //     // fetch modules/lessons/tasks
    //     $modules = collect($baserow->fetch('modules'))->where('course', $courseId);
    //     return view('courses.show', compact('modules', 'courseId'));
    // }
    // public function show(string $table, int $id)
    // {
    //     $row = $this->baserow->find($table, $id);
    //     return view('crud.show', compact('row', 'table'));
    // }

    public function lesson($lessonId, BaserowService $baserow)
    {
        $lesson = collect($baserow->fetch('lessons'))->firstWhere('id', $lessonId);
        $tasks  = collect($baserow->fetch('tasks'))->where('lesson', $lessonId);
        return view('courses.lesson', compact('lesson', 'tasks'));
    }

    public function completeTask($taskId)
    {
        $userId = Auth::id();
        Progress::updateOrCreate(
            ['user_id' => $userId, 'task_id' => $taskId],
            ['completed' => true]
        );
        return back();
    }

}
