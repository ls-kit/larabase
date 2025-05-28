@extends('layouts.app')
@section('content')
  <h1>Modules for “{{ $course['Name'] }}”</h1>

@if(empty($modules))
    <p>No modules found for this course.</p>
@else
    <ul>
      @foreach($modules as $module)
        <li>
          <a href="{{ url('/lessons/'.$module['id']) }}">
            {{ $module['Name'] ?: 'Module #'.$module['id'] }}
          </a>
        </li>
      @endforeach
    </ul>
  @endif
@endsection
