<div>
    <div>
        <div class="bg-gray-50 mx-3 px-4 py-5 rounded-lg shadow-sm">
            <h1 class="px-2 ps-4 text-indigo-900 text-4xl font-bold  drop-shadow-sm"><i
                    class="fa-solid fa-person-running"></i> Kegiatan
                Ormawa
            </h1>
        </div>
        <div class="mx-6 mt-4 p-5 bg-gray-50 text-gray-800 border border-gray-200 rounded-lg shadow-sm">
            <h5 class="mb-2 text-2xl font-bold tracking-tight text-indigo-800 dark:text-white">Daftar kegiatan ormawa
            </h5>
            <div class="flex flex-nowrap">
                <i class="py-2 me-2 text-2xl fa-solid fa-search"></i>
                <input wire:model.live="katakunci" type="text"
                    class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-48 md:w-64  p-2.5"
                    placeholder="Search...">
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-4">
                @foreach ($dataKegiatan as $value)
                    <div class="max-w-sm bg-white border border-gray-200 rounded-lg shadow-lg">
                        <img class="h-96 w-full object-cover rounded-t-lg" src="{{ asset('storage/' . $value->image) }}"
                            alt="{{ $value->name }}" />
                        <div class="p-5">
                            <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-800">{{ $value->name }}</h5>
                            <h5 class="text-md font-semibold tracking-tight text-gray-600">
                                {{ $value->ormawa->name }}
                                Periode {{ $value->kepengurusan->periode->name }}
                            </h5>
                            <span class="bg-indigo-100 text-gray-800 text-xs font-medium px-2.5 py-0.5 rounded-lg">
                                {{ \Carbon\Carbon::parse($value->waktu_mulai)->isoFormat('D MMMM YYYY', 'Do MMMM YYYY') }}
                                -
                                {{ \Carbon\Carbon::parse($value->waktu_selesai)->isoFormat('D MMMM YYYY', 'Do MMMM YYYY') }}
                            </span>
                            <p class="mb-3 mt-3 font-normal text-gray-700">
                                {{ str_word_count($value->deskripsi) > 60 ? substr($value->deskripsi, 0, 200) . '...' : $value->deskripsi }}
                            </p>
                            <a href="#"
                                class="inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white bg-indigo-700 rounded-lg hover:bg-indigo-800 focus:ring-4 focus:outline-none focus:ring-indigo-300">
                                Lihat detail
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="mt-3">
                <div class="livewire-pagination"> {{ $dataKegiatan->links() }}</div>
            </div>
        </div>
    </div>
</div>
