@php
    // Find lesson index and previous lesson (if any)
    $lessonIndex = $moduleLessonList->search(fn($l) => $l['id'] == $lesson['id']);
    $prevLesson = $lessonIndex > 0 ? $moduleLessonList[$lessonIndex - 1] : null;
    $prevLessonCompleted = !$prevLesson || in_array($prevLesson['id'], $completedLessonIds ?? []);
    $isApproved = ($lesson['Admin Approved'] ?? true);
    $isLessonCompleted = in_array($lesson['id'], $completedLessonIds ?? []);
    // Quizzes for this lesson
    $lessonQuizzes = $quizzes->filter(function($quiz) use ($lesson) {
        if (!isset($quiz['Lesson'])) return false;
        foreach ($quiz['Lesson'] as $l) {
            if (isset($l['id']) && $l['id'] == $lesson['id']) {
                return true;
            }
        }
        return false;
    })->values();
    $lessonQuizIds = $lessonQuizzes->pluck('id')->toArray();
    $firstIncompleteQuiz = $lessonQuizzes->first(function($quiz) use ($completedQuizIds) {
        return !in_array($quiz['id'], $completedQuizIds ?? []);
    });
    $allQuizzesDone = count(array_diff($lessonQuizIds, $completedQuizIds ?? [])) === 0 && count($lessonQuizIds) > 0;
@endphp

<li class="mb-4 p-4 border rounded">
    <div>
        <strong>{{ $lesson['Title'] }}</strong>
        @if(isset($lesson['Lesson Points']) && $lesson['Lesson Points'] > 0)
            <span class="ml-2 text-blue-700 text-sm">(Points: {{ $lesson['Lesson Points'] }})</span>
        @endif
    </div>

    @if($requireAdminApproval && !$isApproved)
        <div class="text-red-700 bg-red-100 p-2 rounded my-2">
            This lesson is currently unavailable. Please contact support.
        </div>
    @else
        @if(!$lockLessonsUntilPreviousComplete || $prevLessonCompleted)
            @if(!empty($lesson['Video URL']))
                <div>
                    <a href="{{ $lesson['Video URL'] }}" target="_blank" class="text-blue-600 underline">Watch Video</a>
                </div>
            @endif

            @if($isLessonCompleted)
                <span class="text-green-600 font-bold ml-2">Lesson Completed!</span>
                <span class="text-sm text-blue-600 ml-2">Points: {{ $userLessonPoints[$lesson['id']] ?? 0 }}</span>
            @endif

            @if($allQuizzesDone && !$isLessonCompleted)
                <form action="{{ route('lessons.complete', $lesson['id']) }}" method="POST" style="display:inline;">
                    @csrf
                    <button type="submit" class="btn btn-success">Mark Lesson as Complete</button>
                </form>
            @endif

            {{-- Sequential Quiz Display: show completed and next incomplete only --}}
            @php $showNext = true; @endphp
            @foreach($lessonQuizzes as $quiz)
                @php $quizCompleted = in_array($quiz['id'], $completedQuizIds ?? []); @endphp
                @if($quizCompleted || $showNext)
                    @include('courses._quiz', [
                        'quiz' => $quiz,
                        'quizCompleted' => $quizCompleted,
                        'questions' => $questions,
                        'quizPoints' => $quizPoints ?? [],
                        'lesson' => $lesson,
                    ])
                    @if(!$quizCompleted)
                        @php $showNext = false; @endphp
                    @endif
                @endif
            @endforeach

        @else
            <div class="text-yellow-700 bg-yellow-100 p-2 rounded my-2">
                Complete the previous lesson to unlock this lesson.
            </div>
        @endif
    @endif
</li>
