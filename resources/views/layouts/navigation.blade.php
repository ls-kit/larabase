<nav x-data="{ open: false }" class="bg-white shadow sticky top-0 z-50 border-b border-blue-200">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="flex justify-between h-16 items-center">

      <!-- Logo & App Name -->
      <div class="flex items-center gap-2">
        <a href="{{ route('dashboard') }}" class="flex items-center gap-2">
          <x-application-logo class="block h-10 w-auto fill-current text-blue-700" />
          {{-- <span class="font-bold text-lg text-blue-700 tracking-wide hidden sm:inline">Chesta Academy</span> --}}
        </a>
        <a href="{{ route('courses.index') }}" class="ml-6 px-3 py-2 rounded-full text-sm font-semibold text-blue-700 hover:bg-blue-50 transition">All Courses</a>
        <a href="/" class="ml-6 px-3 py-2 rounded-full text-sm font-semibold text-blue-700 hover:bg-blue-50 transition">Front Page</a>
      </div>

      <!-- User Menu -->
      @auth
        <div class="hidden sm:flex items-center gap-3">
          <!-- User Profile Dropdown with Alpine.js -->
          <div class="relative" x-data="{ show: false }" @keydown.escape="show = false">
            <button @click="show = !show"
              class="flex items-center gap-2 px-4 py-2 rounded-full hover:bg-blue-50 transition focus:outline-none"
              :aria-expanded="show ? 'true' : 'false'">
              <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=3B82F6&color=fff&rounded=true&size=40"
                class="w-9 h-9 rounded-full shadow-sm border border-blue-200" alt="profile" />
              <span class="font-medium text-gray-800">{{ Auth::user()->name }}</span>
              <svg class="w-4 h-4 ml-1 text-blue-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
              </svg>
            </button>
            <div x-show="show"
              @click.away="show = false"
              x-transition:enter="transition ease-out duration-100"
              x-transition:enter-start="opacity-0 scale-95"
              x-transition:enter-end="opacity-100 scale-100"
              x-transition:leave="transition ease-in duration-75"
              x-transition:leave-start="opacity-100 scale-100"
              x-transition:leave-end="opacity-0 scale-95"
              class="absolute right-0 mt-2 w-48 bg-white border border-blue-100 rounded-xl shadow-xl py-2 z-40">
              <a href="{{ route('profile.edit') }}" class="block px-5 py-2 text-gray-700 hover:bg-blue-50 rounded-xl transition">Profile</a>
              <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="w-full text-left px-5 py-2 text-red-600 hover:bg-red-50 rounded-xl transition">Logout</button>
              </form>
            </div>
          </div>
        </div>
      @endauth

      <!-- Hamburger (Mobile) -->
      <div class="sm:hidden flex items-center">
        <button @click="open = !open" class="p-2 rounded-full text-blue-700 hover:bg-blue-50 focus:outline-none transition">
          <svg class="h-7 w-7" stroke="currentColor" fill="none" viewBox="0 0 24 24">
            <path :class="{ 'hidden': open, 'inline-flex': !open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M4 6h16M4 12h16M4 18h16" />
            <path :class="{ 'hidden': !open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M6 18L18 6M6 6l12 12" />
          </svg>
        </button>
      </div>
    </div>
  </div>

  <!-- Mobile Nav -->
  <div :class="{ 'block': open, 'hidden': !open }" class="hidden sm:hidden bg-white shadow">
    <div class="px-4 pt-3 pb-2">
      <a href="{{ route('courses.index') }}" class="block py-2 text-blue-700 font-semibold rounded hover:bg-blue-50 transition">All Courses</a>
      <a href="{{ route('profile.edit') }}" class="block py-2 text-gray-700 rounded hover:bg-blue-50 transition">Profile</a>
      <form method="POST" action="{{ route('logout') }}" class="mt-1">
        @csrf
        <button type="submit" class="w-full text-left py-2 text-red-600 rounded hover:bg-red-50 transition">Logout</button>
      </form>
    </div>
  </div>
</nav>
