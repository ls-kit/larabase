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

<div class="max-w-4xl mx-auto py-8 px-2"
     x-data="soundSystem()"
     x-init="init()"
     :class="{'opacity-90': !$store.sound.tabActive}">
    
    <!-- Minimal Music Toggle Button -->
<!-- Music Toggle Button -->
<button x-data
        @click="$store.sound.toggle()"
        class="fixed bottom-4 right-4 z-50 px-3 py-1.5 rounded-full text-xs font-medium shadow-lg transition-all flex items-center gap-1.5"
        :class="$store.sound.musicPlaying ? 'bg-green-500 text-white hover:bg-green-600' : 'bg-gray-200 text-gray-800 hover:bg-gray-300'"
        title="Background Music">
    <svg x-show="$store.sound.musicPlaying" class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.536 8.464a5 5 0 010 7.072M12 6a7.975 7.975 0 015.657 2.343m0 0a7.975 7.975 0 010 11.314m-11.314 0a7.975 7.975 0 010-11.314m0 0a7.975 7.975 0 015.657-2.343"></path>
    </svg>
    <svg x-show="!$store.sound.musicPlaying" class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.586 15H4a1 1 0 01-1-1v-4a1 1 0 011-1h1.586l4.707-4.707C10.923 3.663 12 4.109 12 5v14c0 .891-1.077 1.337-1.707.707L5.586 15z" clip-rule="evenodd"></path>
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2"></path>
    </svg>
    <span x-text="$store.sound.musicPlaying ? 'MUSIC ON' : 'MUSIC OFF'"></span>
</button>



    <!-- Loading Overlay -->
    <div x-show="loading" x-cloak
         class="fixed inset-0 bg-black/80 flex items-center justify-center z-50"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0">
        <div class="text-center text-white p-8 max-w-md">
            <div class="w-16 h-16 mx-auto mb-4 border-t-4 border-indigo-500 border-solid rounded-full animate-spin"></div>
            <h3 class="text-2xl font-bold mb-4">Unlocking Wisdom...</h3>
            <p class="text-lg mb-6" x-text="loadingMessage"></p>
        </div>
    </div>

    <div class="max-w-4xl mx-auto py-8 px-4">
  <div class="bg-gradient-to-r from-blue-50 via-white to-blue-100 border border-blue-200 rounded-3xl shadow-xl p-8 mb-8 relative overflow-hidden">
    
    <!-- Glow Animation -->
    <div class="absolute -top-10 -left-10 w-40 h-40 bg-blue-300 opacity-20 rounded-full blur-2xl animate-ping"></div>

    <!-- Title -->
    <h1 class="text-4xl font-extrabold text-blue-900 flex items-center gap-3 mb-3">
      <svg class="w-7 h-7 text-blue-600" fill="none" stroke="currentColor" stroke-width="2"
           viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
        <path d="M12 14l9-5-9-5-9 5 9 5z"></path>
        <path d="M12 14l6.16-3.422A12.083 12.083 0 0112 21.5a12.083 12.083 0 01-6.16-10.922L12 14z"></path>
      </svg>
      <span>{{ $course['Title'] }}</span>
      @if($course['Price'] > 0)
        <span class="px-3 py-1 rounded-full bg-orange-100 text-orange-600 text-xs font-bold shadow animate-bounce">৳{{ $course['Price'] }}</span>
      @else
        <span class="px-3 py-1 rounded-full bg-green-100 text-green-700 text-xs font-bold shadow">Free</span>
      @endif
    </h1>

    <!-- Description -->
    <p class="text-lg text-gray-700 leading-relaxed mb-5">
      {{ $course['Description'] ?? 'এই কোর্সটি আপনার জ্ঞান ও দক্ষতা বাড়াতে সহায়তা করবে।' }}
    </p>

    <!-- Highlights -->
    <div class="flex flex-wrap gap-3 items-center text-sm">
      <span class="inline-flex items-center px-3 py-1 bg-green-50 text-green-800 rounded-full font-semibold">
        <svg class="w-4 h-4 mr-1 text-green-600" fill="currentColor" viewBox="0 0 20 20">
          <path d="M9.049 2.927a1 1 0 011.902 0l1.278 3.934h4.14a1 1 0 01.592 1.806l-3.356 2.441 1.278 3.934a1 1 0 01-1.538 1.118L10 13.347l-3.345 2.413a1 1 0 01-1.538-1.118l1.278-3.934L3.04 8.667a1 1 0 01.592-1.806h4.14l1.278-3.934z"/>
        </svg>
        {{ $totalPoints }} Points
      </span>

      <span class="inline-flex items-center px-3 py-1 bg-blue-100 text-blue-800 rounded-full font-medium">
        <svg class="w-4 h-4 mr-1 text-blue-500" fill="none" stroke="currentColor" stroke-width="2"
             viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
          <path d="M12 8v4l3 3"></path>
          <circle cx="12" cy="12" r="10"></circle>
        </svg>
        Self-paced Learning
      </span>

      <span class="inline-flex items-center px-3 py-1 bg-purple-100 text-purple-800 rounded-full font-medium">
        <svg class="w-4 h-4 mr-1 text-purple-600" fill="none" stroke="currentColor" stroke-width="2"
             viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
          <path d="M5 12h14M12 5l7 7-7 7"></path>
        </svg>
        Lifetime Access
      </span>
    </div>
  </div>
