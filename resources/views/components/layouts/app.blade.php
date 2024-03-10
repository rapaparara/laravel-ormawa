<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? config('app.name') }}</title>
    <link rel="icon" href="{{ asset('logo_ung.png') }}">
    @vite('resources/css/app.css')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>

<body class="bg-gray-200">

    <x-navbar />
    <main>
        <div>
            {{ $slot }}
        </div>
    </main>
    <footer class="mt-4 bg-white text-indigo-800">
        <div class="w-full max-w-screen-xl mx-auto p-4 md:py-8">
            <div class="sm:flex sm:items-center sm:justify-between">
                <a href="{{ route('home') }}" class="flex items-center mb-4 sm:mb-0 space-x-3 rtl:space-x-reverse">
                    <img src="{{ asset('logo_ung.png') }}" class="h-8" alt="logo" />
                    <span
                        class="self-center text-2xl font-semibold whitespace-nowrap dark:text-white">{{ config('app.name') }}</span>
                </a>
                <ul
                    class="flex flex-wrap items-center mb-6 text-sm font-medium text-gray-500 sm:mb-0 dark:text-gray-400">
                    <li>
                        <a href="{{ route('home.fasilitas') }}" class="hover:underline me-4 md:me-6">Fasilitas</a>
                    </li>
                    <li>
                        <a href="{{ route('home.fasilitas') }}" class="hover:underline">Kegiatan Ormawa</a>
                    </li>
                </ul>
            </div>
            <hr class="my-6 border-gray-200 sm:mx-auto dark:border-gray-700 lg:my-8" />
            <span class="block text-sm text-gray-500 sm:text-center dark:text-gray-400">© 2024 <a
                    href="{{ route('home') }}" class="hover:underline">SiAdminOrmawa</a>. Universitas Negeri
                Gorontalo.</span>
        </div>
    </footer>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.js"></script>
</body>

</html>
