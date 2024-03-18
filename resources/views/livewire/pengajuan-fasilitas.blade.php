<div>
    <div class="mx-6 mt-4 p-5 bg-gray-50 text-gray-800 border border-gray-200 rounded-lg shadow-sm">
        <div class="flex flex-wrap">
            @if (session('user_role'))
                <h5 class="mb-2 text-2xl font-bold tracking-tight text-indigo-800 dark:text-white">Pengajuan peminjaman
                    fasilitas
                </h5>
            @else
                <h5 class="mb-2 text-2xl font-bold tracking-tight text-indigo-800 dark:text-white">Jadwal penggunaan
                    fasilitas
                </h5>
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
                            Nama Fasilitas
                        </th>
                        <th scope="col" class="px-3 py-2">
                            Lokasi
                        </th>
                        <th scope="col" class="px-3 py-2">
                            Ormawa Peminjam
                        </th>
                        <th scope="col" class="px-3 py-2">
                            Tanggal Mulai
                        </th>
                        <th scope="col" class="px-3 py-2">
                            Tanggal Selesai
                        </th>
                        @if (session('user_role'))
                            <th scope="col" class="px-3 py-2">
                                Status Peminjaman
                            </th>
                        @endif
                        @if (session('user_role') == 'kemahasiswaan')
                            <th scope="col" class="px-3 py-2">
                                Aksi
                            </th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @foreach ($dataPeminjaman as $key => $value)
                        <tr class="bg-white border-b ">
                            <th scope="row" class="px-6 py-4">
                                {{ $dataPeminjaman->firstItem() + $key }}
                            </th>
                            <td class="px-3 py-2">
                                {{ $value->fasilitas->name }}
                            </td>
                            <td class="px-3 py-2">
                                {{ $value->fasilitas->fakultas->name }}
                            </td>
                            <td class="px-3 py-2">
                                {{ $value->ormawa->name }}
                            </td>
                            <td class="px-3 py-2">
                                {{ \Carbon\Carbon::parse($value->waktu_mulai)->isoFormat('D MMMM YYYY', 'Do MMMM YYYY') }}
                            </td>
                            <td class="px-3 py-2">
                                {{ \Carbon\Carbon::parse($value->waktu_selesai)->isoFormat('D MMMM YYYY', 'Do MMMM YYYY') }}
                            </td>
                            @if (session('user_role'))
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
                            @endif
                            @if (session('user_role') == 'kemahasiswaan')
                                <td scope="col" class="px-3 py-2">
                                    <a wire:click.prevent="ganti('{{ $value->id }}')"
                                        class="mb-2 me-2 py-2 px-3 rounded-lg bg-yellow-300 text-white font-bold hover:bg-yellow-400 focus:ring-4 focus:outline-none focus:ring-yellow-200 transition duration-300 ease-in-out transform hover:scale-105 hover:shadow-sm"
                                        href="#" data-modal-toggle="ganti-modal">
                                        <i class="me-2 fa-solid fa-pencil"></i>Ubah Status</a>
                                </td>
                            @endif
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="mt-3">
                <div class="livewire-pagination"> {{ $dataPeminjaman->links() }}</div>
            </div>
        </div>
    </div>

    <div wire:ignore.self id="ganti-modal" tabindex="-1" aria-hidden="true"
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
                    <form wire:submit="update" class="space-y-4">
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
    </div>
</div>
