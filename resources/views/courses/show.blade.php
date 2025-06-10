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


<div class="max-w-4xl mx-auto py-8 px-2">
  <div class="bg-gradient-to-r from-blue-50 to-white rounded-3xl shadow-lg p-8 mb-8">
    <h1 class="text-3xl font-extrabold mb-2 text-blue-900 flex items-center">
      <span>{{ $course['Title'] }}</span>
      @if($course['Price'] > 0)
        <span class="ml-4 px-3 py-1 rounded-full bg-orange-100 text-orange-600 text-sm font-bold animate-pulse">৳{{ $course['Price'] }}</span>
      @else
        <span class="ml-4 px-3 py-1 rounded-full bg-green-100 text-green-700 text-sm font-bold">Free</span>
      @endif
    </h1>
    <p class="text-lg text-gray-700 mb-4">{{ $course['Description'] ?? '' }}</p>
    <div class="flex items-center gap-4">
      <span class="inline-block px-3 py-1 rounded-full bg-green-50 text-green-700 font-semibold">Total Points: {{ $totalPoints }}</span>
    </div>
  </div>

  {{-- Payment card if needed --}}
  @if($course['Price'] > 0 && !($userHasAccess ?? false))
    <div class="bg-yellow-50 border-l-8 border-yellow-400 text-yellow-800 p-6 rounded-xl mb-8 animate-fadeIn">
      @if($paymentPendingOrRejected)
        <p class="mb-2 font-semibold">Payment is processing. Please wait for admin approval.<br><span class="text-sm">Meanwhile, enjoy our free courses!</span></p>
      @else
        <h3 class="font-bold text-lg mb-2">Unlock This Course</h3>
        <form action="{{ route('courses.pay', $course['id']) }}" method="POST" id="payment-form" class="grid gap-4">
          @csrf
          <div>
            <label class="block text-sm font-semibold">Payment Method</label>
            <select name="payment_method" required class="form-select w-full rounded-xl mt-1 border-gray-300 focus:ring focus:border-blue-400">
              <option value="">Select</option>
              <option value="Bkash">bKash</option>
              <option value="Nagad">Nagad</option>
              <option value="Rocket">Rocket</option>
            </select>
          </div>
          <div>
            <label class="block text-sm font-semibold">Sender Number</label>
            <input type="text" name="sender_number" required class="form-input w-full rounded-xl mt-1 border-gray-300 focus:ring focus:border-blue-400">
          </div>
          <div>
            <label class="block text-sm font-semibold">Transaction ID</label>
            <input type="text" name="transaction_id" required class="form-input w-full rounded-xl mt-1 border-gray-300 focus:ring focus:border-blue-400">
          </div>
          <input type="hidden" name="course_title" value="{{ $course['Title'] }}">
          <input type="hidden" name="price" value="{{ $course['Price'] }}">
          <button type="submit" class="w-full rounded-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 mt-2 shadow-md transition">Submit Payment</button>
        </form>
        <p class="mt-2 text-xs text-yellow-700">After submitting, your access will be approved by admin.</p>
      @endif
    </div>
  @endif

  {{-- Only show modules if user has access (or course is free) --}}
  @if($course['Price'] == 0 || ($userHasAccess ?? false))
    <h2 class="text-2xl font-bold text-blue-700 mb-4">Modules</h2>
    <div class="space-y-6">
      @foreach($modules as $module)
        @php
            $moduleIndex = $modules->search(fn($m) => $m['id'] == $module['id']);
            $prevModule = $moduleIndex > 0 ? $modules[$moduleIndex - 1] : null;
            $prevModuleCompleted = !$prevModule || in_array($prevModule['id'], $completedModuleIds ?? []);
            $moduleLessonList = $lessons->filter(fn($l) =>
                isset($l['Parent']) && collect($l['Parent'])->pluck('id')->contains($module['id'])
            )->values();
        @endphp
        <div class="mb-4 p-6 bg-white border border-blue-100 rounded-2xl shadow-lg">
            <h3 class="font-bold text-lg mb-2 text-blue-800 flex items-center">
                <svg class="w-5 h-5 mr-2 text-blue-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3" /></svg>
                {{ $module['Title'] }}
                @if(!$prevModuleCompleted)
                  <span class="ml-4 px-2 py-1 bg-yellow-100 text-yellow-800 text-xs rounded-full">Locked</span>
                @elseif(in_array($module['id'], $completedModuleIds ?? []))
                  <span class="ml-4 px-2 py-1 bg-green-100 text-green-800 text-xs rounded-full">Completed</span>
                @endif
            </h3>
            @if(!$prevModuleCompleted)
                <div class="text-yellow-700 bg-yellow-100 p-2 rounded my-2">
                    Complete the previous module to unlock this module.
                </div>
            @else
                <ul class="list-disc ml-4 mt-3 space-y-4">
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
                            'quizPoints' => $quizPoints ?? [],
                            'userLessonPoints' => $userLessonPoints ?? [],
                        ])
                    @endforeach
                </ul>
            @endif
        </div>
      @endforeach
    </div>
  @endif
</div>
@endsection