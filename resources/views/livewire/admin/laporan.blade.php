<div>
    <div class="mx-6 mt-4 p-5 bg-gray-50 text-gray-800 border border-gray-200 rounded-lg shadow-sm">
        <div class="mb-3 flex flex-nowrap">
            <h5 class="mb-2 text-2xl font-bold tracking-tight text-indigo-800 dark:text-white">Keaktifan ormawa
            </h5>
            <select wire:model.live="periode_id" name="periode_id"
                class="ms-auto bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-48 md:w-64  p-2.5">
                <option value="">Semua Periode</option>
                @foreach ($dataPeriode as $key => $value)
                    <option value="{{ $value->id }}">{{ $value->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-4 grid md:grid-cols-3 gap-3">
            @foreach ($keaktifanOrmawa as $item)
                <div class="w-full max-w-sm p-4 bg-white border border-gray-200 rounded-lg shadow sm:p-8 ">
                    <h5 class="mb-2 text-xl font-medium text-gray-600 ">
                        <span class="border-l-4 pl-2 border-blue-700">{{ $item['ormawa']->name }}</span>
                    </h5>
                    <ul role="list" class="space-y-5 my-7">
                        <li class="flex items-center">
                            <svg class="flex-shrink-0 w-4 h-4 text-blue-700 dark:text-blue-500" aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z" />
                            </svg>
                            <span class="text-base font-normal leading-tight text-gray-600 ms-2">
                                Total Pengurus
                            </span>
                            <span
                                class="ms-auto p-1 text-md font-bold leading-tight text-slate-50 bg-blue-700 rounded-md shadow-md">
                                {{ $item['total_pengurus'] }}
                            </span>
                        </li>
                        <li class="flex items-center">
                            <svg class="flex-shrink-0 w-4 h-4 text-blue-700 dark:text-blue-500" aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z" />
                            </svg>
                            <span class="text-base font-normal leading-tight text-gray-600 ms-2">
                                Total Kegiatan
                            </span>
                            <span
                                class="ms-auto p-1 text-md font-bold leading-tight text-slate-50 bg-blue-700 rounded-md shadow-md">
                                {{ $item['total_kegiatan'] }}
                            </span>
                        </li>
                        <li class="flex items-center">
                            <svg class="flex-shrink-0 w-4 h-4 text-blue-700 dark:text-blue-500" aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z" />
                            </svg>
                            <span class="text-base font-normal leading-tight text-gray-600 ms-2">
                                Tahapan kegiatan selesai
                            </span>
                            <span
                                class="ms-auto p-1 text-md font-bold leading-tight text-slate-50 bg-blue-700 rounded-md shadow-md">
                                {{ $item['total_tahapan'] }}
                            </span>
                        </li>
                        <li class="flex items-center">
                            <svg class="flex-shrink-0 w-4 h-4 text-blue-700 dark:text-blue-500" aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z" />
                            </svg>
                            <span class="text-base font-normal leading-tight text-gray-600 ms-2">
                                Dokumentasi kegiatan
                            </span>
                            <span
                                class="ms-auto p-1 text-md font-bold leading-tight text-slate-50 bg-blue-700 rounded-md shadow-md">
                                {{ $item['total_dokumentasi'] }}
                            </span>
                        </li>
                        <li class="flex items-center">
                            <span class="text-lg font-bold leading-tight text-gray-600 ms-2">
                                Total Keseluruhan
                            </span>
                            <span
                                class="ms-auto p-1 text-lg font-bold leading-tight text-slate-50 bg-sky-500 rounded-md shadow-md">
                                {{ $item['total_keseluruhan'] }}
                            </span>
                        </li>
                    </ul>
                </div>
            @endforeach
        </div>
        <h5 class="mb-2 text-2xl font-bold tracking-tight text-indigo-800 dark:text-white">Download Laporan
        </h5>
        <div class="mb-4 grid">
        </div>
        <div class="mb-4 grid md:grid-cols-3 gap-4">
            <div class="w-full p-4 bg-white border border-gray-200 rounded-lg shadow sm:p-8 ">
                <div class="mb-3 flex flex-wrap">
                    <h5 class="mb-2 text-lg font-semibold tracking-tight text-indigo-800 dark:text-white">Laporan
                        Kegiatan
                    </h5>
                    <a href="{{ route('laporan.kegiatan.admin') }}"
                        class="ms-auto py-1 px-2 rounded-lg bg-green-500 text-white text-sm font-semibold  hover:bg-green-600 focus:ring-4 focus:outline-none focus:ring-green-300 transition duration-300 ease-in-out transform hover:scale-105 hover:shadow-sm"
                        role="button">
                        <i class="me-2 fa-solid fa-download"></i>Download
                    </a>
                </div>
                <canvas id="chartKegiatan"></canvas>
            </div>
            <div class="w-full p-4 bg-white border border-gray-200 rounded-lg shadow sm:p-8 ">
                <div class="mb-3 flex flex-wrap">
                    <h5 class="mb-2 text-lg font-semibold tracking-tight text-indigo-800 dark:text-white">Laporan
                        Kepengurusan
                    </h5>
                    <a href="{{ route('laporan.kepengurusan.admin') }}"
                        class="ms-auto py-1 px-2 rounded-lg bg-green-500 text-white text-sm font-semibold  hover:bg-green-600 focus:ring-4 focus:outline-none focus:ring-green-300 transition duration-300 ease-in-out transform hover:scale-105 hover:shadow-sm"
                        role="button">
                        <i class="me-2 fa-solid fa-download"></i>Download
                    </a>
                </div>
                <canvas id="chartKepengurusan" class=""></canvas>
            </div>
            <div class="w-full p-4 bg-white border border-gray-200 rounded-lg shadow sm:p-8 ">
                <div class="mb-3 flex flex-wrap">
                    <h5 class="mb-2 text-lg font-semibold tracking-tight text-indigo-800 dark:text-white">Laporan
                        Peminjamaan Fasilitas
                    </h5>
                    <a href="{{ route('laporan.peminjaman.admin') }}"
                        class="ms-auto py-1 px-2 rounded-lg bg-green-500 text-white text-sm font-semibold  hover:bg-green-600 focus:ring-4 focus:outline-none focus:ring-green-300 transition duration-300 ease-in-out transform hover:scale-105 hover:shadow-sm"
                        role="button">
                        <i class="me-2 fa-solid fa-download"></i>Download
                    </a>
                </div>
                <div class="h-80">
                    <canvas wire:ignore.self id="chartPeminjaman"></canvas>
                </div>
            </div>
        </div>

    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var chartKegiatan = @json($chartKegiatan);
            var chartPeminjaman = @json($chartPeminjaman);
            var chartKepengurusan = @json($chartKepengurusan);
            setInterval(() => {
                @this.dispatch('ubahData');
            }, 3000);
            const vchartKegiatan = new Chart(document.getElementById('chartKegiatan'), {
                type: 'pie',
                data: {
                    datasets: [{
                        data: chartKegiatan.data,
                        label: 'Jumlah Kegiatan'
                    }],
                    labels: chartKegiatan.labels
                },
                options: {
                    scales: {},
                    elements: {
                        arc: {
                            borderWidth: 4
                        }
                    }
                }
            });
            const vchartPeminjaman = new Chart(document.getElementById('chartPeminjaman'), {
                type: 'line',
                data: {
                    labels: ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus',
                        'September',
                        'Oktober', 'November', 'Desember'
                    ],
                    datasets: chartPeminjaman.map(data => ({
                        label: data.name,
                        data: data.data,
                        borderWidth: 3
                    }))
                },
                options: {
                    scales: {
                        y: {
                            // beginAtZero: true,
                        }
                    },
                    plugins: {
                        colors: {
                            forceOverride: true
                        }
                    },
                    responsive: true,
                    maintainAspectRatio: false,
                    spanGaps: true, // enable for all datasets
                    datasets: {
                        line: {
                            pointRadius: 4 // disable for all `'line'` datasets
                        }
                    },
                    tension: 0.18,
                }
            });
            const vchartKepengurusan = new Chart(document.getElementById('chartKepengurusan'), {
                type: 'pie',
                data: {
                    datasets: [{
                        data: chartKepengurusan.data,
                        label: 'Jumlah Pengurus'
                    }],
                    labels: chartKepengurusan.labels
                },
                options: {
                    scales: {},
                    elements: {
                        arc: {
                            borderWidth: 4
                        }
                    }
                }
            });
            @this.on('ubahDataBerhasil', receivedData => {
                var chartKegiatan = receivedData[0].chartKegiatan;
                var chartPeminjaman = receivedData[0].chartPeminjaman;
                var chartKepengurusan = receivedData[0].chartKepengurusan;

                // Update chartKegiatan
                vchartKegiatan.data.labels = chartKegiatan.labels;
                vchartKegiatan.data.datasets.forEach((dataset) => {
                    dataset.data = chartKegiatan.data;
                });
                vchartKegiatan.update();

                // Update chartPeminjaman
                vchartPeminjaman.data.datasets.forEach((dataset, index) => {
                    dataset.data = chartPeminjaman[index].data;
                });
                vchartPeminjaman.update();

                // Update chartKepengurusan
                vchartKepengurusan.data.labels = chartKepengurusan.labels;
                vchartKepengurusan.data.datasets.forEach((dataset) => {
                    dataset.data = chartKepengurusan.data;
                });
                vchartKepengurusan.update();
            });

        });
    </script>
</div>
