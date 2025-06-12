@extends('layouts.public')
@section('content')


@include('partials.auth-modal')


  
<div class="bg-gradient-to-br from-primary-dark via-secondary to-primary font-sans">
<!-- Hero Section: Earn While You Learn -->
<!-- Hero Section: Earn While You Learn -->
<section class="relative overflow-hidden pt-12 pb-16 sm:pt-16 sm:pb-24 md:pt-20 md:pb-32 bg-gradient-to-br from-primary-dark to-primary" data-aos="fade-in">
  <!-- Parallax Particles -->
  <div id="particles" class="absolute inset-0 opacity-20 pointer-events-none animate-[moveBg_20s_linear_infinite]"></div>

  <!-- Swipe Hint for Mobile -->
  <div class="absolute bottom-6 left-1/2 transform -translate-x-1/2 text-neon animate-bounce " data-aos="fade-up" data-aos-anchor-placement="bottom-bottom">
    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
    </svg>
  </div>

  <div class="container mx-auto px-4 relative z-10 text-center">
    <nav class="flex justify-between items-center mb-8 sm:mb-12" data-aos="fade-down" data-aos-duration="800">
      <!-- Logo -->
      <div class="flex items-center gap-2">
        <div class="w-8 h-8 bg-highlight rounded-full animate-pulse"></div>
        <span class="text-2xl font-bold text-neon">ChestaAcademy</span>
      </div>
      <!-- Trigger Button -->
      <button class="auth-trigger bg-highlight/20 text-neon px-6 py-2 rounded-full hover:bg-highlight/30 transition-all" data-aos="fade-up" data-aos-delay="200">
        Start Free Trial
      </button>
    </nav>

    <!-- Headline -->
    <h1 class="text-4xl sm:text-5xl md:text-7xl font-extrabold mb-4 leading-tight" data-aos="fade-up" data-aos-delay="400">
      <span class="bg-clip-text text-transparent bg-gradient-to-r from-accent to-highlight animate-[textShimmer_4s_ease_infinite]">Earn</span>
      While You
      <span class="bg-clip-text text-transparent bg-gradient-to-r from-accent to-highlight animate-[textShimmer_4s_ease_infinite]">Learn</span>
    </h1>

    <!-- Subtitles -->
    <p class="text-base sm:text-lg lg:text-xl text-gray-200 mb-4 max-w-xl mx-auto" data-aos="fade-up" data-aos-delay="600">
      Transform your screen time into earning power…
    </p>
    <p class="text-base sm:text-lg text-gray-300 mb-8" data-aos="fade-up" data-aos-delay="700">
      University Students Earned Average <span class="text-highlight font-semibold">$287</span> in First Month!
    </p>

    <!-- Primary CTA -->
    <div class="flex justify-center mb-8" data-aos="zoom-in" data-aos-delay="800">
      <button class="hero-cta auth-trigger w-full max-w-xs bg-highlight text-primary-dark px-6 py-4 rounded-full text-lg font-semibold shadow-lg hover:shadow-2xl transition-transform transform hover:scale-105">
        🎓 Start Student Program (Free)
      </button>
    </div>

<button onclick="document.getElementById('authModal').classList.remove('hidden')" class="bg-indigo-600 text-white px-4 py-2 rounded">
    Login/Register
</button>
<a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
    Logout
</a>
<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
    @csrf
</form>



<script>
function switchTab(tab) {
    document.getElementById('loginTab').classList.add('hidden');
    document.getElementById('registerTab').classList.add('hidden');
    document.getElementById(tab).classList.remove('hidden');

    document.getElementById('loginTabBtn').classList.remove('border-blue-500', 'text-black');
    document.getElementById('registerTabBtn').classList.remove('border-blue-500', 'text-black');

    if (tab === 'loginTab') {
        document.getElementById('loginTabBtn').classList.add('border-blue-500', 'text-black');
        document.getElementById('registerTabBtn').classList.add('text-gray-500');
    } else {
        document.getElementById('registerTabBtn').classList.add('border-blue-500', 'text-black');
        document.getElementById('loginTabBtn').classList.add('text-gray-500');
    }
}
</script>



    <!-- Next Achievement -->
    <div class="mt-6 flex justify-center" data-aos="fade-up" data-aos-delay="900">
      <div class="bg-white/5 p-4 rounded-xl backdrop-blur-sm ">
        <p class="text-neon font-medium">Next Achievement Unlock:</p>
        <div class="flex items-center gap-2 mt-2">
          <div class="w-8 h-8 bg-highlight rounded-full flex items-center justify-center">🔓</div>
          <span class="text-white">Earn Your First $100!</span>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Tailwind Custom Animations -->
