@extends('layouts.app')
@section('content')

<div class="container mx-auto px-4 py-8" x-data="{ selectedCategory: 'all' }">
  
  <h1 class="text-2xl font-bold mb-4">Dashboard</h1>
    <p class="mb-4 text-green-600">Welcome back, {{ auth()->user()->name }}</p>


  <div class="flex justify-between items-center mb-8">
    <h1 class="text-3xl font-bold text-gray-800">My Courses</h1>
    
    
    <!-- Category filter -->
    <div class="flex space-x-2">
      <button @click="selectedCategory = 'all'" 
              :class="{'bg-blue-600 text-white': selectedCategory === 'all', 'bg-gray-200 hover:bg-gray-300': selectedCategory !== 'all'}"
              class="px-4 py-2 rounded-full text-sm font-medium transition-colors">
        All Courses
      </button>
      <button @click="selectedCategory = 'active'" 
              :class="{'bg-blue-600 text-white': selectedCategory === 'active', 'bg-gray-200 hover:bg-gray-300': selectedCategory !== 'active'}"
              class="px-4 py-2 rounded-full text-sm font-medium transition-colors">
        Active
      </button>
      <button @click="selectedCategory = 'completed'" 
              :class="{'bg-blue-600 text-white': selectedCategory === 'completed', 'bg-gray-200 hover:bg-gray-300': selectedCategory !== 'completed'}"
              class="px-4 py-2 rounded-full text-sm font-medium transition-colors">
        Completed
      </button>
    </div>
  </div>

  <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
    @foreach($courses as $course)
    <div class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-300"
         x-show="selectedCategory === 'all' || selectedCategory === '{{ $course['status'] ?? 'active' }}'">
      <!-- Course Image Placeholder -->
      <div class="h-48 bg-gradient-to-r from-blue-500 to-indigo-600 flex items-center justify-center">
        <span class="text-white text-2xl font-bold">{{ substr($course['Title'], 0, 1) }}</span>
      </div>
      
      <div class="p-6">
        <div class="flex justify-between items-start mb-2">
          <h2 class="text-xl font-bold text-gray-800">
            <a href="{{ url('/courses/'.$course['id']) }}" class="hover:text-blue-600 transition-colors">
              {{ $course['Title'] }}
            </a>
          </h2>
          <span class="bg-blue-100 text-blue-800 text-xs font-semibold px-2.5 py-0.5 rounded">
            {{ $course['Has Quiz'] ? 'With Quiz' : 'No Quiz' }}
          </span>
        </div>
        
        <p class="text-gray-600 mb-4 line-clamp-2">{{ $course['Content'] }}</p>
        
        <div class="flex justify-between items-center mb-4">
          <div class="flex items-center">
            <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
              <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
            </svg>
            <span class="ml-1 text-gray-600">{{ $course['Lesson Points'] ?? 0 }} Points</span>
          </div>
          <span class="text-lg font-bold text-blue-600">৳{{ number_format($course['Price'], 2) }}</span>
        </div>
        
        <div class="flex space-x-2">
          <a href="{{ url('/courses/'.$course['id']) }}" 
             class="flex-1 bg-blue-600 hover:bg-blue-700 text-white py-2 px-4 rounded-lg text-center font-medium transition-colors">
            Continue
          </a>
          <button @click="alert('Bookmarked!')" 
                  class="p-2 text-gray-500 hover:text-red-500 rounded-lg hover:bg-gray-100 transition-colors">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"/>
            </svg>
          </button>
        </div>
      </div>
    </div>
    @endforeach
  </div>
</div>
@endsection