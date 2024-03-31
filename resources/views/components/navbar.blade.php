<nav class="bg-indigo-700 text-slate-50 w-full z-20 top-0 start-0">
    <div class="max-w-screen flex flex-wrap items-center justify-between mx-3 py-3">
        <a href="{{ route('home') }}" class="flex items-center space-x-3 rtl:space-x-reverse">
            <img src="{{ asset('logo_ung.png') }}" class="h-9" alt="logo">
            <span class="self-center md:text-lg lg:text-2xl font-semibold whitespace-nowrap">{{ config('app.name') }}</span>
        </a>
        <div class="flex md:order-2 space-x-3 md:space-x-0 rtl:space-x-reverse items-center">
            <button data-collapse-toggle="navbar" type="button" class="inline-flex items-center p-2 w-10 h-10 justify-center text-sm text-gray-50 rounded-lg md:hidden hover:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-gray-200 " aria-controls="navbar" aria-expanded="false">
                <span class="sr-only">Open main menu</span>
                <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 17 14">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 1h15M1 7h15M1 13h15" />
                </svg>
            </button>
            @if (session('user_id'))
                <span class="my-auto me-3 font-semibold text-sm hidden lg:block">{{ session('name') }}</span>
                <!-- Dropdown menu -->
                <div class="relative ps-2" x-data="{ open: false }">
                    <button @click="open = !open" type="button" class="flex text-md rounded-full md:me-2 my-auto focus:outline-none" id="user-menu-button" aria-expanded="false">
                        <span class="sr-only">Open user menu</span>
                        <img class="w-10 h-10 rounded-full" src="{{ asset('avatar.png') }}" alt="{{ session('username') }}">
                    </button>
                    <div x-show="open" @click.away="open = false" class="absolute right-0 mt-2 w-64 bg-white rounded-lg shadow-lg">
                        <div class="px-4 py-3">
                            <span class="block text-sm text-gray-900 dark:text-white">{{ session('name') }}</span>
                            <span class="block text-sm text-gray-500 truncate dark:text-gray-400">{{ session('username') }}</span>
                        </div>
                        <ul class="py-2" aria-labelledby="user-menu-button">
                            <li>
                                <a href="{{ route('logout') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">Keluar</a>
                            </li>
                        </ul>
                    </div>
                </div>
            @else
                <a href="{{ route('login') }}" class="text-gray-800 bg-gray-50 hover:bg-gray-200 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2 text-center block w-max mx-auto transition duration-300 ease-in-out transform hover:scale-105 hover:shadow-xl">Masuk</a>
            @endif
        </div>
        <div class="items-center justify-between hidden w-full md:flex md:w-auto md:order-1" id="navbar">
            <ul class="flex flex-col p-4 md:p-0 mt-4 font-medium text-gray-50 border border-gray-50 rounded-lg bg-indigo-800 md:space-x-8 rtl:space-x-reverse md:flex-row md:mt-0 md:border-0 md:bg-transparent ">
                <x-navbar-menu />
            </ul>
        </div>
    </div>
</nav>
