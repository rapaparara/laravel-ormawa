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

                <select wire:model.live="byOrmawa" name="byOrmawa"
                    class="ms-auto bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-48 md:w-64  p-2.5">
                    <option value="">Semua Ormawa</option>
                    @foreach ($dataOrmawa as $key => $value)
                        <option value="{{ $value->id }}">{{ $value->name }}</option>
                    @endforeach
                </select>
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
                            <a href="#" wire:click.prevent="lihat('{{ $value->id }}')"
                                data-modal-target="lihat-modal" data-modal-toggle="lihat-modal"
                                class="inline-flex
                                items-center px-3 py-2 text-sm font-medium text-center text-white bg-indigo-700
                                rounded-lg hover:bg-indigo-800 focus:ring-4 focus:outline-none focus:ring-indigo-300">
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

    <!-- Lihat modal -->
    <div wire:ignore.self id="lihat-modal" tabindex="-1" aria-hidden="true"
        class="hidden overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative p-2 ">
            <!-- Modal content -->
            <div class="relative bg-slate-50 rounded-lg shadow dark:bg-gray-700">
                <!-- Modal header -->
                <div class="flex items-center justify-between p-2 md:p-3 border-b rounded-t dark:border-gray-600">
                    <button type="button"
                        class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                        data-modal-hide="lihat-modal">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <!-- Modal body -->
                <div class="p-4 md:p-5 space-y-3" style="max-height: 70vh; overflow-y: auto;">
                    <h5 class="mb-2 text-2xl font-bold tracking-tight text-indigo-800 dark:text-white">
                        {{ $name . ' - ' . $ormawa }}
                    </h5>
                    <img class="h-96 w-full object-cover rounded-lg" src="{{ asset('storage/' . $image) }}"
                        alt="image description">
                    <div class=" bg-indigo-600 text-slate-50 text-lg text-center font-medium px-2.5 py-2 rounded-lg">
                        {{ \Carbon\Carbon::parse($waktu_mulai)->isoFormat('D MMMM YYYY', 'Do MMMM YYYY') }}
                        -
                        {{ \Carbon\Carbon::parse($waktu_selesai)->isoFormat('D MMMM YYYY', 'Do MMMM YYYY') }}
                    </div>
                    <p class="mb-3 max-w-screen-xl text-lg text-gray-500">{{ $deskripsi }}</p>
                    @if (!empty($dataTahapan))
                        @foreach ($dataTahapan as $tahapan)
                            <div class="">
                                <h5 class="text-xl font-bold tracking-tight text-indigo-800 dark:text-white">
                                    {{ $tahapan->name }}
                                </h5>
                                @if ($tahapan->status === 'belum')
                                    <span
                                        class="bg-gray-100 text-gray-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded-full">Belum
                                        dimulai</span>
                                @endif
                                @if ($tahapan->status === 'sementara')
                                    <span
                                        class="bg-yellow-300 text-white text-xs font-medium me-2 px-2.5 py-0.5 rounded-full">Sementara</span>
                                @endif
                                @if ($tahapan->status === 'selesai')
                                    <span
                                        class="bg-green-100 text-green-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded-full">Selesai</span>
                                @endif
                            </div>
                            <div class="grid lg:grid-cols-2 gap-3">
                                @foreach ($dataDokumentasi as $dokumentasi)
                                    @if ($dokumentasi['tahapan_kegiatan_id'] == $tahapan->id)
                                        <a href="{{ asset('storage/' . $dokumentasi['file_dokumentasi']) }}"
                                            target="_blank">
                                            <img class="h-96 w-full lg:w-1/2 object-cover rounded-lg transition duration-300 ease-in-out transform hover:scale-90"
                                                src="{{ asset('storage/' . $dokumentasi['file_dokumentasi']) }}"
                                                alt="dokumentasi">
                                        </a>
                                    @endif
                                @endforeach
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
    </div>


</div>
