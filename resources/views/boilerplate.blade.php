<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}"
      x-data="{
          darkMode: JSON.parse(localStorage.getItem('darkMode') ?? 'null') ?? window.matchMedia('(prefers-color-scheme: dark)').matches
      }"
      x-init="$watch('darkMode', val => {
          localStorage.setItem('darkMode', JSON.stringify(val));
          document.documentElement.classList.toggle('dark', val);
      })"
      x-effect="document.documentElement.classList.toggle('dark', darkMode)">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Welcome</title>
        @vite(['resources/css/app.css','resources/js/app.js'])
    </head>
    <body class="antialiased bg-gray-100 text-gray-800 dark:bg-gray-900 dark:text-gray-100 transition-colors">
        <div class="min-h-screen flex flex-col items-center justify-center">
            <!-- Dark mode toggle -->
            <div class="absolute top-5 right-5">
                <button @click="darkMode = !darkMode"
                        class="p-2 rounded-full bg-gray-200 dark:bg-gray-700 hover:bg-gray-300 dark:hover:bg-gray-600 transition">
                    <span x-show="!darkMode">🌙</span>
                    <span x-show="darkMode">☀️</span>
                </button>
            </div>

            <!-- Main card -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-8 max-w-lg w-full text-center transition-colors">
                @yield('content')
            </div>
        </div>
    </body>
</html>
