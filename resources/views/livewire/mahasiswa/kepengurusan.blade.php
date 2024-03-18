<div>
    <div class="">
        <div class="bg-gray-50 mx-3 px-4 py-5 rounded-lg shadow-sm">
            <h1 class="px-2 ps-4 text-indigo-900 text-4xl font-bold drop-shadow-sm "><i class="fa-solid fa-peoples"></i>
                Kepengurusan
            </h1>
        </div>
        <div class="mx-6 mt-4 p-5 bg-gray-50 text-gray-800 border border-gray-200 rounded-lg shadow-sm">
            <div class="flex flex-wrap">
                <h5 class="mb-2 text-2xl font-bold tracking-tight text-indigo-800 dark:text-white">Manajemen Kepengurusan
                </h5>
                <button wire:click="editStateModal()" data-modal-target="tambah-modal" data-modal-toggle="tambah-modal"
                    class="mb-2 ms-auto py-2 px-3 rounded-lg bg-green-500 text-white font-bold  hover:bg-green-600 focus:ring-4 focus:outline-none focus:ring-green-300 transition duration-300 ease-in-out transform
                    hover:scale-105 hover:shadow-sm"
                    type="button">
                    <i class="me-2 fa-solid fa-plus"></i>Tambah data
                </button>
            </div>
            <x-flash-message />
            <div class="mt-3 relative overflow-x-auto">
                <table class="w-full text-sm text-left rtl:text-right text-gray-700">
                    <thead class="text-xs text-gray-50 uppercase bg-indigo-700">
                        <tr>
                            <th scope="col" class="px-4 py-3">
                                No
                            </th>
                            <th scope="col" class="px-3 py-2">
                                Periode Kepengurusan
                            </th>
                            <th scope="col" class="px-3 py-2">
                                Nama Ormawa
                            </th>
                            <th scope="col" class="px-3 py-2">
                                File SK
                            </th>
                            <th scope="col" class="px-3 py-2">
                                Status
                            </th>
                            <th scope="col" class="w-56 px-3 py-2">
                                Aksi
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($dataKepengurusan as $key => $value)
                            <tr class="bg-white border-b ">
                                <th scope="row" class="px-6 py-4">
                                    {{ $dataKepengurusan->firstItem() + $key }}
                                </th>
                                <td class="px-3 py-2">
                                    {{ $value->periode->name }}
                                </td>
                                <td class="px-3 py-2">
                                    {{ $value->ormawa->name }}
                                </td>
                                <td class="px-3 py-2">
                                    <button wire:click.prevent="lihat('{{ $value->file_sk }}')"
                                        data-modal-target="lihat-modal" data-modal-toggle="lihat-modal"
                                        class="mb-2 me-2 py-2 px-3 rounded-lg bg-green-500 text-white font-bold hover:bg-green-600 focus:ring-4 focus:outline-none focus:ring-green-400 transition duration-300 ease-in-out transform hover:scale-105 hover:shadow-sm"
                                        type="button">
                                        <i class="me-2 fa-solid fa-eye"></i>Lihat
                                    </button>
                                </td>
                                <td class="px-3 py-2">
                                    @if ($value->status === 'belum')
                                        <span
                                            class="bg-gray-100 text-gray-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded-full">Menunggu</span>
                                    @endif
                                    @if ($value->status === 'tolak')
                                        <span
                                            class="bg-red-100 text-red-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded-full">Ditolak</span>
                                    @endif
                                    @if ($value->status === 'setujui')
                                        <span
                                            class="bg-green-100 text-green-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded-full">Disetujui</span>
                                    @endif
                                </td>
                                <td class="px-3 py-2">
                                    <div class="flex flex-wrap">
                                        <a wire:click.prevent="edit('{{ $value->id }}')"
                                            class="mb-2 me-2 py-2 px-3 rounded-lg bg-yellow-300 text-white font-bold hover:bg-yellow-400 focus:ring-4 focus:outline-none focus:ring-yellow-200 transition duration-300 ease-in-out transform hover:scale-105 hover:shadow-sm"
                                            href="#" data-modal-toggle="tambah-modal">
                                            <i class="me-2 fa-solid fa-pencil"></i>Edit</a>
                                        <a wire:click.prevent="delete('{{ $value->id }}')"
                                            class="mb-2 me-2 py-2 px-3 rounded-lg bg-red-600 text-white font-bold hover:bg-red-700 focus:ring-4 focus:outline-none focus:ring-red-300 transition duration-300 ease-in-out transform hover:scale-105 hover:shadow-sm"
                                            href="#" data-modal-target="hapus-modal"
                                            data-modal-toggle="hapus-modal">
                                            <i class="me-2 fa-solid fa-trash"></i>Hapus</a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="mt-3">
                    <div class="livewire-pagination"> {{ $dataKepengurusan->links() }}</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Pengguna -->
    <div wire:ignore.self id="tambah-modal" tabindex="-1" aria-hidden="true"
        class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative p-4 w-full max-w-md max-h-full">
            <!-- Modal content -->
            <div class="relative bg-gray-50 rounded-lg shadow">
                <!-- Modal header -->
                <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                    @if ($editModal == true)
                        <h3 class="text-xl font-semibold text-gray-700 ">
                            Edit Periode Kepengurusan
                        </h3>
                    @else
                        <h3 class="text-xl font-semibold text-gray-700 ">
                            Tambah Periode Kepengurusan
                        </h3>
                    @endif
                    <button type="button"
                        class="end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                        data-modal-hide="tambah-modal">
                        X
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <div wire:ignore.self class="p-4 md:p-5">
                    @if ($editModal == true)
                        <form wire:submit="update" class="space-y-4">
                        @else
                            <form wire:submit="save" class="space-y-4">
                    @endif
                    <div>
                        <label for="periode_id"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Pilih
                            Periode</label>
                        <select wire:model="periode_id" id="periode_id"
                            class="bg-gray-50 border border-gray-300 text-gray-700 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                            <option value="">Pilih Periode</option>
                            @foreach ($dataPeriode as $key => $value)
                                <option value="{{ $value->id }}">{{ $value->name }}</option>
                            @endforeach
                        </select>
                        @error('periode_id')
                            <small class="text-red-600 font-medium">{{ $message }}</small>
                        @enderror
                    </div>
                    <div>
                        <label for="file_sk" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">File
                            SK</label>
                        <input type="file" wire:model="file_sk" accept=".pdf"
                            class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none">
                        <p class="mt-1
                            text-sm text-gray-500 dark:text-gray-300"
                            id="file_input_help">File PDF (Maksimal
                            2MB).</p>
                        <div wire:loading wire:target="file_sk"
                            class="px-3 py-1 text-sm font-medium leading-none text-center text-green-800 bg-green-200 rounded-lg animate-pulse">
                            Sedang mengupload file...</div>
                        @error('file_sk')
                            <small class="text-red-600 font-medium">{{ $message }}</small>
                        @enderror
                    </div>
                    <button type="submit"
                        class="mt-5 w-full text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-green-300 transition duration-300 ease-in-out transform
                            hover:scale-105 hover:shadow-sm0 font-medium rounded-lg text-sm px-5 py-2.5 text-center"
                        data-modal-hide="tambah-modal">
                        @if ($editModal == true)
                            Update data
                        @else
                            Tambah data
                        @endif
                    </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div wire:ignore.self id="hapus-modal" tabindex="-1"
        class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative p-4 w-full max-w-md max-h-full">
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <button type="button"
                    class="absolute top-3 end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                    data-modal-hide="hapus-modal">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
                <div class="p-4 md:p-5 text-center">
                    <svg class="mx-auto mb-4 text-gray-400 w-12 h-12 dark:text-gray-200" aria-hidden="true"
                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                    </svg>
                    <form wire:submit="deleteConfirm">
                        <h3 class="mb-5 text-lg font-normal text-gray-500 dark:text-gray-400">Anda yakin ingin
                            menghapus
                            periode kepengurusan ini?</h3>
                        <button data-modal-hide="hapus-modal" type="submit"
                            class="text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center">
                            Iya, Hapus
                        </button>
                        <button data-modal-hide="hapus-modal" type="button"
                            class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">Batal</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Main modal -->
    <div wire:ignore.self id="lihat-modal" tabindex="-1" aria-hidden="true"
        class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative p-4 w-full max-h-full">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <!-- Modal header -->
                <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                        File SK
                    </h3>
                    <button type="button"
                        class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                        data-modal-hide="lihat-modal">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <!-- Modal body -->
                <div class="p-4 md:p-5 space-y-4">
                    <embed class="w-full h-screen" src="{{ asset('storage/' . $embed_file_sk) }}">
                </div>
            </div>
        </div>
    </div>
</div>
