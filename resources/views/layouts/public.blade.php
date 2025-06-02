<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="UTF-8">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>
  <title>ChestaApp</title>
  
  <!-- Font -->
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
  <link href="https://unpkg.com/aos@next/dist/aos.css" rel="stylesheet">
  <!-- Tailwind -->
  {{-- <script src="https://cdn.tailwindcss.com"></script> --}}
          <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
  <style>
    @layer base { html { font-family: 'Inter', sans-serif; } }
  </style>
  <script>
  tailwind.config = {
    theme: {
      extend: {
        colors: {
          primary: '#005f73',
          secondary: '#0a9396',
          accent: '#94d2bd',
          highlight: '#ee9b00',
            neon: '#d4f1f4',
            'primary-dark': '#003f43'
        }
        ,
          boxShadow: {
            neon: '0 0 15px rgba(212, 241, 244, 0.5)',
            'neon-lg': '0 0 25px rgba(212, 241, 244, 0.7)'
          }
      }
    }
  };
</script>
  
  
  
  <!-- jQuery -->
  <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>


</head>
<body class=""  id="tsparticles" >

     @yield('content')


     <!-- Add these elements before </body> -->
<!-- Scroll Progress Indicator -->
<div class="fixed top-0 left-0 h-1 bg-white/10 w-full z-50">
  <div id="scrollProgress" class="h-full bg-highlight transition-all duration-300" style="width: 0%"></div>
</div>
<!-- Exit Intent Popup -->
<div id="exitPopup" class="fixed inset-0 bg-black/90 hidden z-50 flex items-center justify-center p-4">
  <div class="bg-gradient-to-b from-primary-dark to-primary rounded-xl p-8 max-w-md relative">
    <button class="absolute top-4 right-4 text-gray-400 hover:text-white">&times;</button>
    <h3 class="text-2xl font-bold text-neon mb-4">Wait! Special Offer Just For You</h3>
    <p class="text-gray-300 mb-4"><span id="cityStudents">15 students</span> from <span id="userCity">your city</span> enrolled today!</p>
    <div class="bg-white/5 p-4 rounded-lg mb-6">
      <div class="flex items-center justify-between mb-2">
        <span class="text-highlight">⏳ Limited Time:</span>
        <span id="countdown" class="font-bold">15:00</span>
      </div>
      <div class="text-center">
        <span class="text-sm text-gray-400">50% OFF for next 30 minutes</span>
      </div>
    </div>
    <button class="w-full bg-highlight hover:bg-yellow-600 text-primary-dark font-bold py-3 rounded-lg">
      Claim Discount Now
    </button>
  </div>
</div>
<!-- Localization Script -->
<script>
// IP Geolocation
$.getJSON('https://ipinfo.io?token=1e8c44447d205a', function(data) {
  const city = data.city || 'your area';
  const fakeCount = Math.floor(Math.random() * 20) + 5;
  
  // Update elements
  $('#userCity').text(city);
  $('#cityStudents').text(fakeCount + ' students');
  $('.local-students').text(fakeCount);
}).fail(function() {
  console.log('Geolocation failed');
});

// Scroll Progress
$(window).scroll(function() {
  const winScroll = document.body.scrollTop || document.documentElement.scrollTop;
  const height = document.documentElement.scrollHeight - document.documentElement.clientHeight;
  const scrolled = (winScroll / height) * 100;
  $('#scrollProgress').css('width', scrolled + '%');
});

// Exit Intent Detection
let mouseY = 0;
document.addEventListener('mouseout', (e) => {
  if (!e.toElement && !e.relatedTarget && e.clientY < 50) {
    if(!localStorage.getItem('popupShown')) {
      $('#exitPopup').fadeIn();
      startCountdown();
      localStorage.setItem('popupShown', 'true');
    }
  }
});

// Countdown Timer
function startCountdown() {
  let time = 900; // 15 minutes in seconds
  const timer = setInterval(() => {
    const minutes = Math.floor(time / 60);
    const seconds = time % 60;
    $('#countdown').text(`${minutes}:${seconds.toString().padStart(2, '0')}`);
    time--;
    
    if(time < 0) {
      clearInterval(timer);
      $('#exitPopup').fadeOut();
    }
  }, 1000);
}
// Close Popup
$('#exitPopup button').click(() => $('#exitPopup').fadeOut());
</script>




