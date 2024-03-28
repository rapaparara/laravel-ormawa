<?php

namespace App\Livewire;

use App\Models\kegiatan as ModelsKegiatan;
use App\Models\ormawa as ModelsOrmawa;
use App\Models\peminjaman_fasilitas as ModelsPeminjaman;
use App\Models\pengurus as ModelsPengurus;
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
        $i = [];
        foreach ($data_kegiatan as $kegiatan) {
            $ormawa_id = $kegiatan->ormawa_id;
            $label = $kegiatan->ormawa->name;
            if (array_key_exists($ormawa_id, $i)) {
                $i[$ormawa_id]['data']++;
            } else {
                $i[$ormawa_id] = [
                    'labels' => $label,
                    'data' => 1,
                ];
            }
        }
        $chartKegiatan = [
            'labels' => [],
            'data' => [],
        ];
        foreach ($i as $ormawa) {
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
        $ormawa_data = [];
        foreach ($data['dataOrmawa'] as $key => $value) {
            if ($value->fakultas_id == $fakultas_id) {
                $ormawa_data[$value->id] = [
                    'name' => $value->name,
                    'data' => array_fill(0, 12, 0), // Inisialisasi dengan 0 untuk setiap bulan
                ];
            }
        }
        foreach ($data_peminjaman as $peminjaman) {
            if (array_key_exists($peminjaman->ormawa_id, $ormawa_data)) {
                $ormawa_data[$peminjaman->ormawa_id]['data'][$peminjaman->bulan - 1] += $peminjaman->jumlah;
            }
        }
        // Data Pengurus
        // $data_pengurus = ModelsPengurus::query()->get();
        $data_pengurus = ModelsPengurus::join('periode_kepengurusans', 'penguruses.kepengurusan_id', '=', 'periode_kepengurusans.id')
        ->join('ormawas', 'periode_kepengurusans.ormawa_id', '=', 'ormawas.id')
        ->join('fakultas', 'ormawas.fakultas_id', '=', 'fakultas.id')
        ->where('fakultas_id', $fakultas_id)->orderBy('penguruses.id', 'desc')->get();

        $i = [];
        foreach ($data_pengurus as $pengurus) {
            $kepengurusan_id = $pengurus->kepengurusan_id;
            $label = $pengurus->kepengurusan->fakultas->name;
            if (array_key_exists($kepengurusan_id, $i)) {
                $i[$kepengurusan_id]['data']++;
            } else {
                $i[$kepengurusan_id] = [
                    'labels' => $label,
                    'data' => 1,
                ];
            }
        }
        $chartKepengurusan = [
            'labels' => [],
            'data' => [],
        ];
        foreach ($i as $pengurus) {
            $chartKepengurusan['labels'][] = $pengurus['labels'];
            $chartKepengurusan['data'][] = $pengurus['data'];
        }
        $data['chartKepengurusan'] = $chartKepengurusan;
        $data['chartPeminjaman'] = array_values($ormawa_data);
        $data['chartKegiatan'] = $chartKegiatan;
        return view('livewire.laporan', $data);
    }
}
