<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title inertia>{{ config('app.name', 'Recruiting') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Icons -->
        <link rel="icon" href="{{ URL::asset('favicon.ico') }}" type="image/x-icon"/>

        <!-- Scripts -->
        @routes
        @vite(['resources/js/app.js', "resources/js/Pages/{$page['component']}.vue"])
        @inertiaHead
    </head>
    <body class="font-sans antialiased flex flex-col min-h-screen">
        @inertia
        <footer class="bg-neutral-200 text-center dark:bg-neutral-700 lg:text-left mt-auto">
            <div class="p-4 text-center text-neutral-700 dark:text-neutral-200 font-bold">
                © Recruiting Copyright {{ date("Y"); }}
            </div>
        </footer>        
    </body>
</html>
