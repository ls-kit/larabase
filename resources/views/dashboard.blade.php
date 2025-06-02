<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{ __("You're logged in!") }}
                </div>
            </div>
        </div>
    </div>

@section('content')
<div class="p-6">
    <h1 class="text-2xl font-bold mb-4">Dashboard</h1>
    <p class="mb-4 text-green-600">Welcome back, {{ auth()->user()->name }}</p>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div class="p-4 border rounded shadow">
            <h2 class="font-semibold mb-2">Free Courses</h2>
            <a href="/courses/1" class="text-blue-500 underline">Start Free Laravel Course</a>
        </div>
        <div class="p-4 border rounded shadow">
            <h2 class="font-semibold mb-2">Paid Courses</h2>
            <a href="/courses/5" class="text-blue-500 underline">Unlock Advanced Tailwind</a>
        </div>
    </div>
</div>



@endsection





</x-app-layout>


