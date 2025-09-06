@extends('boilerplate')

@section('content')
    <h1 class="text-4xl font-bold text-indigo-600 dark:text-indigo-400 mb-4">
        Welcome to Laravel 🎉
    </h1>
    <p class="text-lg mb-6">
        Tailwind v4 dark mode is now automatic on first load, with a persistent toggle.
    </p>
    <div class="flex justify-center gap-4">
        <a href="{{ url('/dashboard') }}"
           class="px-6 py-2 rounded-lg bg-indigo-600 text-white font-semibold hover:bg-indigo-700 dark:hover:bg-indigo-500 transition">
            Dashboard
        </a>
        <a href="https://laravel.com/docs" target="_blank"
           class="px-6 py-2 rounded-lg border border-gray-300 dark:border-gray-600 hover:bg-gray-100 dark:hover:bg-gray-700 transition">
            Docs
        </a>
    </div>
@endsection
