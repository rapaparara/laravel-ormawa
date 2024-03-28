@if (session('user_id'))
    @if (session('user_role') == 'admin')
        <li>
            <a href="{{ route('admin.pengguna') }}"
                class="block py-2 px-3 text-slate-50 rounded transition-colors duration-300 hover:text-indigo-400  md:p-0">Pengguna</a>
        </li>
        <li>
            <button id="dropdownNavbarLink" data-dropdown-toggle="dropdownNavbar"
                class="flex items-center justify-between w-full py-2 px-3 text-slate-50 rounded transition-colors duration-300 hover:text-indigo-400  md:p-0">Fakultas
                <svg class="w-2.5 h-2.5 ms-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                    viewBox="0 0 10 6">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="m1 1 4 4 4-4" />
                </svg>
            </button>
            <!-- Dropdown menu -->
            <div id="dropdownNavbar"
                class="z-10 hidden font-normal bg-white divide-y divide-gray-100 rounded-lg shadow w-44 dark:bg-gray-700 dark:divide-gray-600">
                <ul class="py-2 text-sm text-gray-700 dark:text-gray-400" aria-labelledby="dropdownLargeButton">
                    <li>
                        <a href="{{ route('admin.fakultas') }}"
                            class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Manajemen Fakultas</a>
                    </li>
                    <li>
                        <a href="{{ route('admin.kemahasiswaan') }}"
                            class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Kemahasiswaan Fakultas</a>
                    </li>
                </ul>
            </div>
        </li>
        <li>
            <a href="{{ route('admin.periode') }}"
                class="block py-2 px-3 text-slate-50 rounded transition-colors duration-300 hover:text-indigo-400  md:p-0">Periode</a>
        </li>
    @endif
    @if (session('user_role') == 'kemahasiswaan')
        <li>
            <button id="dropdownNavbarLink" data-dropdown-toggle="dropdownNavbar"
                class="flex items-center justify-between w-full py-2 px-3 text-slate-50 rounded transition-colors duration-300 hover:text-indigo-400  md:p-0">Kepengurusan Ormawa
                <svg class="w-2.5 h-2.5 ms-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                    viewBox="0 0 10 6">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="m1 1 4 4 4-4" />
                </svg>
            </button>
            <!-- Dropdown menu -->
            <div id="dropdownNavbar"
                class="z-10 hidden font-normal bg-white divide-y divide-gray-100 rounded-lg shadow w-44 dark:bg-gray-700 dark:divide-gray-600">
                <ul class="py-2 text-sm text-gray-700 dark:text-gray-400" aria-labelledby="dropdownLargeButton">
                    <li>
                        <a href="{{ route('kemahasiswaan.ormawa') }}"
                            class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Manajemen Ormawa</a>
                    </li>
                    <li>
                        <a href="{{ route('kemahasiswaan.pengguna') }}"
                            class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Pengguna Ormawa</a>
                    </li>
                    <li>
                        <a href="{{ route('kemahasiswaan.kepengurusan') }}"
                            class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Manajemen Kepengurusan</a>
                    </li>
                </ul>
            </div>
        </li>
        <li>
            <a href="{{ route('kemahasiswaan.fasilitas') }}"
                class="block py-2 px-3 text-slate-50 rounded transition-colors duration-300 hover:text-indigo-400  md:p-0">Fasilitas</a>
        </li>
        <li>
            <a href="{{ route('kemahasiswaan.kegiatan') }}"
                class="block py-2 px-3 text-slate-50 rounded transition-colors duration-300 hover:text-indigo-400  md:p-0">Kegiatan
            </a>
        </li>
        <li>
            <a href="{{ route('kemahasiswaan.laporan') }}"
                class="block py-2 px-3 text-slate-50 rounded transition-colors duration-300 hover:text-indigo-400  md:p-0">Laporan
            </a>
        </li>
    @endif
    @if (session('user_role') == 'mahasiswa')
        <li>
            <a href="{{ route('mahasiswa.kepengurusan') }}"
                class="block py-2 px-3 text-slate-50 rounded transition-colors duration-300 hover:text-indigo-400  md:p-0">Kepengurusan</a>
        </li>
        <li>
            <a href="{{ route('mahasiswa.kegiatan') }}"
                class="block py-2 px-3 text-slate-50 rounded transition-colors duration-300 hover:text-indigo-400  md:p-0">Kegiatan</a>
        </li>
        <li>
            <a href="{{ route('mahasiswa.fasilitas') }}"
                class="block py-2 px-3 text-slate-50 rounded transition-colors duration-300 hover:text-indigo-400  md:p-0">Peminjaman
                Fasilitas</a>
        </li>
        {{-- <li>
            <a href="{{ route('mahasiswa.laporan') }}"
                class="block py-2 px-3 text-slate-50 rounded transition-colors duration-300 hover:text-indigo-400  md:p-0">Laporan</a>
        </li> --}}
    @endif
@else
    <li>
        <a href="{{ route('home.fasilitas') }}"
            class="block py-2 px-3 text-slate-50 rounded transition-colors duration-300 hover:text-indigo-400  md:p-0">Fasilitas</a>
    </li>
    <li>
        <a href="{{ route('home.kegiatan') }}"
            class="block py-2 px-3 text-slate-50 rounded transition-colors duration-300 hover:text-indigo-400  md:p-0">Kegiatan
            Ormawa</a>
    </li>
@endif
