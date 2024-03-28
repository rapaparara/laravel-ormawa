<?php

namespace App\Livewire;

use App\Models\kegiatan as ModelsKegiatan;
use App\Models\ormawa as ModelsOrmawa;
use App\Models\peminjaman_fasilitas as ModelsPeminjaman;
use App\Models\users_kemahasiswaan as ModelsKemahasiswaan;
use Livewire\Component;

class Laporan extends Component
{
    public $byOrmawa;
    public function render()
    {
        $fakultas = ModelsKemahasiswaan::where('user_id', session('user_id'))->get('fakultas_id');
        $fakultas_id = $fakultas[0]->fakultas_id;
        // Data Ormawa
        $data['dataOrmawa'] = ModelsOrmawa::where('fakultas_id', $fakultas_id)->get();
        // Data Kegiatan
        $data_kegiatan = ModelsKegiatan::whereHas('ormawa', function ($query) use ($fakultas_id) {
            $query->where('fakultas_id', $fakultas_id);
        })->get();
        $a = [];
        foreach ($data_kegiatan as $kegiatan) {
            $ormawa_id = $kegiatan->ormawa_id;
            $label = $kegiatan->ormawa->name;
            if (isset($a[$ormawa_id])) {
                $a[$ormawa_id]['data']++;
            } else {
                $a[$ormawa_id] = [
                    'labels' => $label,
                    'data' => 1,
                ];
            }
        }
        $chartKegiatan = [
            'labels' => [],
            'data' => [],
        ];
        foreach ($a as $ormawa) {
            $chartKegiatan['labels'][] = $ormawa['labels'];
            $chartKegiatan['data'][] = $ormawa['data'];
        }
        // Data Peminjaman Fasilitas
        $data_peminjaman = ModelsPeminjaman::whereHas('fasilitas', function ($query) use ($fakultas_id) {
            $query->where('fakultas_id', $fakultas_id);
        })
            ->where('status', 'setujui')
            ->selectRaw('MONTH(waktu_mulai) AS bulan, COUNT(*) AS jumlah, ormawa_id')
            ->groupBy('bulan', 'ormawa_id')
            ->get();
        // Inisialisasi array untuk setiap ORMawa
        $ormawa_data = [];
        foreach ($data['dataOrmawa'] as $key => $value) {
            if ($value->fakultas_id == $fakultas_id) {
                $ormawa_data[$value->id] = [
                    'name' => $value->name,
                    'data' => array_fill(0, 12, 0), // Inisialisasi dengan 0 untuk setiap bulan
                ];
            }
        }

        // Mengisi data peminjaman per bulan sesuai dengan hasil query
        foreach ($data_peminjaman as $peminjaman) {
            if (array_key_exists($peminjaman->ormawa_id, $ormawa_data)) {
                $ormawa_data[$peminjaman->ormawa_id]['data'][$peminjaman->bulan - 1] += $peminjaman->jumlah;
            }
        }

        $data_charts = [
            'labels' => ['January', 'February', 'March', 'April', 'May'],
            'data' => [35, 29, 60, 31, 53],
        ];
        $data['dataCharts'] = $data_charts;
        $data['chartPeminjaman'] = array_values($ormawa_data);
        $data['chartKegiatan'] = $chartKegiatan;
        return view('livewire.laporan', $data);
    }
}
