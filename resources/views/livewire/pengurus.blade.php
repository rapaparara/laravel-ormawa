<div>
    <div class="">
        <div class="mx-6 p-5 bg-gray-50 text-gray-800 border border-gray-200 rounded-lg shadow-sm">
            <div class="flex flex-wrap">
                <h5 class="mb-2 text-2xl font-bold tracking-tight text-indigo-800 dark:text-white">Manajemen pengurus
                    ormawa
                </h5>
                @if (session('user_role') == 'mahasiswa')
                    <div class="ms-auto flex gap-3">
                        <button wire:click="editStateModal()" data-modal-target="tambah-pengurus-modal"
                            data-modal-toggle="tambah-pengurus-modal"
                            class="mb-2 ms-auto py-2 px-3 rounded-lg bg-green-500 text-white font-bold  hover:bg-green-600 focus:ring-4 focus:outline-none focus:ring-green-300 transition duration-300 ease-in-out transform
                    hover:scale-105 hover:shadow-sm"
                            type="button">
                            <i class="me-2 fa-solid fa-plus"></i>Tambah data
                        </button>
                        <button data-modal-target="upload-modal" data-modal-toggle="upload-modal"
                            class="mb-2 ms-auto py-2 px-3 rounded-lg bg-green-500 text-white font-bold  hover:bg-green-600 focus:ring-4 focus:outline-none focus:ring-green-300 transition duration-300 ease-in-out transform
                hover:scale-105 hover:shadow-sm"
                            type="button">
                            <i class="me-2 fa-solid fa-upload"></i>Upload data
                        </button>
                    </div>
                @endif
            </div>
            <x-flash-message />
            <div class="flex flex-nowrap">
                <i class="py-2 me-2 text-2xl fa-solid fa-search"></i>
                <input wire:model.live="katakunci" type="text"
                    class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-48 md:w-64  p-2.5"
                    placeholder="Search...">
            </div>
            <div class="mt-3 relative overflow-x-auto">
                <table class="w-full text-sm text-left rtl:text-right text-gray-700">
                    <thead class="text-xs text-gray-50 uppercase bg-indigo-700">
                        <tr>
                            <th scope="col" class="px-4 py-3">
                                No
                            </th>
                            <th scope="col" class="px-3 py-2">
                                NIM
                            </th>
                            <th scope="col" class="px-3 py-2">
                                Nama
                            </th>
                            <th scope="col" class="px-3 py-2">
                                Ormawa
                            </th>
                            <th scope="col" class="px-3 py-2">
                                Periode Kepengurusan
                            </th>
                            @if (session('user_role') == 'mahasiswa')
                                <th scope="col" class="w-56 px-3 py-2">
                                    Aksi
                                </th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($dataPengurus as $key => $value)
                            <tr class="bg-white border-b ">
                                <th scope="row" class="px-6 py-4">
                                    {{ $dataPengurus->firstItem() + $key }}
                                </th>
                                <td class="px-3 py-2">
                                    {{ $value->nim }}
                                </td>
                                <td class="px-3 py-2">
                                    {{ $value->nama }}
                                </td>
                                <td class="px-3 py-2">
                                    {{ $value->kepengurusan->ormawa->name }}
                                </td>
                                <td class="px-3 py-2">
                                    {{ $value->kepengurusan->periode->name }}
                                </td>
                                @if (session('user_role') == 'mahasiswa')
                                    <td class="px-3 py-2">
                                        <div class="flex flex-wrap">
                                            <a wire:click.prevent="edit('{{ $value->id }}')"
                                                class="mb-2 me-2 py-2 px-3 rounded-lg bg-yellow-300 text-white font-bold hover:bg-yellow-400 focus:ring-4 focus:outline-none focus:ring-yellow-200 transition duration-300 ease-in-out transform hover:scale-105 hover:shadow-sm"
                                                href="#" data-modal-toggle="tambah-pengurus-modal">
                                                <i class="me-2 fa-solid fa-pencil"></i>Edit</a>
                                            <a wire:click.prevent="delete('{{ $value->id }}')"
                                                class="mb-2 me-2 py-2 px-3 rounded-lg bg-red-600 text-white font-bold hover:bg-red-700 focus:ring-4 focus:outline-none focus:ring-red-300 transition duration-300 ease-in-out transform hover:scale-105 hover:shadow-sm"
                                                href="#" data-modal-target="hapus-pengurus-modal"
                                                data-modal-toggle="hapus-pengurus-modal">
                                                <i class="me-2 fa-solid fa-trash"></i>Hapus</a>
                                        </div>
                                    </td>
                                @endif
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="mt-3">
                    <div class="livewire-pagination"> {{ $dataPengurus->links() }}</div>
                </div>
            </div>
        </div>
    </div>

    @if (session('user_role') == 'mahasiswa')
        <!-- Modal Tambah -->
        <div wire:ignore.self id="tambah-pengurus-modal" tabindex="-1" aria-hidden="true"
            class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
            <div class="relative p-4 w-full max-w-md max-h-full">
                <!-- Modal content -->
                <div class="relative bg-gray-50 rounded-lg shadow">
                    <!-- Modal header -->
                    <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                        @if ($editModal == true)
                            <h3 class="text-xl font-semibold text-gray-700 ">
                                Edit Pengurus
                            </h3>
                        @else
                            <h3 class="text-xl font-semibold text-gray-700 ">
                                Tambah Pengurus
                            </h3>
                        @endif
                        <button type="button"
                            class="end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                            data-modal-hide="tambah-pengurus-modal">
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
                            <label for="kepengurusan_id"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Pilih Periode
                                Kepengurusan</label>
                            <select wire:model="kepengurusan_id" id="kepengurusan_id"
                                class="bg-gray-50 border border-gray-300 text-gray-700 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                                <option value="">Pilih Periode Kepengurusan</option>
                                @foreach ($dataKepengurusan as $key => $value)
                                    <option value="{{ $value->id }}">
                                        {{ $value->periode->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('kepengurusan_id')
                                <small class="text-red-600 font-medium">{{ $message }}</small>
                            @enderror
                        </div>
                        <div>
                            <label for="nim"
                                class="block mb-2 text-sm font-medium text-gray-700 dark:text-white">NIM</label>
                            <input wire:model="nim" type="text" name="nim" id="nim"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                                placeholder="Masukkan nim disini" required />
                            @error('nim')
                                <small class="text-red-600 font-medium">{{ $message }}</small>
                            @enderror
                        </div>
                        <div>
                            <label for="nama"
                                class="block mb-2 text-sm font-medium text-gray-700 dark:text-white">Nama
                                Pengurus</label>
                            <input wire:model="nama" type="text" name="nama" id="nama"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                                placeholder="Masukkan nama disini" required />
                            @error('nama')
                                <small class="text-red-600 font-medium">{{ $message }}</small>
                            @enderror
                        </div>
                        <button type="submit"
                            class="mt-5 w-full text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-green-300 transition duration-300 ease-in-out transform
                           hover:scale-105 hover:shadow-sm0 font-medium rounded-lg text-sm px-5 py-2.5 text-center"
                            data-modal-hide="tambah-pengurus-modal">
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

        <div wire:ignore.self id="hapus-pengurus-modal" tabindex="-1"
            class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
            <div class="relative p-4 w-full max-w-md max-h-full">
                <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                    <button type="button"
                        class="absolute top-3 end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                        data-modal-hide="hapus-pengurus-modal">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                    <div class="p-4 md:p-5 text-center">
                        <svg class="mx-auto mb-4 text-gray-400 w-12 h-12 dark:text-gray-200" aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                stroke-width="2" d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                        </svg>
                        <form wire:submit="deleteConfirm">
                            <h3 class="mb-5 text-lg font-normal text-gray-500 dark:text-gray-400">Anda yakin ingin
                                menghapus pengurus ini?</h3>
                            <button data-modal-hide="hapus-pengurus-modal" type="submit"
                                class="text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center">
                                Iya, Hapus
                            </button>
                            <button data-modal-hide="hapus-pengurus-modal" type="button"
                                class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">Batal</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Upload Pengurus -->
        <div wire:ignore.self id="upload-modal" tabindex="-1" aria-hidden="true"
            class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
            <div class="relative p-4 w-full max-w-md max-h-full">
                <!-- Modal content -->
                <div class="relative bg-gray-50 rounded-lg shadow">
                    <!-- Modal header -->
                    <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                        <h3 class="text-xl font-semibold text-gray-700 ">
                            Upload Data Pengurus
                        </h3>
                        <button type="button"
                            class="end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                            data-modal-hide="upload-modal">
                            X
                            <span class="sr-only">Close modal</span>
                        </button>
                    </div>
                    <div wire:ignore.self class="p-4 md:p-5">
                        <form wire:submit="uploadFile" class="space-y-4">
                            <div>
                                <label for="kepengurusan_id"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Pilih Periode
                                    Kepengurusan</label>
                                <select wire:model="kepengurusan_id" id="kepengurusan_id"
                                    class="bg-gray-50 border border-gray-300 text-gray-700 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                                    <option value="">Pilih Periode Kepengurusan</option>
                                    @foreach ($dataKepengurusan as $key => $value)
                                        <option value="{{ $value->id }}">
                                            {{ $value->periode->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('kepengurusan_id')
                                    <small class="text-red-600 font-medium">{{ $message }}</small>
                                @enderror
                            </div>
                            <div>
                                <label for="file_upload"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">File
                                    Upload</label>
                                <input type="file" wire:model="file_upload"
                                    class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none">
                                <p class="mt-1
                            text-sm text-gray-500 dark:text-gray-300"
                                    id="file_input_help">File Excel / CSV (Maksimal
                                    2MB).</p>
                                @error('file_upload')
                                    <small class="text-red-600 font-medium">{{ $message }}</small>
                                @enderror
                                <div wire:loading wire:target="file_upload"
                                    class="px-3 py-1 text-sm font-medium leading-none text-center text-green-800 bg-green-200 rounded-lg animate-pulse">
                                    Sedang mengupload file...</div>
                            </div>
                            <div class="w-full flex justify-center">
                                <a href="/" class="font-medium text-lg text-indigo-800">Download Format
                                    Disini</a>
                            </div>
                            <button type="submit"
                                class="mt-5 w-full text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-green-300 transition duration-300 ease-in-out transform
                        hover:scale-105 hover:shadow-sm0 font-medium rounded-lg text-sm px-5 py-2.5 text-center"
                                data-modal-hide="upload-modal">
                                Upload
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endif

</div>
