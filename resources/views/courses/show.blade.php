@extends('layouts.app')
@section('content')

<!-- {{-- Debug modules --}}
<pre>Modules: {{ print_r($modules->toArray(), true) }}</pre>

{{-- Debug lessons --}}
<pre>Lessons: {{ print_r($lessons->toArray(), true) }}</pre>

{{-- Debug quizzes --}}
<pre>Quizzes: {{ print_r($quizzes->toArray(), true) }}</pre>

{{-- Debug questions --}}
<pre>Questions: {{ print_r($questions->toArray(), true) }}</pre> -->


  <h1 class="text-2xl font-bold mb-4">{{ $course['Title'] }}</h1>
  <p>{{ $course['Description'] ?? '' }}</p>

  <h2 class="text-xl font-semibold mt-6">Modules</h2>
  @foreach($modules as $module)
    <div class="mb-4 p-2 border rounded">
      <h3 class="font-bold">{{ $module['Title'] }}</h3>
      <ul class="list-disc ml-4">
        {{-- Lessons for this module --}}
        @foreach($lessons->filter(function($lesson) use ($module) {
            if (!isset($lesson['Parent'])) return false;
            foreach ($lesson['Parent'] as $parent) {
                if (isset($parent['id']) && $parent['id'] == $module['id']) {
                    return true;
                }
            }
            return false;
        }) as $lesson)
          <li class="mb-2">
            <strong>{{ $lesson['Title'] }}</strong>
            @if(!empty($lesson['Video URL']))
              <br>
              <a href="{{ $lesson['Video URL'] }}" target="_blank" class="text-blue-600 underline">Watch Video</a>
            @endif

            {{-- Quizzes for this lesson --}}
            @foreach($quizzes->filter(function($quiz) use ($lesson) {
                if (!isset($quiz['Lesson'])) return false;
                foreach ($quiz['Lesson'] as $l) {
                    if (isset($l['id']) && $l['id'] == $lesson['id']) {
                        return true;
                    }
                }
                return false;
            }) as $quiz)
              <div class="ml-4 mt-2 p-2 border rounded bg-gray-50">
                <strong>Quiz: {{ $quiz['Name'] }}</strong>
                <ul class="list-disc ml-4">
                  {{-- Questions for this quiz --}}
                  @foreach($questions->filter(function($question) use ($quiz) {
                      if (!isset($question['Quiz'])) return false;
                      foreach ($question['Quiz'] as $q) {
                          if (isset($q['id']) && $q['id'] == $quiz['id']) {
                              return true;
                          }
                      }
                      return false;
                  }) as $question)
                    <li class="mt-2">
                      <span>{{ $question['Question'] }}</span>
                      @if($question['Type'] == 'mcq')
                        <ul>
                          @foreach(explode(';', $question['Options'] ?? '') as $opt)
                            <li>
                              <input type="radio" name="q{{ $question['id'] }}">
                              {{ trim($opt) }}
                            </li>
                          @endforeach
                        </ul>
                      @elseif($question['Type'] == 'fill_in_blank')
                        <input type="text" name="q{{ $question['id'] }}" class="border p-1">
                      @endif
                    </li>
                  @endforeach
                </ul>
              </div>
            @endforeach

          </li>
        @endforeach
      </ul>
    </div>
  @endforeach
@endsection
