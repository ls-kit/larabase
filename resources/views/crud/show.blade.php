@extends('layouts.app')
  @section('content')
    <h1>{{ ucfirst($table) }} Details</h1>
    <ul>
      @foreach($row as $key => $value)
        <li>
          <strong>{{ ucwords(str_replace('_', ' ', $key)) }}:</strong>
          {{ $value }}
        </li>
      @endforeach
    </ul>
    <a href="{{ route('crud.edit', [$table, $row['id']]) }}">Edit</a>
    <form action="{{ route('crud.destroy', [$table, $row['id']]) }}" method="POST" style="display:inline;">
      @csrf @method('DELETE')
      <button>Delete</button>
    </form>
    <a href="{{ route('crud.index', $table) }}">Back to list</a>
  @endsection