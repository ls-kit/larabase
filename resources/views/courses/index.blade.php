@extends('layouts.app')
@section('content')
  <h1>All Courses</h1>
    <ul>
    @foreach($courses as $course)
      <li class="mb-6 p-4 border rounded-lg">
        <h2 class="text-xl font-bold">
          <a href="{{ url('/courses/'.$course['id']) }}" class="text-blue-600 hover:underline">
            {{ $course['Name'] }}
          </a>
        </h2>
        <p><strong>Title:</strong> {{ $course['Title'] }}</p>
        <p><strong>Active:</strong> {{ $course['Active'] ? 'Yes' : 'No' }}</p>
        <p><strong>Description:</strong> {{ $course['Description'] }}</p>
        <p><strong>Lesson Title:</strong> {{ $course['Lesson Title'] }}</p>
        <p><strong>Price:</strong> {{ $course['Price'] }}</p>
      </li>
    @endforeach
  </ul>
@endsection