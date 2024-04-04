<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Laporan Kegiatan</title>
    <style>
        body {
            font-family: Arial, sans-serif; /* Mengubah jenis font */
        }   
        table {
            border-collapse: collapse;
            border: 1px solid #ccc; /* Mengubah warna border */
            width: 100%; /* Mengatur lebar tabel menjadi 100% */
        }
        thead {
            vertical-align: middle; /* Mengubah vertikal alignment kepala tabel */
            text-align: left; /* Mengubah horizontal alignment kepala tabel */
            font-weight: bold;
            background-color: #f2f2f2; /* Mengubah warna latar belakang kepala tabel */
            border-bottom: 2px solid #000000; /* Mengubah warna dan ketebalan border bawah kepala tabel */
        }
        tfoot {
            text-align: center;
            font-weight: bold;
            background-color: #f2f2f2; /* Mengubah warna latar belakang kaki tabel */
            border-top: 2px solid #000000; /* Mengubah warna dan ketebalan border atas kaki tabel */
        }
        th,
        td {
            padding: 8px; /* Mengubah padding sel */
            border: 1px solid #ccc; /* Mengubah warna border sel */
        }
        img {
            margin: 0.5em; /* Mengubah margin gambar */
            vertical-align: middle;
        }
    </style>
    
</head>

<body>

    <div>
        <h2>Laporan Kegiatan Ormawa</h2>
        <table>
            <thead>
                <tr>
                    <th scope="col">
                        No
                    </th>
                    <th scope="col">
                        Nama Kegiatan
                    </th>
                    <th scope="col">
                        Nama Ormawa
                    </th>
                    <th scope="col">
                        Deskripsi
                    </th>
                    <th scope="col">
                        Waktu Kegiatan
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($dataKegiatan as $key => $value)
                    <tr>
                        <th scope="row">
                            {{ $key + 1 }}
                        </th>
                        <td>
                            {{ $value->name }}
                        </td>
                        <td>
                            {{ $value->ormawa->name }}
                        </td>
                        <td>
                            {{ mb_strlen($value->deskripsi, 'UTF-8') > 180 ? mb_substr($value->deskripsi, 0, 180, 'UTF-8') . '...' : $value->deskripsi }}
                        </td>
                        <td>
                            {{ \Carbon\Carbon::parse($value->waktu_mulai)->isoFormat('D MMMM YYYY', 'Do MMMM YYYY') }}
                            -
                            {{ \Carbon\Carbon::parse($value->waktu_selesai)->isoFormat('D MMMM YYYY', 'Do MMMM YYYY') }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

</body>

</html>
