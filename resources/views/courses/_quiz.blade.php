<div class="ml-4 mt-2 p-4 border border-gray-300 rounded-xl bg-gray-50 shadow 
            transition-transform duration-200 hover:-translate-y-1 hover:scale-105 hover:shadow-2xl 
            cursor-pointer group relative overflow-hidden quiz-card relative">
  <div class="flex items-center mb-2">
    <strong class="text-blue-800">Quiz: {{ $quiz['Name'] }}</strong>
    @if($quizCompleted)
      <span class="text-green-600 font-bold ml-2">Quiz Completed!</span>
      <span class="text-blue-600 ml-2">Earned: {{ $quizPoints[$quiz['id']] ?? 0 }} points</span>
    @endif
  </div>
  @if(!$quizCompleted)
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
              <input type="text" name="answers[{{ $question['id'] }}]" class="border p-1 rounded">
            @endif
          </li>
        @endforeach
      </ul>
      <button type="submit"
        class="rounded-full px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold shadow mt-3
              animate-pulse focus:animate-none transition"
      >
        Submit Quiz
      </button>
    </form>
  @endif
</div>