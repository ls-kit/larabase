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
    $lessonProgress = $lessonProgressData[$lesson['id']] ?? 0;
@endphp

<li class="bg-white border border-gray-200 rounded-lg p-4">
    <div class="flex justify-between items-start">
        <div class="flex items-center">
            <div class="w-8 h-8 rounded-full flex items-center justify-center mr-3
                @if($isLessonCompleted) bg-green-100 text-green-600
                @else bg-indigo-100 text-indigo-600 @endif">
                <i class="fas @if($isLessonCompleted) fa-check @else fa-book @endif text-sm"></i>
            </div>
            <h3 class="font-medium text-gray-800">
                {{ $lesson['Title'] }}
                @if(isset($lesson['Lesson Points']) && $lesson['Lesson Points'] > 0)
                    <span class="ml-2 text-xs px-1.5 py-0.5 bg-yellow-100 text-yellow-800 rounded-full">
                        <i class="fas fa-star mr-1"></i> {{ $lesson['Lesson Points'] }} XP
                    </span>
                @endif
            </h3>
        </div>
        
        @if($isLessonCompleted)
            <span class="px-2 py-0.5 bg-green-100 text-green-800 rounded-full text-xs">
                <i class="fas fa-check-circle mr-1"></i> Done
            </span>
        @endif
    </div>

    @if($requireAdminApproval && !$isApproved)
        <div class="mt-3 p-2 bg-red-100 border border-red-200 text-red-800 rounded-lg text-xs flex items-center">
            <i class="fas fa-exclamation-circle mr-2"></i>
            This lesson is currently unavailable
        </div>
    @else
        @if(!$lockLessonsUntilPreviousComplete || $prevLessonCompleted)
            <div class="mt-3">
                <div class="flex justify-between text-xs text-gray-600 mb-1">
                    <span>Progress</span>
                    <span>{{ $lessonProgress }}%</span>
                </div>
                <div class="w-full bg-gray-200 rounded-full h-1.5">
                    <div class="bg-indigo-600 h-1.5 rounded-full" style="width: {{ $lessonProgress }}%"></div>
                </div>
            </div>

            @if(!empty($lesson['Video URL']))
                <div class="mt-3 rounded-lg overflow-hidden">
                    <video controls class="w-full bg-gray-900 aspect-video">
                        <source src="{{ $lesson['Video URL'] }}" type="video/mp4">
                    </video>
                </div>
            @elseif(!empty($lesson['Image']))
                <div class="mt-3 rounded-lg overflow-hidden">
                    <img src="{{ $lesson['Image'] }}" class="w-full h-40 object-cover" alt="Lesson Image">
                </div>
            @endif
            
            @if(!empty($lesson['Guide']))
                <div class="mt-3 bg-indigo-50 text-indigo-800 p-3 rounded-lg text-sm">
                    <div class="prose prose-sm max-w-none">
                        {!! nl2br(e($lesson['Guide'])) !!}
                    </div>
                </div>
            @endif

            @if($isLessonCompleted)
                <div class="mt-3 p-2 bg-green-50 border border-green-200 rounded-lg text-green-800 text-xs flex justify-between">
                    <span><i class="fas fa-check-circle mr-2"></i> Completed!</span>
                    <span><i class="fas fa-star mr-1"></i> {{ $userLessonPoints[$lesson['id']] ?? 0 }} XP</span>
                </div>
            @endif
            
            @if($allQuizzesDone && !$isLessonCompleted)
                <form action="{{ route('lessons.complete', $lesson['id']) }}" method="POST" class="mt-3">
                    @csrf
                    <button type="submit" class="w-full py-2 px-4 bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white font-medium rounded-lg text-sm shadow transition flex items-center justify-center">
                        <i class="fas fa-trophy mr-2"></i>
                        Claim {{ $lesson['Lesson Points'] }} XP
                    </button>
                </form>
            @endif
            
            {{-- Sequential Quiz Display --}}
            <div class="mt-3 space-y-3">
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
            </div>
        @else
            <div class="mt-3 p-2 bg-yellow-50 border border-yellow-200 rounded-lg text-yellow-800 text-xs flex items-center">
                <i class="fas fa-lock mr-2"></i>
                Complete the previous lesson first
            </div>
        @endif
    @endif
</li>