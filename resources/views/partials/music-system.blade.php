{{-- Not using yet --}}

<script src="https://cdnjs.cloudflare.com/ajax/libs/howler/2.2.3/howler.min.js"></script>

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

<script>
// Centralized sound system for Alpine.js
document.addEventListener('alpine:init', () => {
    if (!Alpine.store('sound')) {
        Alpine.store('sound', {
            soundEnabled: true,
            musicPlaying: false, // Start as false, will be set true after init
            tabActive: true,
            windowFocused: true,
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
                // Load sound settings
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
                    html5: true,
                    onplay: () => {
                        this.musicPlaying = true;
                        console.log('Music started');
                    },
                    onpause: () => {
                        this.musicPlaying = false;
                        console.log('Music paused');
                    }
                });
                
                Howler.volume(this.soundEnabled ? 0.7 : 0);
                
                // Enhanced visibility and focus handling
                const handleStateChange = () => {
                    const isTabActive = document.visibilityState === 'visible';
                    const isWindowFocused = document.hasFocus();
                    this.tabActive = isTabActive;
                    this.windowFocused = isWindowFocused;
                    
                    console.log('State changed - Tab active:', isTabActive, 'Window focused:', isWindowFocused);
                    
                    if (isTabActive && isWindowFocused && this.soundEnabled && this.musicPlaying) {
                        if (!this.sounds.music.playing()) {
                            console.log('Resuming music');
                            this.sounds.music.play();
                        }
                    } else {
                        if (this.sounds.music.playing()) {
                            console.log('Pausing music');
                            this.sounds.music.pause();
                        }
                    }
                };

                // Setup event listeners
                document.addEventListener('visibilitychange', handleStateChange);
                window.addEventListener('focus', handleStateChange);
                window.addEventListener('blur', handleStateChange);
                
                // Initial state check
                handleStateChange();
                
                // Start music after first interaction
                const startMusic = () => {
                    if (this.soundEnabled && !this.sounds.music.playing()) {
                        handleStateChange();
                    }
                    document.removeEventListener('click', startMusic);
                };
                
                // For initial load - wait for user interaction
                if (this.soundEnabled) {
                    document.addEventListener('click', startMusic);
                }
            },
            
            toggle() {
                this.soundEnabled = !this.soundEnabled;
                this.musicPlaying = this.soundEnabled;
                localStorage.setItem('soundEnabled', this.soundEnabled);
                Howler.volume(this.soundEnabled ? 0.7 : 0);
                
                if (this.soundEnabled) {
                    this.play('toggle');
                    if (document.visibilityState === 'visible' && document.hasFocus()) {
                        this.sounds.music.play();
                    }
                } else {
                    this.sounds.music.pause();
                }
            },
            
            play(type) {
                if (type === 'music') {
                    if (!this.sounds.music.playing() && 
                        this.soundEnabled && 
                        document.visibilityState === 'visible' && 
                        document.hasFocus()) {
                        this.sounds.music.play();
                    }
                    return;
                }
                
                if (!this.soundEnabled && type !== 'toggle') return;
                
                if (this.sounds[type]) {
                    this.sounds[type].play();
                }
            }
        });

        // Initialize the sound system
        Alpine.store('sound').init();
    }
});

// Sound system component
Alpine.data('soundSystem', () => ({
    soundEnabled: Alpine.store('sound').soundEnabled,
    musicPlaying: Alpine.store('sound').musicPlaying,
    
    init() {
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
    }
}));
</script>