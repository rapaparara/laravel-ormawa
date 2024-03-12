<div>
    <div class="">
        <div class="bg-gray-50 mx-3 px-4 py-5 rounded-lg shadow-sm">
            <h1 class="px-2 ps-4 text-indigo-900 text-4xl font-bold drop-shadow-sm "><i class="fa-solid fa-users"></i>
                Pengguna
            </h1>
        </div>
        <div class="mx-6 mt-4 p-5 bg-gray-50 text-gray-800 border border-gray-200 rounded-lg shadow-sm">
            <div class="flex flex-wrap">
                <h5 class="mb-2 text-2xl font-bold tracking-tight text-indigo-800 dark:text-white">Manajemen pengguna
                </h5>
                <button data-modal-target="tambah-modal" data-modal-toggle="tambah-modal"
                    class="mb-2 ms-auto py-2 px-3 rounded-lg bg-green-500 text-white font-bold" type="button">
                    <i class="me-2 fa-solid fa-plus"></i>Tambah data
                </button>
            </div>
            <x-flash-message />
            <div class="mt-3 relative overflow-x-auto">
                <table class="w-full text-sm text-left rtl:text-right text-gray-700">
                    <thead class="text-xs text-gray-50 uppercase bg-indigo-700">
                        <tr>
                            <th scope="col" class="px-3 py-2">
                                No
                            </th>
                            <th scope="col" class="px-3 py-2">
                                Nama
                            </th>
                            <th scope="col" class="px-3 py-2">
                                Username
                            </th>
                            <th scope="col" class="px-3 py-2">
                                Role
                            </th>
                            <th scope="col" class="px-3 py-2">
                                Aksi
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($dataPengguna as $key => $value)
                            <tr class="bg-white border-b">
                                <th scope="row" class="px-6 py-4">
                                    {{ $dataPengguna->firstItem() + $key }}
                                </th>
                                <td class="px-3 py-2">
                                    {{ $value->name }}
                                </td>
                                <td class="px-3 py-2">
                                    {{ $value->username }}
                                </td>
                                <td class="px-3 py-2">
                                    {{ $value->role }}
                                </td>
                                <td class="px-3 py-2">
                                    <div class="flex flex-wrap">
                                        <a class="mb-2 me-2 py-2 px-3 rounded-lg bg-yellow-300 text-white font-bold"
                                            href="">
                                            <i class="me-2 fa-solid fa-pencil"></i>Edit</a>
                                        <a class="mb-2 me-2 py-2 px-3 rounded-lg bg-red-600 text-white font-bold"
                                            href="">
                                            <i class="me-2 fa-solid fa-trash"></i>Hapus</a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="mt-3">
                    {{ $dataPengguna->links() }}
                </div>
            </div>
        </div>
    </div>

    <!-- Tambah modal -->
    <div id="tambah-modal" tabindex="-1" aria-hidden="true"
        class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative p-4 w-full max-w-md max-h-full">
            <!-- Modal content -->
            <div class="relative bg-gray-50 rounded-lg shadow">
                <!-- Modal header -->
                <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                    <h3 class="text-xl font-semibold text-gray-700 ">
                        Tambah Pengguna
                    </h3>
                    <button type="button"
                        class="end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                        data-modal-hide="tambah-modal">
                        X
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <!-- Modal body -->
                <div wire:ignore.self class="p-4 md:p-5">
                    <form wire:submit="save" class="space-y-4" action="#">
                        <div>
                            <label for="name"
                                class="block mb-2 text-sm font-medium text-gray-700 dark:text-white">Nama</label>
                            <input wire:model="form.name" type="text" name="name" id="name"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                                placeholder="Masukkan nama disini" required />
                            @error('form.name')
                                <small class="text-red-600 font-medium">{{ $message }}</small>
                            @enderror
                        </div>
                        <div>
                            <label for="username"
                                class="block mb-2 text-sm font-medium text-gray-700 dark:text-white">Username</label>
                            <input wire:model="form.username" type="text" name="username" id="username"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                                placeholder="Masukkan username disini" required />
                            @error('form.username')
                                <small class="text-red-600 font-medium">{{ $message }}</small>
                            @enderror
                        </div>
                        <div>
                            <label for="password"
                                class="block mb-2 text-sm font-medium text-gray-700 dark:text-white">Password</label>
                            <input wire:model="form.password" type="password" name="password" id="password"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                                placeholder="Masukkan password disini" required />
                            @error('form.password')
                                <small class="text-red-600 font-medium">{{ $message }}</small>
                            @enderror
                        </div>
                        <div>
                            <label for="role"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Pilih Role</label>
                            <select wire:model="form.role" id="role"
                                class="bg-gray-50 border border-gray-300 text-gray-700 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                                <option value="">Pilih Role</option>
                                <option value="admin">Admin</option>
                                <option value="kemahasiswaan">Kemahasiswaan</option>
                            </select>
                            @error('form.role')
                                <small class="text-red-600 font-medium">{{ $message }}</small>
                            @enderror
                        </div>
                        <button type="submit"
                            class="mt-5 w-full text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center"
                            data-modal-hide="tambah-modal">Tambah</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