<style>
@keyframes moveBg { from { transform: translateY(0); } to { transform: translateY(-50px); } }
@keyframes textShimmer { 0%,100% { background-position: 0% 50%; } 50% { background-position: 100% 50%; } }
.animate-\[moveBg_20s_linear_infinite\] { animation: moveBg 20s linear infinite; }
.animate-\[textShimmer_4s_ease_infinite\] { background-size: 200% 200%; animation: textShimmer 4s ease infinite; }
</style>
<style>
@keyframes moveBg { from { transform: translateY(0); } to { transform: translateY(-50px); } }
@keyframes textShimmer { 0%,100% { background-position: 0% 50%; } 50% { background-position: 100% 50%; } }
.animate-\[moveBg_20s_linear_infinite\] { animation: moveBg 20s linear infinite; }
.animate-\[textShimmer_4s_ease_infinite\] { background-size: 200% 200%; animation: textShimmer 4s ease infinite; }
</style>



   <!-- Top Freelance Masters Section -->
  <section class="py-16 bg-black/20 backdrop-blur-lg">
    <div class="container mx-auto px-4">
      <h2 class="text-2xl md:text-3xl font-bold text-center text-neon mb-6">Top Rated Mentors</h2>
      <p class="text-center text-gray-300 mb-8">Learn from instructors ranked highest across major freelance platforms</p>
      <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-5 gap-4">
        <!-- Mentor Card -->
        <div class="auth-trigger relative bg-white/5 p-4 rounded-xl backdrop-blur-sm hover:bg-white/10 transition-all group" data-aos="fade-up">
          <img src="mentor1.jpg" alt="" class="w-16 h-16 rounded-full mx-auto mb-2">
          <h3 class="text-lg font-bold text-neon mb-1 text-center">Alex Freelancer</h3>
          <p class="text-gray-400 text-center text-sm mb-3">Top 1% on Upwork</p>
          <div class="flex justify-center gap-1 mb-3">
            <span class="text-xs bg-accent/20 text-accent px-1.5 py-0.5 rounded">⭐ 4.9</span>
            <span class="text-xs bg-highlight/20 text-highlight px-1.5 py-0.5 rounded">📊 2k+</span>
          </div>
          <button class="w-full bg-highlight text-primary-dark py-1.5 rounded-full text-sm font-medium hover:shadow-neon transition-all">
            View Profile
          </button>
          <!-- Pro-only overlay -->
          <div class="absolute inset-0 bg-black/70 flex items-center justify-center rounded-xl opacity-0 group-hover:opacity-100 transition-opacity">
            <span class="text-white font-bold text-sm">Join Pro to Unlock</span>
          </div>
        </div>
        <!-- Mentor Card -->
        <div class="auth-trigger relative bg-white/5 p-4 rounded-xl backdrop-blur-sm hover:bg-white/10 transition-all group" data-aos="fade-up" data-aos-delay="100">
          <img src="mentor2.jpg" alt="" class="w-16 h-16 rounded-full mx-auto mb-2">
          <h3 class="text-lg font-bold text-neon mb-1 text-center">Sara Designer</h3>
          <p class="text-gray-400 text-center text-sm mb-3">Top on Fiverr</p>
          <div class="flex justify-center gap-1 mb-3">
            <span class="text-xs bg-accent/20 text-accent px-1.5 py-0.5 rounded">⭐ 4.8</span>
            <span class="text-xs bg-highlight/20 text-highlight px-1.5 py-0.5 rounded">📊 1.5k</span>
          </div>
          <button class="w-full bg-highlight text-primary-dark py-1.5 rounded-full text-sm font-medium hover:shadow-neon transition-all">
            View Profile
          </button>
          <div class="absolute inset-0 bg-black/70 flex items-center justify-center rounded-xl opacity-0 group-hover:opacity-100 transition-opacity">
            <span class="text-white font-bold text-sm">Join Pro to Unlock</span>
          </div>
        </div>
        <!-- Mentor Card -->
        <div class="auth-trigger relative bg-white/5 p-4 rounded-xl backdrop-blur-sm hover:bg-white/10 transition-all group" data-aos="fade-up" data-aos-delay="200">
          <img src="mentor3.jpg" alt="" class="w-16 h-16 rounded-full mx-auto mb-2">
          <h3 class="text-lg font-bold text-neon mb-1 text-center">Rahim Developer</h3>
          <p class="text-gray-400 text-center text-sm mb-3">Freelancer Top Rated</p>
          <div class="flex justify-center gap-1 mb-3">
            <span class="text-xs bg-accent/20 text-accent px-1.5 py-0.5 rounded">⭐ 4.9</span>
            <span class="text-xs bg-highlight/20 text-highlight px-1.5 py-0.5 rounded">📊 3k+</span>
          </div>
          <button class="w-full bg-highlight text-primary-dark py-1.5 rounded-full text-sm font-medium hover:shadow-neon transition-all">
            View Profile
          </button>
          <div class="absolute inset-0 bg-black/70 flex items-center justify-center rounded-xl opacity-0 group-hover:opacity-100 transition-opacity">
            <span class="text-white font-bold text-sm">Join Pro to Unlock</span>
          </div>
        </div>
        <!-- Additional cards... up to 20 -->
      </div>
    </div>
  </section>