</div>


    @if($course['Price'] > 0 && !($userHasAccess ?? false))
  <div class="max-w-lg mx-auto bg-white p-6 rounded-2xl shadow-xl border border-gray-200"
       x-data="{ method: 'Bkash', showForm: {{ $paymentPendingOrRejected ? 'false' : 'true' }} }">
    <h2 class="text-xl font-bold mb-3 text-blue-900">🔓 কোর্স আনলক করুন</h2>

            {{-- <template x-if="!showForm">
                <div class="bg-yellow-100 text-yellow-800 text-sm p-4 rounded-xl">
                    ✅ আপনার পেমেন্ট যাচাই করা হচ্ছে। অনুগ্রহ করে অপেক্ষা করুন। <br>এদিকে আমাদের ফ্রি কোর্স উপভোগ করুন। <a target="_blank" class="text-xs text-blue-700 underline" href="/">Main Page</a>
                    <button @click="showForm = true" class="mt-2 text-xs text-blue-700 underline"
                            @mouseenter="$store.playSound('hover')"
                            @click="$store.playSound('click')">
                        আগের পেমেন্টে ভুল হলে, আবার সঠিকভাবে পেমেন্ট করতে চান?
                    </button>
                </div>
            </template> --}}
            <div x-show="!showForm" class="bg-yellow-100 text-yellow-800 p-4 rounded-xl">
            ✅ আপনার পেমেন্ট যাচাই করা হচ্ছে।
            <button @click="showForm = true" class="mt-2 text-xs text-blue-700 underline">পুনরায় পেমেন্ট করতে চান?</button>
            </div>

            <div x-show="showForm" class="mt-4 space-y-4">
            <form action="{{ route('courses.pay', $course['id']) }}" method="POST" class="space-y-4 mt-4">
                @csrf

                    <div>
                        <label class="block text-sm font-semibold mb-1">📱 পেমেন্ট মাধ্যম:</label>
                        <div class="flex gap-3">
                            @foreach(['Bkash', 'Nagad', 'Rocket'] as $option)
                                <label class="inline-flex items-center cursor-pointer"
                                       @mouseenter="$store.playSound('hover')">
                                    <input type="radio" x-model="method" name="payment_method" value="{{ $option }}" 
                                           class="text-{{ strtolower($option) === 'bkash' ? 'pink' : (strtolower($option) === 'nagad' ? 'yellow' : 'purple') }}-600" 
                                           :checked="method === '{{ $option }}'"
                                           @click="$store.playSound('click')">
                                    <span class="ml-1">{{ $option }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>

                    <!-- Dynamic Guides -->
                    <div class="text-xs text-blue-800 bg-blue-50 p-3 rounded-lg" x-show="method === 'Bkash'">
                        👉 <strong>bKash:</strong> *247# ডায়াল করুন অথবা অ্যাপ থেকে Send Money করুন <strong>01634 616444</strong> (Personal)।<br>
                        পাঠানো নাম্বার ও ট্রানজেকশন আইডি দিন।
                    </div>
                    <div class="text-xs text-yellow-900 bg-yellow-50 p-3 rounded-lg" x-show="method === 'Nagad'">
                        👉 <strong>Nagad:</strong> *167# ডায়াল করুন অথবা Send Money করুন <strong>01634 616444</strong> (Personal)।<br>
                        পাঠানো নাম্বার ও ট্রানজেকশন আইডি দিন।
                    </div>
                    <div class="text-xs text-purple-900 bg-purple-50 p-3 rounded-lg" x-show="method === 'Rocket'">
                        👉 <strong>Rocket:</strong> *322# ডায়াল করুন অথবা Send Money করুন <strong>01634 616444</strong> (Personal)।<br>
                        পাঠানো নাম্বার ও ট্রানজেকশন আইডি দিন।
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-semibold mb-1">📞 যে নম্বর থেকে টাকা পাঠিয়েছেন</label>
                            <input type="text" name="sender_number" required placeholder="01XXXXXXXXX" 
                                   class="form-input w-full rounded-lg border-gray-300 focus:ring focus:border-blue-400"
                                   @focus="$store.playSound('hover')">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold mb-1">🔐 ট্রানজেকশন আইডি <small class="text-xs text-gray-600">(শেষ ৪ ডিজিট)</small>
                            </label>
                            <input type="text" name="transaction_id" required placeholder="যেমনঃ TXN1234ABC" 
                                   class="form-input w-full rounded-lg border-gray-300 focus:ring focus:border-blue-400"
                                   @focus="$store.playSound('hover')">
                        </div>
                    </div>

                    <input type="hidden" name="course_title" value="{{ $course['Title'] }}">
                    <input type="hidden" name="price" value="{{ $course['Price'] }}">

                    <button type="submit" @click="submitPayment" 
                            class="w-full rounded-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 mt-2 shadow-md transition"
                            @mouseenter="$store.playSound('hover')"
                            @click="$store.playSound('click')">
                        ✅ সাবমিট করুন
                    </button>
                    <p class="mt-2 text-xs text-gray-600 text-center">
                        ⏳ এডমিন যাচাই করে আপনাকে কোর্সে প্রবেশের অনুমতি দিবে।<br>
                        জরুরি সাহায্য? কল/হোয়াটসঅ্যাপ: <strong>01876 777411</strong>
                    </p>
                </form>
            </div>
        </div>
    @endif

    @if($course['Price'] == 0 || ($userHasAccess ?? false))
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6">
            <h2 class="text-2xl font-bold text-indigo-700 mb-4 sm:mb-0">Course Adventure</h2>
            <div class="flex space-x-3">
                <div class="bg-indigo-100 text-indigo-800 px-3 py-1.5 rounded-full text-sm flex items-center">
                    <i class="fas fa-trophy text-yellow-500 mr-1.5"></i>
                    <span>XP: {{ $totalPoints ?? 0 }}</span>
                </div>
                <div class="bg-green-100 text-green-800 px-3 py-1.5 rounded-full text-sm flex items-center">
                    <i class="fas fa-check-circle text-green-500 mr-1.5"></i>
                    <span>{{ count($completedModuleIds ?? []) }}/{{ count($modules) }}</span>
                </div>
            </div>
        </div>

        <div class="space-y-4">
            @foreach($modules as $module)
                @php
                    $moduleIndex = $modules->search(fn($m) => $m['id'] == $module['id']);
                    $prevModule = $moduleIndex > 0 ? $modules[$moduleIndex - 1] : null;
                    $prevModuleCompleted = !$prevModule || in_array($prevModule['id'], $completedModuleIds ?? []);
                    $moduleLessonList = $lessons->filter(fn($l) =>
                        isset($l['Parent']) && collect($l['Parent'])->pluck('id')->contains($module['id'])
                    )->values();
                    $moduleCompleted = in_array($module['id'], $completedModuleIds ?? []);
                    $progress = $moduleProgress[$module['id']] ?? 0; 
                @endphp
                
                <div class="bg-white p-5 rounded-xl shadow-sm border-l-4 
                            @if($moduleCompleted) border-green-500
                            @elseif($prevModuleCompleted) border-indigo-500
                            @else border-gray-400 @endif">
                    <div class="flex flex-wrap justify-between items-start">
                        <div class="flex items-center">
                            <div class="w-10 h-10 rounded-full flex items-center justify-center mr-3
                                @if($moduleCompleted) bg-green-100 text-green-600
                                @elseif($prevModuleCompleted) bg-indigo-100 text-indigo-600
                                @else bg-gray-200 text-gray-500 @endif">
                                <i class="fas @if($moduleCompleted) fa-check @elseif($prevModuleCompleted) fa-play @else fa-lock @endif"></i>
                            </div>
                            <div>
                                <h3 class="font-bold text-gray-800 flex items-center">
                                    Module {{ $moduleIndex + 1 }}: {{ $module['Title'] }}
                                </h3>
                                <p class="text-sm text-gray-600 mt-1">{{ $module['Description'] ?? 'Explore this module' }}</p>
                            </div>
                        </div>
                        
                        <div class="flex items-center space-x-3 mt-3 sm:mt-0">
                            <div class="w-8 h-8 relative">
                                <svg class="w-8 h-8" viewBox="0 0 36 36">
                                    <circle cx="18" cy="18" r="15.9155" class="text-gray-200" fill="none" stroke-width="2"/>
                                    <circle class="progress-ring" fill="none" stroke="currentColor" stroke-width="2" 
                                            stroke-dasharray="100, 100" stroke-dashoffset="{{ 100 - $progress }}" 
                                            cx="18" cy="18" r="15.9155"
                                            @if($moduleCompleted) class="text-green-500" 
                                            @elseif($prevModuleCompleted) class="text-indigo-500"
                                            @else class="text-gray-400" @endif/>
                                </svg>
                                <span class="absolute inset-0 flex items-center justify-center text-xs font-bold">
                                    {{ $progress }}%
                                </span>
                            </div>
                            @if(!$prevModuleCompleted)
                                <span class="px-3 py-1 bg-yellow-100 text-yellow-800 text-xs rounded-full">
                                    <i class="fas fa-lock mr-1"></i> Locked
                                </span>
                            @elseif($moduleCompleted)
                                <span class="px-3 py-1 bg-green-100 text-green-800 text-xs rounded-full">
                                    <i class="fas fa-check mr-1"></i> Completed
                                </span>
                            @else
                                <span class="px-3 py-1 bg-blue-100 text-blue-800 text-xs rounded-full">
                                    <i class="fas fa-play mr-1"></i> Available
                                </span>
                            @endif
                        </div>
                    </div>
                    
                    @if(!$prevModuleCompleted)
                        <div class="mt-4 p-3 bg-yellow-50 border border-yellow-200 rounded-lg text-yellow-800 text-sm">
                            <i class="fas fa-info-circle mr-2"></i>
                            Complete the previous module to unlock this adventure!
                        </div>
                    @else
                        <div class="mt-4">
                            <div class="flex items-center mb-3">
                                <div class="flex-grow bg-gray-200 rounded-full h-2">
                                    <div class="bg-indigo-600 h-2 rounded-full" 
                                        style="width: {{ $progress }}%"></div>
                                </div>
                                <span class="ml-3 text-xs font-medium text-gray-700">
                                    {{ $progress }}% Complete
                                </span>
                            </div>
                            
                            <ul class="space-y-3">
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
                                        'lessonProgressData' => $lessonProgressData,
                                    ])
                                @endforeach
                            </ul>
                        </div>
                    @endif
                </div>
            @endforeach
        </div>
    @endif
