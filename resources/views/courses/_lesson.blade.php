@php
    $lessonIndex = $moduleLessonList->search(fn($l) => $l['id'] == $lesson['id']);
    $prevLesson = $lessonIndex > 0 ? $moduleLessonList[$lessonIndex - 1] : null;
    $prevLessonCompleted = !$prevLesson || in_array($prevLesson['id'], $completedLessonIds ?? []);
    $isApproved = ($lesson['Admin Approved'] ?? true);
    $isLessonCompleted = in_array($lesson['id'], $completedLessonIds ?? []);
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

<li class="mb-4 p-6 bg-gray-50 border border-gray-200 rounded-xl shadow-sm">
    <div class="flex items-center mb-1">
        <strong class="text-lg text-gray-800">{{ $lesson['Title'] }}</strong>
        @if(isset($lesson['Lesson Points']) && $lesson['Lesson Points'] > 0)
            <span class="ml-2 text-blue-700 text-sm font-semibold">(Points: {{ $lesson['Lesson Points'] }})</span>
        @endif
    </div>
    @if($requireAdminApproval && !$isApproved)
        <div class="text-red-700 bg-red-100 p-2 rounded my-2">
            This lesson is currently unavailable. Please contact support.
        </div>
    @else
        @if(!$lockLessonsUntilPreviousComplete || $prevLessonCompleted)
            {{-- Video/Image/Text Guide --}}
            @if(!empty($lesson['Video URL']))
                <div class="my-3">
                  <video controls class="w-full rounded-xl shadow-md max-h-80 bg-black">
                      <source src="{{ $lesson['Video URL'] }}" type="video/mp4">
                      Your browser does not support the video tag.
                  </video>
                </div>
            @elseif(!empty($lesson['Image']))
                <div class="my-3">
                  <img src="{{ $lesson['Image'] }}" class="w-full max-h-80 object-cover rounded-xl shadow-md" alt="Lesson Image">
                </div>
            @endif
            @if(!empty($lesson['Guide']))
                <div class="bg-blue-50 text-blue-800 p-4 rounded-lg mb-3 shadow-inner">
                  {!! nl2br(e($lesson['Guide'])) !!}
                </div>
            @endif
            @if($isLessonCompleted)
                <span class="text-green-600 font-bold ml-2">Lesson Completed!</span>
                <span class="text-sm text-blue-600 ml-2">Points: {{ $userLessonPoints[$lesson['id']] ?? 0 }}</span>
            @endif
            @if($allQuizzesDone && !$isLessonCompleted)
                <form action="{{ route('lessons.complete', $lesson['id']) }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="rounded-full px-4 py-2 bg-green-600 hover:bg-green-700 text-white font-semibold shadow transition">Mark Lesson as Complete</button>
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