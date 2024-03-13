@if (session('user_id'))
    @if (session('user_role') == 'admin')
        <li>
            <a href="{{ route('home') }}"
                class="block py-2 px-3 text-slate-50 rounded transition-colors duration-300 hover:text-indigo-400 hover:border-b-2 hover:border-indigo-400 md:p-0">Home</a>
        </li>
        <li>
            <a href="{{ route('admin.pengguna') }}"
                class="block py-2 px-3 text-slate-50 rounded transition-colors duration-300 hover:text-indigo-400 hover:border-b-2 hover:border-indigo-400 md:p-0">Pengguna</a>
        </li>
        <li>
            <a href="{{ route('admin.pengguna') }}"
                class="block py-2 px-3 text-slate-50 rounded transition-colors duration-300 hover:text-indigo-400 hover:border-b-2 hover:border-indigo-400 md:p-0">Kemahasiswaan</a>
        </li>
    @endif
    @if (session('user_role') == 'kemahasiswaan')
        <li>
            <a href="{{ route('kemahasiswaan.index') }}"
                class="block py-2 px-3 text-slate-50 rounded transition-colors duration-300 hover:text-indigo-400 hover:border-b-2 hover:border-indigo-400 md:p-0">Home</a>
        </li>
        <li>
            <a href="{{ route('home') }}"
                class="block py-2 px-3 text-slate-50 rounded transition-colors duration-300 hover:text-indigo-400 hover:border-b-2 hover:border-indigo-400 md:p-0">Pengguna</a>
        </li>
        <li>
            <a href="{{ route('home') }}"
                class="block py-2 px-3 text-slate-50 rounded transition-colors duration-300 hover:text-indigo-400 hover:border-b-2 hover:border-indigo-400 md:p-0">Fasilitas</a>
        </li>
        <li>
            <a href="{{ route('home') }}"
                class="block py-2 px-3 text-slate-50 rounded transition-colors duration-300 hover:text-indigo-400 hover:border-b-2 hover:border-indigo-400 md:p-0">Ormawa</a>
        </li>
        <li>
            <a href="{{ route('home') }}"
                class="block py-2 px-3 text-slate-50 rounded transition-colors duration-300 hover:text-indigo-400 hover:border-b-2 hover:border-indigo-400 md:p-0">Kegiatan
                Ormawa</a>
        </li>
    @endif
    @if (session('user_role') == 'mahasiswa')
        <li>
            <a href="{{ route('mahasiswa.index') }}"
                class="block py-2 px-3 text-slate-50 rounded transition-colors duration-300 hover:text-indigo-400 hover:border-b-2 hover:border-indigo-400 md:p-0">Home</a>
        </li>
        <li>
            <a href="{{ route('home') }}"
                class="block py-2 px-3 text-slate-50 rounded transition-colors duration-300 hover:text-indigo-400 hover:border-b-2 hover:border-indigo-400 md:p-0">Pengurus</a>
        </li>
        <li>
            <a href="{{ route('home') }}"
                class="block py-2 px-3 text-slate-50 rounded transition-colors duration-300 hover:text-indigo-400 hover:border-b-2 hover:border-indigo-400 md:p-0">Kegiatan</a>
        </li>
    @endif
@else
    <li>
        <a href="{{ route('home') }}"
            class="block py-2 px-3 text-slate-50 rounded transition-colors duration-300 hover:text-indigo-400 hover:border-b-2 hover:border-indigo-400 md:p-0"
            aria-current="page">Home</a>
    </li>
    <li>
        <a href="{{ route('home.fasilitas') }}"
            class="block py-2 px-3 text-slate-50 rounded transition-colors duration-300 hover:text-indigo-400 hover:border-b-2 hover:border-indigo-400 md:p-0">Fasilitas</a>
    </li>
    <li>
        <a href="{{ route('home.kegiatan') }}"
            class="block py-2 px-3 text-slate-50 rounded transition-colors duration-300 hover:text-indigo-400 hover:border-b-2 hover:border-indigo-400 md:p-0">Kegiatan
            Ormawa</a>
    </li>
@endif
