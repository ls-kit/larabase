@extends('layouts.app')
@section('content')
  <h1>{{ ucfirst($table) }} List</h1>
  <a href="{{ route('crud.create', $table) }}">Create New</a>
  <ul>
    @foreach($rows as $row)
      <li>
        ID: {{ $row['id'] }}
        | <a href="{{ route('crud.edit', [$table, $row['id']]) }}">Edit</a>
        <form action="{{ route('crud.destroy', [$table, $row['id']]) }}" method="POST" style="display:inline;">
          @csrf @method('DELETE')
          <button onclick="return confirm('Delete?')">Delete</button>
        </form>
      </li>
    @endforeach
  </ul>
@endsection
