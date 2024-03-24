<div>
    <div class="mx-6 mt-4 p-5 bg-gray-50 text-gray-800 border border-gray-200 rounded-lg shadow-sm">
        <div class="flex flex-wrap">
            <h5 class="mb-2 text-2xl font-bold tracking-tight text-indigo-800 dark:text-white">Manajemen
                tahapan kegiatan
            </h5>
            @if (session('user_role') == 'mahasiswa')
                <button wire:click="editStateModal()" data-modal-target="tambah-modal" data-modal-toggle="tambah-modal"
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
                            Nama Tahapan
                        </th>
                        <th scope="col" class="px-3 py-2">
                            Nama Kegiatan
                        </th>
                        <th scope="col" class="md:max-w-md px-3 py-2">
                            Deskripsi
                        </th>
                        <th scope="col" class="px-3 py-2">
                            Waktu Tahapan Kegiatan
                        </th>
                        <th scope="col" class="px-3 py-2">
                            Dokumentasi
                        </th>
                        <th scope="col" class="px-3 py-2">
                            Status
                        </th>
                        @if (session('user_role') == 'mahasiswa')
                            <th scope="col" class="w-56 px-3 py-2">
                                Aksi
                            </th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @foreach ($dataTahapan as $key => $value)
                        <tr class="bg-white border-b ">
                            <th scope="row" class="px-6 py-4">
                                {{ $dataTahapan->firstItem() + $key }}
                            </th>
                            <td class="px-3 py-2">
                                {{ $value->name }}
                            </td>
                            <td class="px-3 py-2">
                                {{ $value->kegiatan->name }}
                            </td>
                            <td class="md:max-w-md px-3 py-2">
                                {{ mb_strlen($value->deskripsi, 'UTF-8') > 180 ? mb_substr($value->deskripsi, 0, 180, 'UTF-8') . '...' : $value->deskripsi }}
                            </td>
                            <td class="px-3 py-2">
                                {{ \Carbon\Carbon::parse($value->waktu_mulai)->isoFormat('D MMMM YYYY', 'Do MMMM YYYY') }}
                                -
                                {{ \Carbon\Carbon::parse($value->waktu_selesai)->isoFormat('D MMMM YYYY', 'Do MMMM YYYY') }}
                            </td>
                            <td class="px-3 py-2">
                                <button wire:click.prevent="lihat('{{ $value->name }}')"
                                    data-modal-target="lihat-modal" data-modal-toggle="lihat-modal"
                                    class="mb-2 me-2 py-2 px-3 rounded-lg bg-green-500 text-white font-bold hover:bg-green-600 focus:ring-4 focus:outline-none focus:ring-green-400 transition duration-300 ease-in-out transform hover:scale-105 hover:shadow-sm"
                                    type="button">
                                    <i class="me-2 fa-solid fa-eye"></i>Lihat
                                </button>
                            </td>
                            <td class="px-3 py-2">
                                @if ($value->status === 'belum')
                                    <span
                                        class="bg-gray-100 text-gray-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded-full">Belum
                                        dimulai</span>
                                @endif
                                @if ($value->status === 'sementara')
                                    <span
                                        class="bg-yellow-300 text-white text-xs font-medium me-2 px-2.5 py-0.5 rounded-full">Sementara</span>
                                @endif
                                @if ($value->status === 'selesai')
                                    <span
                                        class="bg-green-100 text-green-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded-full">Selesai</span>
                                @endif
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
                <div class="livewire-pagination"> {{ $dataTahapan->links() }}</div>
            </div>
        </div>
    </div>
</div>
