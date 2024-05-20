<div>
    <div>
        <div class="">
            <div class="mx-6 mt-4 p-5 bg-gray-50 text-gray-800 border border-gray-200 rounded-lg shadow-sm">
                <div class="flex flex-wrap">
                    <h5 class="mb-2 text-2xl font-bold tracking-tight text-indigo-800 dark:text-white">Manajemen
                        Kegiatan
                    </h5>
                    @if (session('user_role') == 'mahasiswa')
                        <button wire:click="editStateModal()" data-modal-target="tambah-modal"
                            data-modal-toggle="tambah-modal"
                            class="mb-2 ms-auto py-2 px-3 rounded-lg bg-green-500 text-white font-bold  hover:bg-green-600 focus:ring-4 focus:outline-none focus:ring-green-300 transition duration-300 ease-in-out transform
                hover:scale-105 hover:shadow-sm"
                            type="button">
                            <i class="me-2 fa-solid fa-plus"></i>Tambah data
                        </button>
                    @endif
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
                                    Nama Kegiatan
                                </th>
                                <th scope="col" class="px-3 py-2">
                                    Nama Ormawa
                                </th>
                                <th scope="col" class="md:max-w-md px-3 py-2">
                                    Deskripsi
                                </th>
                                <th scope="col" class="px-3 py-2">
                                    Waktu Kegiatan
                                </th>
                                <th scope="col" class="px-3 py-2">
                                    Gambar Kegiatan
                                </th>
                                @if (session('user_role') == 'mahasiswa')
                                    <th scope="col" class="w-56 px-3 py-2">
                                        Aksi
                                    </th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($dataKegiatan as $key => $value)
                                <tr class="bg-white border-b ">
                                    <th scope="row" class="px-6 py-4">
                                        {{ $dataKegiatan->firstItem() + $key }}
                                    </th>
                                    <td class="px-3 py-2">
                                        {{ $value->name }}
                                    </td>
                                    <td class="px-3 py-2">
                                        {{ $value->ormawa->name }}
                                    </td>
                                    <td class="md:max-w-md px-3 py-2">
                                        {{ mb_strlen($value->deskripsi, 'UTF-8') > 180 ? mb_substr($value->deskripsi, 0, 180, 'UTF-8') . '...' : $value->deskripsi }}
                                    </td>
                                    <td class="px-3 py-2">
                                        {{ \Carbon\Carbon::parse($value->waktu_mulai)->isoFormat('D MMMM YYYY', 'Do MMMM YYYY') }}
                                        -
                                        {{ \Carbon\Carbon::parse($value->waktu_selesai)->isoFormat('D MMMM YYYY', 'Do MMMM YYYY') }}
                                    </td>
                                    <td class="max-w-lg px-3 py-2">
                                        <img class="h-32 w-full object-cover"
                                            src="{{ asset('storage/' . $value->image) }}" alt="Gambar Kegiatan">
                                    </td>
                                    @if (session('user_role') == 'mahasiswa')
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
                                    @endif
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="mt-3">
                        <div class="livewire-pagination"> {{ $dataKegiatan->links() }}</div>
                    </div>
                </div>
            </div>

            @livewire('tahapan-kegiatan')
        </div>

        @if (session('user_role') == 'mahasiswa')
            <!-- Modal Pengguna -->
            <div wire:ignore.self id="tambah-modal" tabindex="-1" aria-hidden="true"
                class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                <div class="relative p-4 w-full max-w-md max-h-full">
                    <!-- Modal content -->
                    <div class="relative bg-gray-50 rounded-lg shadow">
                        <!-- Modal header -->
                        <div
                            class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                            @if ($editModal == true)
                                <h3 class="text-xl font-semibold text-gray-700 ">
                                    Edit Kegiatan
                                </h3>
                            @else
                                <h3 class="text-xl font-semibold text-gray-700 ">
                                    Tambah Kegiatan
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
                                <label for="kepengurusan_id"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Pilih
                                    Periode Kepengurusan</label>
                                <select wire:model="kepengurusan_id" id="kepengurusan_id"
                                    class="bg-gray-50 border border-gray-300 text-gray-700 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                                    <option value="">Pilih Periode Kepengurusan</option>
                                    @foreach ($dataKepengurusan as $key => $value)
                                        <option value="{{ $value->id }}">{{ $value->periode->name }}</option>
                                    @endforeach
                                </select>
                                @error('kepengurusan_id')
                                    <small class="text-red-600 font-medium">{{ $message }}</small>
                                @enderror
                            </div>
                            <div>
                                <label for="name"
                                    class="block mb-2 text-sm font-medium text-gray-700 dark:text-white">Nama
                                    Kegiatan</label>
                                <input wire:model="name" type="text" name="name" id="name"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                                    placeholder="Masukkan nama kegiatan" required />
                                @error('name')
                                    <small class="text-red-600 font-medium">{{ $message }}</small>
                                @enderror
                            </div>
                            <div>
                                <label for="deskripsi"
                                    class="block mb-2 text-sm font-medium text-gray-700 dark:text-white">Deskripsi
                                    Kegiatan</label>
                                <textarea wire:model="deskripsi" name="deskripsi" id="deskripsi" cols="20" rows="5"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                        </textarea>
                                @error('deskripsi')
                                    <small class="text-red-600 font-medium">{{ $message }}</small>
                                @enderror
                                <p class="mt-1
                            text-sm text-gray-500 dark:text-gray-300"
                                    id="file_input_help">Deskripsi minimal 20 karakter.</p>
                            </div>
                            <div>
                                <label for="waktu_mulai"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Waktu
                                    Mulai</label>
                                <input wire:model="waktu_mulai" type="date"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 "
                                    required>
                                @error('waktu_mulai')
                                    <small class="text-red-600 font-medium">{{ $message }}</small>
                                @enderror
                            </div>
                            <div>
                                <label for="waktu_selesai" class="block mb-2 text-sm font-medium text-gray-900">Waktu
                                    Selesai</label>
                                <input wire:model="waktu_selesai" type="date"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 "
                                    required>
                                @error('waktu_selesai')
                                    <small class="text-red-600 font-medium">{{ $message }}</small>
                                @enderror
                            </div>
                            <div>
                                <label for="image"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Gambar
                                    Kegiatan</label>
                                @if ($editModal == true)
                                    <input type="file" wire:model="temp_image"
                                        class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none">
                                    <p class="mt-1
                        text-sm text-gray-500 dark:text-gray-300"
                                        id="file_input_help">File JPG/JPEG (Maksimal
                                        5MB).</p>
                                    @error('temp_image')
                                        <small class="text-red-600 font-medium">{{ $message }}</small>
                                    @enderror
                                @else
                                    <input type="file" wire:model="image"
                                        class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none"
                                        accept="image/*" required>
                                    <p class="mt-1
                            text-sm text-gray-500 dark:text-gray-300"
                                        id="file_input_help">File JPG/JPEG (Maksimal
                                        5MB).</p>
                                    @error('image')
                                        <small class="text-red-600 font-medium">{{ $message }}</small>
                                    @enderror
                                @endif
                                <div wire:loading wire:target="image"
                                    class="px-3 py-1 text-sm font-medium leading-none text-center text-green-800 bg-green-200 rounded-lg animate-pulse">
                                    Sedang mengupload file...</div>
                                <div wire:loading wire:target="temp_image"
                                    class="px-3 py-1 text-sm font-medium leading-none text-center text-green-800 bg-green-200 rounded-lg animate-pulse">
                                    Sedang mengupload file...</div>
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
                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                fill="none" viewBox="0 0 14 14">
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
                                    menghapus
                                    kegiatan ini?</h3>
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
        @endif


        <!-- Main modal -->
        {{-- <div wire:ignore.self id="lihat-modal" tabindex="-1" aria-hidden="true"
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
                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                fill="none" viewBox="0 0 14 14">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                            </svg>
                            <span class="sr-only">Close modal</span>
                        </button>
                    </div>
                    <!-- Modal body -->
                    <div class="p-4 md:p-5 space-y-4">
                        <embed class="w-full h-screen" src="{{ asset('storage/' . $embed_image) }}">
                    </div>
                </div>
            </div>
        </div> --}}


        {{-- <div wire:ignore.self id="ganti-modal" tabindex="-1" aria-hidden="true"
            class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
            <div class="relative p-4 w-full max-w-md max-h-full">
                <!-- Modal content -->
                <div class="relative bg-gray-50 rounded-lg shadow">
                    <!-- Modal header -->
                    <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                        <h3 class="text-xl font-semibold text-gray-700 ">
                            Ubah Status
                        </h3>
                        <button type="button"
                            class="end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                            data-modal-hide="ganti-modal" data-modal-target="ganti-modal">
                            X
                            <span class="sr-only">Close modal</span>
                        </button>
                    </div>
                    <div wire:ignore.self class="p-4 md:p-5">
                        <form wire:submit="updateStatus" class="space-y-4">
                            <div>
                                <label for="role"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Pilih
                                    Status</label>
                                <select wire:model="status" id="role"
                                    class="bg-gray-50 border border-gray-300 text-gray-700 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                                    <option value="">Pilih Status</option>
                                    <option value="belum">Belum</option>
                                    <option value="tolak">Tolak</option>
                                    <option value="setujui">Setujui</option>
                                </select>
                                @error('status')
                                    <small class="text-red-600 font-medium">{{ $message }}</small>
                                @enderror
                            </div>
                            <button type="submit"
                                class="mt-5 w-full text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-green-300 transition duration-300 ease-in-out transform
                            hover:scale-105 hover:shadow-sm0 font-medium rounded-lg text-sm px-5 py-2.5 text-center"
                                data-modal-hide="ganti-modal">
                                Ubah Status
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div> --}}
    </div>

</div>
