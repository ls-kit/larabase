@extends('layouts.app')
@section('content')
  <h1>{{ \$lesson['name'] }}</h1>
  <p>{{ \$lesson['description'] }}</p>
  <h3>Tasks</h3>
  <ul>
    @foreach(\$tasks as \$task)
      <li>
        {{ \$task['name'] }}
        <form method="POST" action="{{ url('/tasks/'.$task['id'].'/complete') }}">
          @csrf
          <button type="submit">Mark Complete</button>
        </form>
      </li>
    @endforeach
  </ul>
@endsection