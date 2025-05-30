@extends('layouts.app')
@section('content')

@php
    $lockLessonsUntilPreviousComplete = true;
    $requireAdminApproval = true;

    // Calculate total points for this course by summing lesson points
    $totalPoints = $lessons->sum(function($l) {
        return (float)($l['Lesson Points'] ?? 0);
    });
@endphp

<h1 class="text-2xl font-bold mb-4">{{ $course['Title'] }}</h1>
<p>{{ $course['Description'] ?? '' }}</p>

{{-- Show price/free and total points --}}
<div class="mb-6">
    <span class="inline-block px-3 py-1 rounded bg-blue-50 text-blue-700 font-semibold mr-4">
        {{ $course['Price'] > 0 ? 'Price: ' . $course['Price'] . '৳' : 'Free' }}
    </span>
    <span class="inline-block px-3 py-1 rounded bg-green-50 text-green-700 font-semibold">
        Total Points: {{ $totalPoints }}
    </span>
</div>

{{-- Payment form at the top if not yet paid --}}
@if($course['Price'] > 0 && !($userHasAccess ?? false))
    @if($paymentPendingOrRejected)
        <div class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-4 my-4">
            We are processing your payment. Please wait for admin approval.<br>
            In the meantime, enjoy our free courses!
        </div>
    @else
    <div class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-4 my-4 rounded">
        <h3 class="font-bold mb-2">Unlock This Course</h3>
        <form action="{{ route('courses.pay', $course['id']) }}" method="POST" id="payment-form">
            @csrf
            <div class="mb-2">
                <label class="block">Payment Method</label>
                <select name="payment_method" required class="border rounded p-1 w-full">
                    <option value="">Select</option>
                    <option value="Bkash">bKash</option>
                    <option value="Nagad">Nagad</option>
                    <option value="Rocket">Rocket</option>
                </select>
            </div>
            <div class="mb-2">
                <label class="block">Sender Number</label>
                <input type="text" name="sender_number" required class="border rounded p-1 w-full">
            </div>
            <div class="mb-2">
                <label class="block">Transaction ID</label>
                <input type="text" name="transaction_id" required class="border rounded p-1 w-full">
            </div>
            <input type="hidden" name="course_title" value="{{ $course['Title'] }}">
            <input type="hidden" name="price" value="{{ $course['Price'] }}">
            <button type="submit" class="btn btn-primary mt-2 w-full">Submit Payment</button>
        </form>
        <p class="mt-2 text-xs">After submitting, your access will be approved by admin.</p>
    </div>
    @endif
@endif

{{-- Only show modules if user has access (or course is free) --}}
@if($course['Price'] == 0 || ($userHasAccess ?? false))
    <h2 class="text-xl font-semibold mt-6">Modules</h2>
    @foreach($modules as $module)
        @php
            $moduleIndex = $modules->search(fn($m) => $m['id'] == $module['id']);
            $prevModule = $moduleIndex > 0 ? $modules[$moduleIndex - 1] : null;
            $prevModuleCompleted = !$prevModule || in_array($prevModule['id'], $completedModuleIds ?? []);
            $moduleLessonList = $lessons->filter(fn($l) =>
                isset($l['Parent']) && collect($l['Parent'])->pluck('id')->contains($module['id'])
            )->values();
        @endphp

        <div class="mb-4 p-2 border rounded">
            <h3 class="font-bold">{{ $module['Title'] }}</h3>
            @if(!$prevModuleCompleted)
                <div class="text-yellow-700 bg-yellow-100 p-2 rounded my-2">
                    Complete the previous module to unlock this module.
                </div>
            @else
                <ul class="list-disc ml-4">
                    @foreach($moduleLessonList as $lesson)
                        @include('courses._lesson', [
                            'lesson' => $lesson,
                            'moduleLessonList' => $moduleLessonList,
                            'lockLessonsUntilPreviousComplete' => $lockLessonsUntilPreviousComplete,
                            'requireAdminApproval' => $requireAdminApproval,
                            'completedLessonIds' => $completedLessonIds,
                            'quizzes' => $quizzes,
                            'questions' => $questions,
                            'completedQuizIds' => $completedQuizIds,
                        ])
                    @endforeach
                </ul>
            @endif
        </div>
    @endforeach
@endif

@endsection

