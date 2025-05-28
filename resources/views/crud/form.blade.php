@extends('layouts.app')
@section('content')
  <h1>{{ isset($row) ? 'Edit' : 'Create' }} {{ ucfirst($table) }}</h1>

  <form method="POST"
        action="{{ isset($row)
                  ? route('crud.update', [$table, $row['id']])
                  : route('crud.store', $table) }}">
    @csrf
    @if(isset($row)) @method('PATCH') @endif

    @foreach($fields as $field)
      <div class="mb-4">
        <label>{{ ucfirst(str_replace('_',' ',$field)) }}</label>
        <input
          type="text"
          name="{{ $field }}"
          value="{{ old($field, $row[$field] ?? '') }}"
          class="border p-2 w-full"
        />
      </div>
    @endforeach

    <button type="submit" class="btn">
      {{ isset($row) ? 'Update' : 'Create' }}
    </button>
  </form>
@endsection