<div class="max-w-7xl mx-auto px-4 py-12">
    <!-- Section Header -->
    <div class="text-center mb-12">
        <h2 class="text-2xl md:text-3xl font-bold text-center text-neon mb-6">Our Featured Courses</h2>
        <p class="text-center text-gray-300 max-w-2xl mx-auto mb-12">
            Enhance your skills with our carefully designed courses
        </p>
    </div>

    <!-- Courses Grid -->
    <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 justify-items-center">
        @foreach($courses as $course)
        <div class="w-full max-w-xs bg-white rounded-lg shadow-md overflow-hidden transition-all duration-300 hover:shadow-lg hover:-translate-y-1 border-l-4" style="border-color: #ee9b00;">
            <div class="h-full flex flex-col">
                <!-- Course Image -->
                <div class="h-40 flex items-center justify-center" style="background-color: #d4f1f4;">
                    <svg class="w-12 h-12" style="color: #0a9396;" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                    </svg>
                </div>
                
                <!-- Course Content -->
                <div class="p-4 flex-grow">
                    <div class="flex justify-between items-start">
                        <div>
                            <span class="inline-block px-2 py-1 rounded-full text-xs font-semibold mb-2" style="background-color: #94d2bd; color: #003f43;">
                                {{ $course['Price'] > 0 ? 'Paid' : 'Free' }}
                            </span>
                            <a target="_blank" href="{{ url('/courses/'.$course['id']) }}" class="text-lg font-bold hover:underline block mb-1" style="color: #005f73;">
                                {{ $course['Title'] }}
                            </a>
                        </div>
                    </div>
                    
                    <p class="text-gray-600 text-sm mb-3 line-clamp-2">{{ $course['Content'] }}</p>
                    
                    <div class="flex items-center text-xs mb-2">
                        <svg class="w-3 h-3 mr-1" style="color: #ee9b00;" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span>Quiz: {{ $course['Has Quiz'] ? 'Yes' : 'No' }}</span>
                    </div>
                </div>
                
                <!-- Footer -->
                <div class="px-4 pb-4">
                    <div class="flex items-center justify-between">
                        <span class="text-lg font-bold" style="color: #005f73;">
                            {{ $course['Price'] > 0 ? '$'.$course['Price'] : 'Free' }}
                        </span>
                        <a href="{{ url('/courses/'.$course['id']) }}" class="px-3 py-1.5 rounded-lg text-xs font-medium transition-colors duration-300" style="background-color: #ee9b00; color: white; hover:bg-opacity-90">
                            {{ $course['Price'] > 0 ? 'Enroll' : 'Start' }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <!-- View All Button -->
    @if(count($courses) > 4)
    <div class="text-center mt-10">
        <a href="#" class="inline-block px-6 py-2 rounded-lg font-medium transition-colors duration-300" style="background-color: #005f73; color: white; hover:bg-opacity-90">
            View All Courses
        </a>
    </div>
    @endif
</div>







 <section class="py-16 bg-gradient-to-b from-primary-dark to-primary" id="course-roadmap">
  <!-- Animated background elements -->
  <div class="absolute inset-0 overflow-hidden opacity-10">
    <div class="absolute right-10 top-1/4 w-32 h-32 bg-neon rounded-full blur-3xl animate-pulse"></div>
  </div>

  <div class="container mx-auto px-4 relative">
    <h2 class="text-4xl font-bold text-center text-white mb-4">
      Your <span class="text-highlight">Earning</span> Adventure
    </h2>
    <p class="text-center text-gray-300 max-w-2xl mx-auto mb-12">
      Every step unlocks new rewards in your SkillForge dashboard
    </p>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-12">
      <!-- Step 1 - Learn -->
      <div class="bg-white/5 rounded-xl p-6 border border-accent/20 hover:border-accent/50 transition-all group">
        <div class="flex items-center gap-4 mb-4">
          <div class="w-12 h-12 bg-accent/10 rounded-full flex items-center justify-center text-2xl text-accent">
            1
          </div>
          <h3 class="text-xl font-bold text-white">Learn Basics</h3>
        </div>
        <ul class="space-y-3 text-gray-300 mb-6">
          <li class="flex items-start gap-2">
            <span class="text-accent mt-0.5">✓</span>
            <span>Free starter courses</span>
          </li>
          <li class="flex items-start gap-2">
            <span class="text-accent mt-0.5">✓</span>
            <span>Earn <strong class="text-highlight">"Newbie" badge</strong></span>
          </li>
        </ul>
        <div class="bg-black/20 p-3 rounded-lg border border-dashed border-accent/30">
          <p class="text-sm text-accent flex items-center gap-2">
            <span class="text-xs">🏆</span> 
            <span>Unlocks in dashboard:</span>
          </p>
          <p class="text-white text-sm mt-1">+100 XP • Starter Challenges</p>
        </div>
      </div>

      <!-- Step 2 - Earn -->
      <div class="bg-white/5 rounded-xl p-6 border border-highlight/20 hover:border-highlight/50 transition-all group">
        <div class="flex items-center gap-4 mb-4">
          <div class="w-12 h-12 bg-highlight/10 rounded-full flex items-center justify-center text-2xl text-highlight">
            2
          </div>
          <h3 class="text-xl font-bold text-white">Earn While Learning</h3>
        </div>
        <ul class="space-y-3 text-gray-300 mb-6">
          <li class="flex items-start gap-2">
            <span class="text-highlight mt-0.5">৳</span>
            <span>Paid micro-projects</span>
          </li>
          <li class="flex items-start gap-2">
            <span class="text-highlight mt-0.5">★</span>
            <span>Unlock <strong class="text-highlight">"Earner" status</strong></span>
          </li>
        </ul>
        <div class="bg-black/20 p-3 rounded-lg border border-dashed border-highlight/30">
          <p class="text-sm text-highlight flex items-center gap-2">
            <span class="text-xs">💸</span> 
            <span>Unlocks in dashboard:</span>
          </p>
          <p class="text-white text-sm mt-1">Withdraw Earnings • Client Board</p>
        </div>
      </div>

      <!-- Step 3 - Grow -->
      <div class="bg-white/5 rounded-xl p-6 border border-neon/20 hover:border-neon/50 transition-all group">
        <div class="flex items-center gap-4 mb-4">
          <div class="w-12 h-12 bg-neon/10 rounded-full flex items-center justify-center text-2xl text-neon">
            3
          </div>
          <h3 class="text-xl font-bold text-white">Grow Your Business</h3>
        </div>
        <ul class="space-y-3 text-gray-300 mb-6">
          <li class="flex items-start gap-2">
            <span class="text-neon mt-0.5">🚀</span>
            <span>Premium client projects</span>
          </li>
          <li class="flex items-start gap-2">
            <span class="text-neon mt-0.5">🏅</span>
            <span>Achieve <strong class="text-neon">"Pro" rank</strong></span>
          </li>
        </ul>
        <div class="bg-black/20 p-3 rounded-lg border border-dashed border-neon/30">
          <p class="text-sm text-neon flex items-center gap-2">
            <span class="text-xs">📈</span> 
            <span>Unlocks in dashboard:</span>
          </p>
          <p class="text-white text-sm mt-1">Business Tools • Analytics</p>
        </div>
      </div>
    </div>

    <!-- Dashboard Preview CTA -->
    <div class="text-center">
      <button class="auth-trigger bg-highlight hover:bg-yellow-600 text-primary-dark font-bold py-3 px-8 rounded-full inline-flex items-center gap-2 transition-all mb-3">
        See Your Dashboard
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
          <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-8.707l-3-3a1 1 0 00-1.414 1.414L10.586 9H7a1 1 0 100 2h3.586l-1.293 1.293a1 1 0 101.414 1.414l3-3a1 1 0 000-1.414z" clip-rule="evenodd" />
        </svg>
      </button>
      <p class="text-gray-400 text-sm">
        Already <span class="text-highlight">12,500+</span> students earning through SkillForge
      </p>
    </div>
  </div>
</section> 

 
  

  <!-- Secret Unlockables Teaser -->
  <section class="py-16">
    <div class="container mx-auto px-4 text-center">
      <h2 class="text-3xl font-bold text-neon mb-4">Unlock Pro Secrets</h2>
      <p class="text-gray-300 mb-8">Exclusive tools, mentor chats, and premium micro-tasks available after login</p>
      <button class="auth-trigger bg-highlight text-primary-dark px-6 py-3 rounded-full font-semibold hover:shadow-neon transition-all">
        Log In to Reveal 🔓
      </button>
    </div>
  </section>

  <!-- Live Workshops & Community Events -->
  <section class="py-16 bg-black/20 backdrop-blur-sm">
    <div class="container mx-auto px-4">
      <h2 class="text-3xl font-bold text-center text-neon mb-8">Upcoming Live Events</h2>
      <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white/5 p-6 rounded-2xl backdrop-blur-sm hover:bg-white/10 transition-all" data-aos="fade-up">
          <h3 class="text-xl font-semibold text-neon mb-2">Code Jam #5</h3>
          <p class="text-gray-300 mb-4">Jun 5, 2025 – Live React sprint</p>
          <button class="auth-trigger bg-highlight text-primary-dark px-4 py-2 rounded-full text-sm hover:shadow-neon transition-all">
            RSVP Now
          </button>
        </div>
        <div class="bg-white/5 p-6 rounded-2xl backdrop-blur-sm hover:bg-white/10 transition-all" data-aos="fade-up" data-aos-delay="100">
          <h3 class="text-xl font-semibold text-neon mb-2">Freelance AMA</h3>
          <p class="text-gray-300 mb-4">Jun 12, 2025 – Ask top mentors</p>
          <button class="auth-trigger bg-highlight text-primary-dark px-4 py-2 rounded-full text-sm hover:shadow-neon transition-all">
            RSVP Now
          </button>
        </div>
        <div class="bg-white/5 p-6 rounded-2xl backdrop-blur-sm hover:bg-white/10 transition-all" data-aos="fade-up" data-aos-delay="200">
          <h3 class="text-xl font-semibold text-neon mb-2">Hackathon Prep</h3>
          <p class="text-gray-300 mb-4">Jun 19, 2025 – Build with peers</p>
          <button class="auth-trigger bg-highlight text-primary-dark px-4 py-2 rounded-full text-sm hover:shadow-neon transition-all">
            RSVP Now
          </button>
        </div>
      </div>
    </div>
  </section>



  <!-- Partner & Platform Logos -->
  <section class="py-16 bg-black/20 backdrop-blur-sm">
    <div class="container mx-auto px-4">
      <h2 class="text-2xl font-bold text-center text-neon mb-8">Trusted By</h2>
      <div class="flex flex-wrap justify-center items-center gap-8">
        <img src="logo-upwork.png" class="h-8 opacity-60 hover:opacity-100 transition" alt="Upwork">
        <img src="logo-fiverr.png" class="h-8 opacity-60 hover:opacity-100 transition" alt="Fiverr">
        <img src="logo-freelancer.png" class="h-8 opacity-60 hover:opacity-100 transition" alt="Freelancer">
        <img src="logo-github.png" class="h-8 opacity-60 hover:opacity-100 transition" alt="GitHub">
      </div>
    </div>
  </section>





  <!-- Secret Features Grid -->
  <!-- <section class="py-20 bg-black/20 backdrop-blur-lg">
    <div class="container mx-auto px-4">
      <h2 class="text-3xl font-bold text-center text-neon mb-12">
        Hidden in Plain Sight
        <span class="text-sm block mt-2 text-gray-300">(Our Secret Weapons)</span>
      </h2>
      <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        <div class="feature-card group relative bg-white/5 rounded-2xl p-6 backdrop-blur-sm hover:bg-white/10 transition-all cursor-pointer">
          <div class="text-highlight text-4xl mb-4">🎮</div>
          <h3 class="text-xl font-bold text-neon mb-2">Earn-As-You-Learn</h3>
          <p class="text-gray-300">Complete challenges to unlock real micro-projects that pay instantly</p>
          <div class="hidden group-hover:block absolute bottom-4 right-4 text-highlight">💰 +$5.00</div>
        </div>
        <div class="feature-card relative bg-white/5 rounded-2xl p-6 backdrop-blur-sm overflow-hidden">
          <div class="text-highlight text-4xl mb-4">📈</div>
          <h3 class="text-xl font-bold text-neon mb-2">AI-Powered Hustle Coach</h3>
          <p class="text-gray-300 mb-4">Our algorithm finds money-making opportunities in your code</p>
          <div class="h-1 bg-white/10 rounded-full">
            <div class="h-full bg-highlight w-3/4 transition-all duration-1000"></div>
          </div>
        </div>
        <div class="feature-card relative bg-white/5 rounded-2xl p-6 backdrop-blur-sm">
          <div class="text-highlight text-4xl mb-4">💻</div>
          <div class="mock-editor bg-black/30 p-4 rounded-lg font-mono text-sm">
            <div class="text-gray-400">// Fix this code to earn $0.50</div>
            <div class="text-highlight mt-2">function</div>
            <div class="ml-4 text-neon">console.log('💰');</div>
          </div>
        </div>
      </div>
    </div>
  </section> -->

  


  <!-- Interactive Testimonials -->
  <section class="py-20 bg-black/30">
    <div class="container mx-auto px-4">
      <div class="max-w-2xl mx-auto text-center mb-12">
        <h2 class="text-3xl font-bold text-neon">From Our Code Warriors</h2>
      </div>
      <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        <div class="testimonial-card bg-white/5 p-6 rounded-2xl backdrop-blur-sm hover:bg-white/10 transition-all">
          <div class="flex items-center gap-4 mb-4">
            <div class="w-12 h-12 bg-highlight/10 rounded-full"></div>
            <div>
              <p class="text-neon font-bold">Rahim, Dhaka</p>
              <p class="text-sm text-gray-300">Web Developer</p>
            </div>
          </div>
          <p class="text-gray-300">"Earned $200 while learning React! The projects feel like real freelance gigs."</p>
          <div class="mt-4 flex gap-2">
            <span class="bg-highlight/20 text-highlight px-2 py-1 rounded-full text-sm">$ earned: 420</span>
            <span class="bg-accent/20 text-accent px-2 py-1 rounded-full text-sm">Level 3</span>
          </div>
        </div>
      </div>
    </div>
  </section>






<section class="py-16 bg-gradient-to-b from-primary-dark to-primary">
  <div class="container mx-auto px-4 text-center">
    <h2 class="text-3xl font-bold text-white mb-2">
      How Much Could <span class="text-highlight">You</span> Earn?
    </h2>
    <p class="text-gray-300 mb-8 max-w-2xl mx-auto">
      Our students average <span class="text-highlight">৳15,000/month</span> within 3 months
    </p>

    <div class="max-w-md mx-auto bg-white/5 rounded-xl p-6 backdrop-blur-sm">
      <div class="mb-4">
        <label class="block text-left text-neon mb-2">Time You Can Invest:</label>
        <select class="w-full bg-white/80 border border-dark/20 text-primary rounded-lg px-4 py-3">
          <option>5-10 hours/week</option>
          <option>10-20 hours/week</option>
          <option>20+ hours/week</option>
        </select>
      </div>
      <button id="calculateBtn" class="auth-trigger w-full bg-highlight hover:bg-yellow-600 text-primary-dark font-bold py-3 px-4 rounded-lg mb-4">
        Calculate My Potential
      </button>
      <div id="result" class="hidden p-4 bg-black/20 rounded-lg border border-dashed border-highlight/30">
        <p class="text-neon">Your estimated earning: <span class="text-2xl font-bold text-highlight">৳8,000 - ৳22,000</span>/month</p>
        <p class="text-sm text-gray-300 mt-2">Based on similar students</p>
      </div>
    </div>
  </div>
</section>




<section class="py-16 bg-primary-dark">
  <div class="container mx-auto px-4">
    <h2 class="text-3xl font-bold text-center text-white mb-12">
      From <span class="text-highlight">Zero</span> to <span class="text-highlight">Earning</span>
    </h2>
    
    <div class="relative max-w-3xl mx-auto">
      <!-- Timeline -->
      <div class="absolute left-1/2 h-full w-1 bg-accent/50 transform -translate-x-1/2"></div>
      
      <!-- Month 1 -->
      <div class="mb-8 flex items-center">
        <div class="z-10 w-8 h-8 bg-highlight rounded-full flex items-center justify-center text-primary-dark font-bold mr-4">
          1
        </div>
        <div class="flex-1 bg-white/5 p-6 rounded-xl">
          <div class="flex items-center gap-3 mb-2">
            <img src="student1.jpg" class="w-10 h-10 rounded-full border-2 border-highlight">
            <div>
              <h4 class="font-bold text-white">Rahim, Dhaka</h4>
              <p class="text-xs text-gray-300">Former shopkeeper</p>
            </div>
          </div>
          <p class="text-gray-300 text-sm">
            "Learned HTML/CSS basics and earned <span class="text-highlight">৳2,500</span> from first micro-project!"
          </p>
        </div>
      </div>
      
      <!-- Month 3 -->
      <div class="mb-8 flex items-center">
        <div class="z-10 w-8 h-8 bg-highlight rounded-full flex items-center justify-center text-primary-dark font-bold mr-4">
          3
        </div>
        <div class="flex-1 bg-white/5 p-6 rounded-xl">
          <div class="flex items-baseline justify-between mb-2">
            <div class="flex items-center gap-3">
              <img src="student2.jpg" class="w-10 h-10 rounded-full border-2 border-highlight">
              <div>
                <h4 class="font-bold text-white">Fatima, Chittagong</h4>
                <p class="text-xs text-gray-300">University student</p>
              </div>
            </div>
            <span class="text-highlight text-sm font-bold">৳18,700/month</span>
          </div>
          <p class="text-gray-300 text-sm">
            "Landed 3 regular clients through SkillForge projects!"
          </p>
        </div>
      </div>
    </div>
  </div>
</section>



<section class="py-16 bg-gradient-to-b from-primary to-primary-dark">
  <div class="container mx-auto px-4 text-center">
    <div class="max-w-2xl mx-auto bg-white/5 rounded-2xl p-8 border-2 border-highlight/50 relative overflow-hidden">
      <!-- Floating Elements -->
      <div class="absolute -top-10 -right-10 w-32 h-32 bg-highlight/10 rounded-full blur-xl"></div>
      
      <span class="inline-block px-3 py-1 bg-highlight text-primary-dark rounded-full text-sm font-bold mb-4">
        LIMITED OFFER
      </span>
      <h2 class="text-3xl font-bold text-white mb-4">
        Free <span class="text-highlight">Starter Kit</span> with Enrollment
      </h2>
      <ul class="text-left max-w-md mx-auto space-y-3 text-gray-300 mb-6">
        <li class="flex items-center gap-3">
          <span class="text-highlight">✦</span>
          <span>5 Client-Ready Project Templates (৳2,500 value)</span>
        </li>
        <li class="flex items-center gap-3">
          <span class="text-highlight">✦</span>
          <span>Exclusive Freelance Pitch Scripts</span>
        </li>
        <li class="flex items-center gap-3">
          <span class="text-highlight">✦</span>
          <span>Private Student Discord Access</span>
        </li>
      </ul>
      
      <div class="flex flex-col sm:flex-row justify-center gap-4">
        <button class="auth-trigger bg-highlight hover:bg-yellow-600 text-primary-dark font-bold py-3 px-8 rounded-full flex-1">
          Claim My Free Kit
        </button>
        <div class="flex items-center justify-center gap-2 text-sm text-gray-300">
          <div class="w-4 h-4 bg-red-500 rounded-full animate-pulse"></div>
          <span>17 kits remaining today</span>
        </div>
      </div>
    </div>
  </div>
</section>


<section class="py-16 bg-primary-dark">
  <div class="container mx-auto px-4">
    <div class="max-w-4xl mx-auto text-center">
      <div class="inline-block p-4 bg-accent/10 rounded-full mb-6">
        <div class="w-16 h-16 bg-accent text-primary-dark rounded-full flex items-center justify-center mx-auto text-2xl font-bold">
          ✓
        </div>
      </div>
      <h2 class="text-3xl font-bold text-white mb-4">
        We Guarantee You'll <span class="text-highlight">Earn Back</span> Your Investment
      </h2>
      <p class="text-gray-300 max-w-2xl mx-auto mb-8">
        Complete the course and do the work - if you don't earn at least <span class="text-highlight">200% of the course fee</span> 
        within 6 months, we'll refund you <span class="font-bold">AND</span> give you free 1:1 coaching.
      </p>
      <button class="auth-trigger bg-highlight hover:bg-yellow-600 text-primary-dark font-bold py-3 px-8 rounded-full inline-flex items-center gap-2">
        Start Risk-Free Today
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
          <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-8.707l-3-3a1 1 0 00-1.414 1.414L10.586 9H7a1 1 0 100 2h3.586l-1.293 1.293a1 1 0 101.414 1.414l3-3a1 1 0 000-1.414z" clip-rule="evenodd" />
        </svg>
      </button>
    </div>
  </div>
</section>



<section class="py-16 bg-gradient-to-b from-primary to-primary-dark">
  <div class="container mx-auto px-4">
    <h2 class="text-3xl font-bold text-center text-white mb-12">
      <span class="text-highlight">Live</span> Student Earnings
    </h2>
    
    <div class="max-w-md mx-auto bg-white/5 rounded-xl overflow-hidden">
      <div class="p-4 bg-highlight/10 border-b border-highlight/20">
        <div class="flex justify-between text-neon font-medium">
          <span>Student</span>
          <span>Earned</span>
        </div>
      </div>
      <div class="divide-y divide-white/10">
        <!-- Will be populated by JS -->
        <div class="p-4 flex justify-between items-center">
          <div class="flex items-center gap-3">
            <div class="w-8 h-8 bg-highlight/20 rounded-full"></div>
            <span class="text-white">Ayesha K.</span>
          </div>
          <span class="text-highlight font-bold">৳1,250</span>
        </div>
        <!-- More entries... -->
      </div>
      <div class="p-4 text-center">
        <button class="text-highlight text-sm font-bold hover:underline">
          View All Earnings →
        </button>
      </div>
    </div>
  </div>
</section>

<script>
  // Simulate live updates
  const earnings = [
    { name: "Rafiq H.", amount: "৳3,400" },
    { name: "Tasnim S.", amount: "৳850" },
    { name: "Arman C.", amount: "৳5,200" }
  ];
  
  setInterval(() => {
    const feed = document.querySelector('.divide-y');
    const randomEarning = earnings[Math.floor(Math.random() * earnings.length)];
    const newEntry = `
      <div class="p-4 flex justify-between items-center animate-pulse">
        <div class="flex items-center gap-3">
          <div class="w-8 h-8 bg-highlight/20 rounded-full"></div>
          <span class="text-white">${randomEarning.name}</span>
        </div>
        <span class="text-highlight font-bold">${randomEarning.amount}</span>
      </div>
    `;
    feed.insertAdjacentHTML('afterbegin', newEntry);
    setTimeout(() => {
      feed.lastElementChild.remove();
    }, 10000);
  }, 3000);
</script>



  <!-- FAQ Section -->
  <section class="py-20 bg-black/20 backdrop-blur-lg">
    <div class="container mx-auto px-4">
      <h2 class="text-3xl font-bold text-center text-neon mb-8">Frequently Asked Questions</h2>
      <div class="max-w-3xl mx-auto space-y-4">
        <div class="faq-item bg-white/5 p-6 rounded-xl cursor-pointer">
          <h3 class="text-xl font-semibold text-white">How does the free trial work?</h3>
          <p class="mt-2 text-gray-300 hidden">Access all starter courses free for 7 days with no card required.</p>
        </div>
        <div class="faq-item bg-white/5 p-6 rounded-xl cursor-pointer">
          <h3 class="text-xl font-semibold text-white">What payment methods are accepted?</h3>
          <p class="mt-2 text-gray-300 hidden">We accept cards, UPI, and popular wallets.</p>
        </div>
      </div>
    </div>
  </section>



  <!-- Newsletter / Quick Signup CTA -->
  <section class="py-16">
    <div class="container mx-auto px-4 text-center">
      <h2 class="text-3xl font-bold text-white mb-4">Stay Updated</h2>
      <p class="text-white mb-6">Get weekly micro-gigs and tips straight to your inbox</p>
      <form class="max-w-md mx-auto flex flex-col sm:flex-row gap-4">
        <input type="email" placeholder="Your Email" class="flex-1 px-4 py-2 rounded-full bg-white/10 text-white placeholder-gray-400 focus:bg-white/20 transition">
        <button type="submit" class="bg-accent text-white px-6 py-2 rounded-full font-semibold hover:brightness-110 transition-all">
          Subscribe
        </button>
      </form>
    </div>
  </section>

  <!-- Footer -->
  <footer class="bg-primary-dark py-12 text-white">
    <div class="container mx-auto px-4 flex flex-col md:flex-row justify-between items-center space-y-6 md:space-y-0">
      <!-- Call to Action -->
      <div class="text-center md:text-left">
        <h3 class="text-2xl font-bold mb-2">Ready to Forge Your Future?</h3>
        <p class="text-gray-300 mb-4">Join thousands of learners and start earning today.</p>
        <a href="#" class="auth-trigger inline-block bg-highlight text-primary-dark px-6 py-3 rounded-full font-semibold shadow-neon hover:shadow-neon-lg transition">
          Start Free Trial
        </a>
      </div>

      <!-- Footer Links -->
      <div class="flex space-x-6">
        <a href="#" class="hover:text-highlight">About</a>
        <a href="#" class="hover:text-highlight">Courses</a>
        <a href="#" class="hover:text-highlight">Blog</a>
        <a href="#" class="hover:text-highlight">Contact</a>
      </div>
    </div>
    <div class="container mx-auto px-4 text-center mt-6 text-gray-500">
      &copy; 2025 SkillForge Pro. All rights reserved.
    </div>
  </footer>

  <!-- Floating CTA -->
<div class="fixed bottom-4 right-4">
    <button class="auth-trigger bg-highlight text-primary px-6 py-3 rounded-full shadow-neon hover:shadow-neon-lg transform hover:scale-105 transition-all flex items-center gap-2">
        <span class="animate-pulse">✨</span> 
        Start Free Trial
    </button>
</div>



</div>


@endsection