<!-- Trigger achievement popups periodically  -->
<div id="achievementPopup" class="fixed bottom-4 left-4 bg-highlight/90 text-primary-dark p-4 rounded-xl shadow-lg hidden">
  <div class="flex items-center gap-3">
    <span class="text-2xl">🎉</span>
    <div>
      <p class="font-bold">New Achievement Unlocked!</p>
      <p class="text-sm">"First Project Completed"</p>
    </div>
  </div>
</div>
<script>
// Trigger achievement popups periodically
const achievements = [
  { emoji: "💰", title: "Earning Streak!", text: "3 projects completed in a week" },
  { emoji: "🚀", title: "Fast Learner!", text: "Completed 5 lessons today" }
];
setInterval(() => {
  const achievement = achievements[Math.floor(Math.random() * achievements.length)];
  $('#achievementPopup').html(`
    <div class="flex items-center gap-3">
      <span class="text-2xl">${achievement.emoji}</span>
      <div>
        <p class="font-bold">${achievement.title}</p>
        <p class="text-sm">${achievement.text}</p>
      </div>
    </div>
  `).fadeIn(300).delay(3000).fadeOut(300);
}, 15000);
</script>



<!-- Add to course cards. limited seat left -->
<div class="absolute top-4 right-4">
  <div class="bg-red-500 text-white px-3 py-1 rounded-full text-sm flex items-center animate-pulse">
    <span class="mr-2">🔥</span>
    <span>Only <span class="font-bold">3</span> spots left!</span>
  </div>
</div>

<!-- Add before </body> -->
<button id="backToTop" class="fixed bottom-10 mb-10 right-8 p-3 bg-highlight/90 text-primary-dark rounded-full shadow-lg hover:bg-yellow-600 transition-all opacity-0 invisible">
  <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"/>
  </svg>
</button>
<script>
$(window).scroll(function() {
  if ($(this).scrollTop() > 300) {
    $('#backToTop').removeClass('opacity-0 invisible').addClass('opacity-100 visible');
  } else {
    $('#backToTop').removeClass('opacity-100 visible').addClass('opacity-0 invisible');
  }
});
$('#backToTop').click(() => $('html, body').animate({ scrollTop: 0 }, 500));
</script>


<style>
<!-- cursor effect -->
.cursor-dot {
  width: 8px;
  height: 8px;
  background: #ee9b00; /* highlight color */
}
.cursor-ring {
  width: 30px;
  height: 30px;
  border: 2px solid #94d2bd; /* accent color */
}
</style>
<div class="cursor-dot fixed pointer-events-none z-50"></div>
<div class="cursor-ring fixed pointer-events-none z-50 rounded-full"></div>
<script>
document.addEventListener('mousemove', e => {
  $('.cursor-dot').css({
    left: e.clientX + 'px',
    top: e.clientY + 'px'
  });
  $('.cursor-ring').css({
    left: e.clientX + 'px',
    top: e.clientY + 'px'
  });
});
</script>



<!-- Add after <body> -->
<!-- <div id="tsparticles" class="fixed inset-0 -z-10 opacity-20"></div> -->

<!-- <script src="https://cdn.jsdelivr.net/npm/tsparticles@2.3.4/tsparticles.bundle.min.js"></script>
<script>
tsParticles.load("tsparticles", {
  particles: {
    number: { value: 50 },
    color: { value: ["#ee9b00", "#94d2bd", "#0a9396"] },
    move: {
      enable: true,
      speed: 1,
      direction: "none",
      random: true,
      straight: false
    }
  }
});
</script> -->




<script src="https://unpkg.com/aos@next/dist/aos.js"></script>
<script>
  document.addEventListener('DOMContentLoaded', () => {
      AOS.init({
        once: true,
        offset: 120,
        duration: 600
      });
    });
</script>

</body>
</html>





{{-- <!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-gray-900 antialiased">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100">
            @yield('content')
        </div>
    </body>
</html> --}}
