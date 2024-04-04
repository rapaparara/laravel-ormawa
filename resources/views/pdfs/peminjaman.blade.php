<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Laporan Peminjaman Fasilitas</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            /* Mengubah jenis font */
        }

        table {
            border-collapse: collapse;
            border: 1px solid #ccc;
            /* Mengubah warna border */
            width: 100%;
            /* Mengatur lebar tabel menjadi 100% */
        }

        thead {
            vertical-align: middle;
            /* Mengubah vertikal alignment kepala tabel */
            text-align: left;
            /* Mengubah horizontal alignment kepala tabel */
            font-weight: bold;
            background-color: #f2f2f2;
            /* Mengubah warna latar belakang kepala tabel */
            border-bottom: 2px solid #000000;
            /* Mengubah warna dan ketebalan border bawah kepala tabel */
        }

        tfoot {
            text-align: center;
            font-weight: bold;
            background-color: #f2f2f2;
            /* Mengubah warna latar belakang kaki tabel */
            border-top: 2px solid #000000;
            /* Mengubah warna dan ketebalan border atas kaki tabel */
        }

        th,
        td {
            padding: 8px;
            /* Mengubah padding sel */
            border: 1px solid #ccc;
            /* Mengubah warna border sel */
        }

        img {
            margin: 0.5em;
            /* Mengubah margin gambar */
            vertical-align: middle;
        }
    </style>

</head>

<body>

    <div>
        <h2>Laporan Peminjaman Fasilitas</h2>
        <table>
            <thead>
                <tr>
                    <th scope="col">
                        No
                    </th>
                    <th scope="col">
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
                    <th scope="col" class="px-3 py-2">
                        Status Peminjaman
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($dataPeminjaman as $key => $value)
                    <tr>
                        <th scope="row">
                            {{ $key + 1 }}
                        </th>
                        <td>
                            {{ $value->fasilitas->name }}
                        </td>
                        <td>
                            {{ $value->fasilitas->fakultas->name }}
                        </td>
                        <td>
                            {{ $value->ormawa->name }}
                        </td>
                        <td>
                            {{ \Carbon\Carbon::parse($value->waktu_mulai)->isoFormat('D MMMM YYYY', 'Do MMMM YYYY') }}
                        </td>
                        <td>
                            {{ \Carbon\Carbon::parse($value->waktu_selesai)->isoFormat('D MMMM YYYY', 'Do MMMM YYYY') }}
                        </td>
                        <td>
                            {{ $value->status }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

</body>

</html>