</div>

<!-- Include Howler.js for sound management -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/howler/2.2.3/howler.min.js"></script>

<script>
    // Centralized sound system for Alpine.js
    // Centralized sound system for Alpine.js
document.addEventListener('alpine:init', () => {
    Alpine.store('sound', {
        soundEnabled: true,
        musicPlaying: true,
        tabActive: true, // Track if tab is active
        sounds: {
            hover: null,
            click: null,
            success: null,
            error: null,
            unlock: null,
            toggle: null,
            music: null
        },
        
        init() {
            // Stop any existing music first
            if (this.sounds.music && this.sounds.music.playing()) {
                this.sounds.music.stop();
            }

            // Load sound settings from localStorage
            this.soundEnabled = localStorage.getItem('soundEnabled') !== null 
                                ? localStorage.getItem('soundEnabled') === 'true' 
                                : true;
            
            // Initialize sounds
            this.sounds.hover = new Howl({ src: ['{{ asset("sounds/hover.mp3") }}'] });
            this.sounds.click = new Howl({ src: ['{{ asset("sounds/click.mp3") }}'] });
            this.sounds.success = new Howl({ src: ['{{ asset("sounds/success.mp3") }}'] });
            this.sounds.error = new Howl({ src: ['{{ asset("sounds/error.mp3") }}'] });
            this.sounds.unlock = new Howl({ src: ['{{ asset("sounds/unlock.mp3") }}'] });
            this.sounds.toggle = new Howl({ src: ['{{ asset("sounds/toggle.mp3") }}'] });
            this.sounds.music = new Howl({ 
                src: ['{{ asset("sounds/inspirational.mp3") }}'], 
                loop: true,
                volume: 0.2,
                onplay: () => this.musicPlaying = true,
                onstop: () => this.musicPlaying = false,
                // onend: () => this.musicPlaying = false
            });
            
            // Set initial volume
            Howler.volume(this.soundEnabled ? 0.7 : 0);
            
            // Setup visibility change listener
            document.addEventListener('visibilitychange', () => {
                this.tabActive = document.visibilityState === 'visible';
                
                if (this.tabActive) {
                    // Tab became active - resume music if it was playing
                    if (this.soundEnabled && this.musicPlaying && !this.sounds.music.playing()) {
                        this.sounds.music.play();
                    }
                } else {
                    // Tab became inactive - pause music
                    if (this.sounds.music.playing()) {
                        this.sounds.music.pause();
                    }
                }
            });
            
            // Try to start music after user interaction
            const startMusic = () => {
                if (this.soundEnabled && !this.sounds.music.playing() && this.tabActive) {
                    this.play('music');
                }
                document.removeEventListener('click', startMusic);
            };
            document.addEventListener('click', startMusic);
        },
        
        toggle() {
        // Toggle the sound state
        this.soundEnabled = !this.soundEnabled;
        this.musicPlaying = this.soundEnabled;
        
        // Update volume for all sounds
        Howler.volume(this.soundEnabled ? 0.7 : 0);
        
        // Handle music playback
        if (this.soundEnabled) {
            // Play toggle sound effect
            this.play('toggle');
            
            // Start music if not already playing and tab is active
            if (!this.sounds.music.playing() && this.tabActive) {
                this.sounds.music.play();
            }
        } else {
            // Pause music if playing
            if (this.sounds.music.playing()) {
                this.sounds.music.pause();
            }
        }
        
        // Save preference
        localStorage.setItem('soundEnabled', this.soundEnabled);
    },
        
        
        play(type) {

            if (type === 'music') {
                // Don't play if already playing
                if (this.sounds.music.playing()) return;
                
                // Stop any existing instance first
                this.sounds.music.stop();
                this.sounds.music.play();
            }

            if (!this.soundEnabled && type !== 'toggle') return;
            
            // Don't play background music if the tab is not active
            if (type === 'music' && this.sounds.music.playing()) return;
            // if (type === 'music' && !this.tabActive) {
            //     return;
            // }
            if (this.sounds[type]) {
                this.sounds[type].play();
            }
        }
    });
    
    // Loading management
    Alpine.store('loading', {
        loading: false,
        message: "Great things take time! Your results are being calculated.",
        
        show(msg) {
            this.loading = true;
            this.message = msg || this.message;
            
            // Play music if not already playing AND tab is active
            if (!Alpine.store('sound').sounds.music.playing() && 
                Alpine.store('sound').tabActive) {
                Alpine.store('sound').play('music');
            }
        },
        
        hide() {
            this.loading = false;
        }
    });
});
    
    // Component initialization
    function soundSystem() {
        return {
            soundEnabled: Alpine.store('sound').soundEnabled,
            musicPlaying: Alpine.store('sound').musicPlaying,
            loading: Alpine.store('loading').loading,
            loadingMessage: Alpine.store('loading').message,
            
            init() {
                // Initialize the sound system
                Alpine.store('sound').init();
                
                // Add hover sounds to interactive elements
                setTimeout(() => {
                    document.querySelectorAll('button, a, .hover-sound').forEach(el => {
                        el.addEventListener('mouseenter', () => {
                            Alpine.store('sound').play('hover');
                        });
                    });
                }, 500);
            },
            
            toggleSound() {
                Alpine.store('sound').toggle();
                this.soundEnabled = Alpine.store('sound').soundEnabled;
                this.musicPlaying = Alpine.store('sound').musicPlaying;
            },
            
            showLoading(message) {
                Alpine.store('loading').show(message);
                this.loading = true;
                this.loadingMessage = Alpine.store('loading').message;
            },
            
            hideLoading() {
                Alpine.store('loading').hide();
                this.loading = false;
            }
        }
    }
    
    // Quiz submission handling
    document.querySelectorAll('.quiz-form').forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Show loading overlay
            Alpine.store('loading').show();
            
            const formData = new FormData(this);
            
            fetch(this.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            })
            .then(response => response.json())
            .then(data => {
                // Hide loading overlay
                Alpine.store('loading').hide();
                
                if (data.success) {
                    Alpine.store('sound').play('success');
                    showFeedback(true, data.message);
                } else {
                    Alpine.store('sound').play('error');
                    showFeedback(false, data.message);
                }
                
                // Refresh page after delay
                setTimeout(() => {
                    window.location.reload();
                }, 3000);
            })
            .catch(error => {
                // Hide loading overlay
                Alpine.store('loading').hide();
                Alpine.store('sound').play('error');
                showFeedback(false, "Something went wrong. Please try again.");
            });
        });
    });
    
    function showFeedback(success, message) {
        // Create feedback element
        const feedback = document.createElement('div');
        feedback.className = `fixed top-4 left-1/2 transform -translate-x-1/2 z-50 px-6 py-4 rounded-lg shadow-lg text-white font-bold animate-fade-in ${
            success ? 'bg-green-500' : 'bg-red-500'
        }`;
        feedback.innerHTML = `
            <div class="flex items-center">
                <i class="fas ${success ? 'fa-check-circle' : 'fa-exclamation-circle'} mr-3 text-xl"></i>
                <span>${message}</span>
            </div>
        `;
        
        document.body.appendChild(feedback);
        
        // Remove after delay
        setTimeout(() => {
            feedback.classList.add('animate-fade-out');
            setTimeout(() => feedback.remove(), 500);
        }, 3000);
    }
    
    // Add animation styles
    const style = document.createElement('style');
    style.textContent = `
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        @keyframes fadeOut {
            from { opacity: 1; transform: translateY(0); }
            to { opacity: 0; transform: translateY(-10px); }
        }
        .animate-fade-in {
            animation: fadeIn 0.3s ease-out forwards;
        }
        .animate-fade-out {
            animation: fadeOut 0.3s ease-out forwards;
        }
        .progress-ring {
            transform: rotate(-90deg);
            transform-origin: 50% 50%;
        }
        .sound-wave {
            display: flex;
            justify-content: space-between;
            width: 30px;
            height: 20px;
            margin: 0 auto;
        }
        .sound-wave span {
            display: block;
            width: 3px;
            height: 100%;
            background-color: currentColor;
            border-radius: 3px;
            animation: sound-wave-animation 1.2s infinite ease-in-out;
        }
        .sound-wave span:nth-child(1) { animation-delay: 0s; }
        .sound-wave span:nth-child(2) { animation-delay: 0.2s; }
        .sound-wave span:nth-child(3) { animation-delay: 0.4s; }
        .sound-wave span:nth-child(4) { animation-delay: 0.6s; }
        .sound-wave span:nth-child(5) { animation-delay: 0.8s; }
        
        @keyframes sound-wave-animation {
            0%, 100% { transform: scaleY(0.3); }
            50% { transform: scaleY(1); }
        }
        .animate-ping-slow {
            animation: ping 3s cubic-bezier(0, 0, 0.2, 1) infinite;
        }
        @keyframes ping {
            0% { transform: scale(0.8); opacity: 0.8; }
            75%, 100% { transform: scale(2.5); opacity: 0; }
        }
        [x-cloak] { display: none !important; }
    `;
    document.head.appendChild(style);
</script>

@endsection