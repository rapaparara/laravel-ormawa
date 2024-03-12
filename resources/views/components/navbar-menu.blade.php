@if (session('user_id'))
    @if (session('user_role') == 'admin')
        <li>
            <a wire:navigate href="{{ route('home') }}"
                class="block py-2 px-3 text-slate-50 rounded hover:text-indigo-200 md:p-0">Home</a>
        </li>
        <li>
            <a wire:navigate href="{{ route('admin.pengguna') }}"
                class="block py-2 px-3 text-slate-50 rounded hover:text-indigo-200 md:p-0">Pengguna</a>
        </li>
    @endif
    @if (session('user_role') == 'kemahasiswaan')
        <li>
            <a wire:navigate href="{{ route('kemahasiswaan.index') }}"
                class="block py-2 px-3 text-slate-50 rounded hover:text-indigo-200 md:p-0">Home</a>
        </li>
        <li>
            <a wire:navigate href="{{ route('home') }}"
                class="block py-2 px-3 text-slate-50 rounded hover:text-indigo-200 md:p-0">Pengguna</a>
        </li>
        <li>
            <a wire:navigate href="{{ route('home') }}"
                class="block py-2 px-3 text-slate-50 rounded hover:text-indigo-200 md:p-0">Fasilitas</a>
        </li>
        <li>
            <a wire:navigate href="{{ route('home') }}"
                class="block py-2 px-3 text-slate-50 rounded hover:text-indigo-200 md:p-0">Ormawa</a>
        </li>
        <li>
            <a wire:navigate href="{{ route('home') }}"
                class="block py-2 px-3 text-slate-50 rounded hover:text-indigo-200 md:p-0">Kegiatan Ormawa</a>
        </li>
    @endif
    @if (session('user_role') == 'mahasiswa')
        <li>
            <a wire:navigate href="{{ route('mahasiswa.index') }}"
                class="block py-2 px-3 text-slate-50 rounded hover:text-indigo-200 md:p-0">Home</a>
        </li>
        <li>
            <a wire:navigate href="{{ route('home') }}"
                class="block py-2 px-3 text-slate-50 rounded hover:text-indigo-200 md:p-0">Pengurus</a>
        </li>
        <li>
            <a wire:navigate href="{{ route('home') }}"
                class="block py-2 px-3 text-slate-50 rounded hover:text-indigo-200 md:p-0">Kegiatan</a>
        </li>
    @endif
@else
    <li>
        {{-- <a wire:navigate href="{{ route('home') }}"
        class="block py-2 px-3 text-slate-50 font-semibold underline rounded md:bg-transparent md:p-0"
        aria-current="page">Home</a> --}}
        <a wire:navigate href="{{ route('home') }}"
            class="block py-2 px-3 text-slate-50 rounded hover:text-indigo-200 md:p-0" aria-current="page">Home</a>
    </li>
    <li>
        <a wire:navigate href="{{ route('home.fasilitas') }}"
            class="block py-2 px-3 text-slate-50 rounded hover:text-indigo-200 md:p-0">Fasilitas</a>
    </li>
    <li>
        <a wire:navigate href="{{ route('home.kegiatan') }}"
            class="block py-2 px-3 text-slate-50 rounded hover:text-indigo-200 md:p-0 ">Kegiatan Ormawa</a>
    </li>
@endif
