@php
    $quizPointsEarned = $quizPoints[$quiz['id']] ?? 0;
@endphp

<div class="bg-white border border-gray-200 rounded-lg p-4 shadow-sm">
    <div class="flex justify-between items-center">
        <h4 class="font-medium text-gray-800 flex items-center">
            <i class="fas fa-question-circle text-indigo-600 mr-2"></i>
            {{ $quiz['Name'] }}
        </h4>
        
        @if($quizCompleted)
            <div class="flex items-center">
                <span class="px-2 py-0.5 bg-green-100 text-green-800 rounded-full text-xs mr-2">
                    <i class="fas fa-check"></i>
                </span>
                <span class="text-xs px-1.5 py-0.5 bg-yellow-100 text-yellow-800 rounded-full">
                    <i class="fas fa-star mr-1"></i> {{ $quizPointsEarned }} XP
                </span>
            </div>
        @endif
    </div>
    
    @if(!$quizCompleted)
        <form action="{{ route('quizzes.submit', $quiz['id']) }}" method="POST" class="mt-3">
            @csrf
            <input type="hidden" name="lesson_id" value="{{ $lesson['id'] }}">
            <input type="hidden" name="lesson_points" value="{{ $lesson['Lesson Points'] }}">
            
            <div class="space-y-3">
                @foreach($questions->filter(function($question) use ($quiz) {
                    if (!isset($question['Quiz'])) return false;
                    foreach ($question['Quiz'] as $q) {
                        if (isset($q['id']) && $q['id'] == $quiz['id']) {
                            return true;
                        }
                    }
                    return false;
                }) as $question)
                    <div class="p-3 bg-gray-50 rounded-lg">
                        <div class="font-medium text-gray-800 text-sm mb-2">
                            <span class="text-indigo-600">Q{{ $loop->iteration }}.</span> {{ $question['Question'] }}
                        </div>
                        
                        @if(($question['Type']['value'] ?? '') == 'mcq')
                            <div class="space-y-1.5">
                                @foreach(explode(';', $question['Options'] ?? '') as $opt)
                                    @if(trim($opt) !== '')
                                        <label class="flex items-center p-2 border border-gray-200 rounded hover:bg-indigo-50 cursor-pointer text-sm"
                                               @mouseenter="$store.sound.play('hover')">
                                            <input type="radio" name="answers[{{ $question['id'] }}]" value="{{ trim($opt) }}" 
                                                   class="mr-2 h-4 w-4 text-indigo-600"
                                                   @click="$store.sound.play('click')">
                                            {{ trim($opt) }}
                                        </label>
                                    @endif
                                @endforeach
                            </div>
                        @elseif(($question['Type']['value'] ?? '') == 'fill_in_blank')
                            <div class="mt-2">
                                <input type="text" name="answers[{{ $question['id'] }}]" 
                                       class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 px-3 py-1.5 text-sm border"
                                       placeholder="Type your answer..."
                                       @mouseenter="$store.sound.play('hover')">
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
            
            <button type="submit"
                class="mt-4 w-full py-2 px-4 bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white font-medium rounded-lg text-sm shadow transition flex items-center justify-center"
                @mouseenter="$store.sound.play('hover')"
                @click="$store.sound.play('click')"
            >
                <i class="fas fa-paper-plane mr-2"></i>
                Submit Quiz
            </button>
        </form>
    @else
        <div class="mt-3 p-3 bg-green-50 border border-green-200 rounded-lg text-green-800 text-xs flex justify-between">
            <span><i class="fas fa-check-circle mr-2"></i> Challenge completed!</span>
            <span><i class="fas fa-star mr-1"></i> {{ $quizPointsEarned }} XP</span>
        </div>
    @endif
</div>