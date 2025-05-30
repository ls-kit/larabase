<div class="ml-4 mt-2 p-2 border rounded bg-gray-50">
  <strong>Quiz: {{ $quiz['Name'] }}</strong>

  @if($quizCompleted)
    <span class="text-green-600 font-bold ml-2">Quiz Completed!</span>
    <span class="text-blue-600 ml-2">Earned: {{ $quizPoints[$quiz['id']] ?? 0 }} points</span>
  @else
    <form action="{{ route('quizzes.submit', $quiz['id']) }}" method="POST">
      @csrf
      <input type="hidden" name="lesson_id" value="{{ $lesson['id'] }}">
      <input type="hidden" name="lesson_points" value="{{ $lesson['Lesson Points'] }}">
      <ul class="list-disc ml-4">
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
            @if(($question['Type']['value'] ?? '') == 'mcq')
              <ul>
                @foreach(explode(';', $question['Options'] ?? '') as $opt)
                  @if(trim($opt) !== '')
                    <li>
                      <label>
                        <input type="radio" name="answers[{{ $question['id'] }}]" value="{{ trim($opt) }}">
                        {{ trim($opt) }}
                      </label>
                    </li>
                  @endif
                @endforeach
              </ul>
            @elseif(($question['Type']['value'] ?? '') == 'fill_in_blank')
              <input type="text" name="answers[{{ $question['id'] }}]" class="border p-1">
            @endif
          </li>
        @endforeach
      </ul>
      <button type="submit" class="btn btn-primary mt-2">Submit Quiz</button>
    </form>
  @endif
</div>
