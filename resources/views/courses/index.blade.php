@extends('layouts.app')
@section('content')
  <h1>All Courses</h1>
    <ul>

    @foreach($courses as $course)
      <li class="mb-6 p-4 border rounded-lg">
        <h2 class="text-xl font-bold">
          <a href="{{ url('/courses/'.$course['id']) }}" class="text-blue-600 hover:underline">
            {{ $course['Title'] }}
          </a>
        </h2>
        <p class="p-3"></p>
        <p><strong>Title:</strong> {{ $course['Title'] }}</p>
        <p><strong>Has Quiz:</strong> {{ $course['Has Quiz'] ? 'Yes' : 'No' }}</p>
        <p><strong>Description:</strong> {{ $course['Content'] }}</p>
        
        <p><strong>Price:</strong> {{ $course['Price'] }}</p>
      </li>
    @endforeach
  </ul>
@endsection