<nav class="bg-indigo-700 text-slate-50 w-full z-20 top-0 start-0 ">
    <div class="max-w-screen-xl flex flex-wrap items-center justify-between mx-3 py-3">
        <a wire:navigate href="{{ route('home') }}" class="flex items-center space-x-3 rtl:space-x-reverse">
            <img src="{{ asset('logo_ung.png') }}" class="h-9" alt="logo">
            <span
                class="self-center md:text-lg lg:text-2xl font-semibold whitespace-nowrap ">{{ config('app.name') }}</span>
        </a>
        <div class="flex md:order-2 space-x-3 md:space-x-0 rtl:space-x-reverse">
            @if (session('user_id'))
                <a href="{{ route('logout') }}"
                    class="text-gray-800 bg-gray-50 hover:bg-gray-200 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2 text-center block w-max mx-auto">Keluar</a>
            @else
                <a wire:navigate href="{{ route('login') }}"
                    class="text-gray-800 bg-gray-50 hover:bg-gray-200 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2 text-center block w-max mx-auto">Masuk</a>
            @endif
            <button data-collapse-toggle="navbar" type="button"
                class="inline-flex items-center p-2 w-10 h-10 justify-center text-sm text-gray-50 rounded-lg md:hidden hover:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-gray-200 "
                aria-controls="navbar" aria-expanded="false">
                <span class="sr-only">Open main menu</span>
                <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                    viewBox="0 0 17 14">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M1 1h15M1 7h15M1 13h15" />
                </svg>
            </button>
        </div>
        <div class="items-center justify-between hidden w-full md:flex md:w-auto md:order-1" id="navbar">
            <ul
                class="flex flex-col p-4 md:p-0 mt-4 font-medium text-gray-50 border border-gray-50 rounded-lg bg-indigo-800 md:space-x-8 rtl:space-x-reverse md:flex-row md:mt-0 md:border-0 md:bg-transparent">
                <x-navbar-menu />
            </ul>
        </div>
    </div>
</nav>