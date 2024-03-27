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
            ->orderBy('waktu_mulai', 'desc')
            ->get();
        $data_fasilitas = [
            'labels' => ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'],
            'data' => [],
        ];
        $peminjaman_per_bulan = array_fill(0, 12, 0);
        foreach ($data_peminjaman as $peminjaman) {
            $bulan_peminjaman = date('n', strtotime($peminjaman->waktu_mulai));
            $peminjaman_per_bulan[$bulan_peminjaman - 1]++;
        }
        $data_fasilitas['data'] = $peminjaman_per_bulan;

        $data_charts = [
            'labels' => ['January', 'February', 'March', 'April', 'May'],
            'data' => [35, 29, 60, 31, 53],
        ];
        $data['dataCharts'] = $data_fasilitas;
        $data['chartKegiatan'] = $chartKegiatan;
        return view('livewire.laporan', $data);
    }
}
