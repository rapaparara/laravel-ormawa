<?php

namespace App\Livewire;

use App\Models\dokumentasi as ModelsDokumentasi;
use App\Models\kegiatan as ModelsKegiatan;
use App\Models\ormawa as ModelsOrmawa;
use App\Models\peminjaman_fasilitas as ModelsPeminjaman;
use App\Models\pengurus as ModelsPengurus;
use App\Models\periode;
use App\Models\tahapan_kegiatan as ModelsTahapan;
use App\Models\users_kemahasiswaan as ModelsKemahasiswaan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\On;
use Livewire\Component;

class Laporan extends Component
{
    public $byOrmawa, $periode_id;
    protected function getKeaktifanOrmawaByPeriode($fakultas_id, $periode_id)
    {
        // Inisialisasi total untuk setiap jenis data
        $totalPengurus = [];
        $totalKegiatan = [];
        $totalTahapan = [];
        $totalDokumentasi = [];

        if ($periode_id !== null) {
            // Query untuk total pengurus
            $totalPengurus = ModelsPengurus::join('periode_kepengurusans', 'penguruses.kepengurusan_id', '=', 'periode_kepengurusans.id')->join('ormawas', 'periode_kepengurusans.ormawa_id', '=', 'ormawas.id')->join('fakultas', 'ormawas.fakultas_id', '=', 'fakultas.id')->where('fakultas_id', $fakultas_id)->where('periode_kepengurusans.periode_id', $periode_id)->selectRaw('COUNT(*) AS jumlah, ormawa_id')->groupBy('ormawa_id')->get()->keyBy('ormawa_id');

            // Query untuk total kegiatan
            $totalKegiatan = ModelsKegiatan::selectRaw('COUNT(*) AS jumlah, kegiatans.ormawa_id')
                ->join('ormawas', 'kegiatans.ormawa_id', '=', 'ormawas.id')
                ->join(DB::raw("(SELECT id, name FROM ormawas WHERE fakultas_id = $fakultas_id) as filtered_ormawas"), function ($join) {
                    $join->on('ormawas.id', '=', 'filtered_ormawas.id');
                })
                ->join('periode_kepengurusans', 'kegiatans.kepengurusan_id', '=', 'periode_kepengurusans.id')
                ->join('periodes', 'periode_kepengurusans.periode_id', '=', 'periodes.id')
                ->where('periodes.id', $periode_id)
                ->groupBy('kegiatans.ormawa_id')
                ->get()
                ->keyBy('ormawa_id');

            // Query untuk total tahapan kegiatan
            $totalTahapan = ModelsTahapan::selectRaw('COUNT(*) AS jumlah, kegiatans.ormawa_id')
                ->where('tahapan_kegiatans.status', '=', 'selesai')
                ->join('kegiatans', 'tahapan_kegiatans.kegiatan_id', '=', 'kegiatans.id')
                ->join('ormawas', 'kegiatans.ormawa_id', '=', 'ormawas.id')
                ->join(DB::raw("(SELECT id, name FROM ormawas WHERE fakultas_id = $fakultas_id) as filtered_ormawas"), function ($join) {
                    $join->on('ormawas.id', '=', 'filtered_ormawas.id');
                })
                ->join('periode_kepengurusans', 'kegiatans.kepengurusan_id', '=', 'periode_kepengurusans.id')
                ->join('periodes', 'periode_kepengurusans.periode_id', '=', 'periodes.id')
                ->where('periodes.id', $periode_id)
                ->groupBy('kegiatans.ormawa_id')
                ->get()
                ->keyBy('ormawa_id');

            // Query untuk total dokumentasi kegiatan
            $totalDokumentasi = ModelsDokumentasi::selectRaw('COUNT(*) AS jumlah, kegiatans.ormawa_id')
                ->join('tahapan_kegiatans', 'dokumentasis.tahapan_kegiatan_id', '=', 'tahapan_kegiatans.id')
                ->join('kegiatans', 'tahapan_kegiatans.kegiatan_id', '=', 'kegiatans.id')
                ->join('periode_kepengurusans', 'kegiatans.kepengurusan_id', '=', 'periode_kepengurusans.id')
                ->join('periodes', 'periode_kepengurusans.periode_id', '=', 'periodes.id')
                ->join('ormawas', 'kegiatans.ormawa_id', '=', 'ormawas.id')
                ->join(DB::raw("(SELECT id, name FROM ormawas WHERE fakultas_id = $fakultas_id) as filtered_ormawas"), function ($join) {
                    $join->on('ormawas.id', '=', 'filtered_ormawas.id');
                })
                ->where('periodes.id', $periode_id)
                ->groupBy('kegiatans.ormawa_id')
                ->get()
                ->keyBy('ormawa_id');
        }

        // Ambil data ormawa sesuai fakultas
        $dataOrmawa = ModelsOrmawa::where('fakultas_id', $fakultas_id)->get()->keyBy('id');

        // Inisialisasi hasil akhir
        $result = collect();

        // Looping untuk setiap ormawa
        foreach ($dataOrmawa as $ormawa_id => $ormawa) {
            // Inisialisasi nilai total kegiatan, total tahapan, dan total dokumentasi
            $totalPengurusOrmawa = $totalPengurus[$ormawa_id]['jumlah'] ?? 0;
            $totalKegiatanOrmawa = $totalKegiatan[$ormawa_id]['jumlah'] ?? 0;
            $totalTahapanOrmawa = $totalTahapan[$ormawa_id]['jumlah'] ?? 0;
            $totalDokumentasiOrmawa = $totalDokumentasi[$ormawa_id]['jumlah'] ?? 0;

            // Menghitung total keseluruhan untuk setiap ormawa
            $totalKeseluruhanOrmawa = $totalKegiatanOrmawa + $totalTahapanOrmawa + $totalDokumentasiOrmawa;

            // Menambahkan total keseluruhan ke setiap elemen hasil
            $result->push([
                'ormawa' => $ormawa,
                'total_pengurus' => $totalPengurusOrmawa,
                'total_kegiatan' => $totalKegiatanOrmawa,
                'total_tahapan' => $totalTahapanOrmawa,
                'total_dokumentasi' => $totalDokumentasiOrmawa,
                'total_keseluruhan' => $totalKeseluruhanOrmawa,
            ]);
        }

        // Urutkan koleksi berdasarkan total keseluruhan secara descending
        $result = $result->sortByDesc('total_keseluruhan')->take(3);

        // Konversi koleksi menjadi array
        $result = $result->values()->all();

        return $result;
    }
    protected function getKeaktifanOrmawa($fakultas_id)
    {
        // Hitung total kegiatan untuk setiap ormawa
        $totalKegiatan = ModelsKegiatan::selectRaw('COUNT(*) AS jumlah, kegiatans.ormawa_id')
            ->join('ormawas', 'kegiatans.ormawa_id', '=', 'ormawas.id')
            ->join(DB::raw("(SELECT id, name FROM ormawas WHERE fakultas_id = $fakultas_id) as filtered_ormawas"), function ($join) {
                $join->on('ormawas.id', '=', 'filtered_ormawas.id');
            })
            ->groupBy('kegiatans.ormawa_id')
            ->get()
            ->keyBy('ormawa_id');
        // Hitung total pengurus untuk setiap ormawa
        $totalPengurus = ModelsPengurus::join('periode_kepengurusans', 'penguruses.kepengurusan_id', '=', 'periode_kepengurusans.id')->join('ormawas', 'periode_kepengurusans.ormawa_id', '=', 'ormawas.id')->join('fakultas', 'ormawas.fakultas_id', '=', 'fakultas.id')->where('fakultas_id', $fakultas_id)->selectRaw('COUNT(*) AS jumlah, ormawa_id')->groupBy('ormawa_id')->get()->keyBy('ormawa_id');
        // Hitung total tahapan kegiatan untuk setiap ormawa
        $totalTahapan = ModelsTahapan::selectRaw('COUNT(*) AS jumlah, kegiatans.ormawa_id')
            ->where('tahapan_kegiatans.status', '=', 'selesai')
            ->join('kegiatans', 'tahapan_kegiatans.kegiatan_id', '=', 'kegiatans.id')
            ->join('ormawas', 'kegiatans.ormawa_id', '=', 'ormawas.id')
            ->join(DB::raw("(SELECT id, name FROM ormawas WHERE fakultas_id = $fakultas_id) as filtered_ormawas"), function ($join) {
                $join->on('ormawas.id', '=', 'filtered_ormawas.id');
            })
            ->groupBy('kegiatans.ormawa_id')
            ->get()
            ->keyBy('ormawa_id');
        // Hitung total dokumentasi kegiatan untuk setiap ormawa
        $totalDokumentasi = ModelsDokumentasi::selectRaw('COUNT(*) AS jumlah, kegiatans.ormawa_id')
            ->join('tahapan_kegiatans', 'dokumentasis.tahapan_kegiatan_id', '=', 'tahapan_kegiatans.id')
            ->join('kegiatans', 'tahapan_kegiatans.kegiatan_id', '=', 'kegiatans.id')
            ->join('ormawas', 'kegiatans.ormawa_id', '=', 'ormawas.id')
            ->join(DB::raw("(SELECT id, name FROM ormawas WHERE fakultas_id = $fakultas_id) as filtered_ormawas"), function ($join) {
                $join->on('ormawas.id', '=', 'filtered_ormawas.id');
            })
            ->groupBy('kegiatans.ormawa_id')
            ->get()
            ->keyBy('ormawa_id');
        // Ambil data ormawa sesuai fakultas
        $dataOrmawa = ModelsOrmawa::where('fakultas_id', $fakultas_id)->get()->keyBy('id');
        // Gabungkan hasil dari ketiga query berdasarkan ormawa_id
        $result = collect();
        foreach ($totalPengurus as $ormawa_id => $total) {
            // Menghitung total keseluruhan untuk setiap ormawa
            $totalKeseluruhanOrmawa = ($totalKegiatan->get($ormawa_id)['jumlah'] ?? 0) + ($totalTahapan->get($ormawa_id)['jumlah'] ?? 0) + ($totalDokumentasi->get($ormawa_id)['jumlah'] ?? 0);

            // Menambahkan total keseluruhan ke setiap elemen hasil
            $result->push([
                'ormawa' => $dataOrmawa[$ormawa_id],
                'total_pengurus' => $total['jumlah'],
                'total_kegiatan' => $totalKegiatan->get($ormawa_id, ['jumlah' => 0, 'ormawa_id' => $ormawa_id])['jumlah'] ?? 0,
                'total_tahapan' => $totalTahapan->get($ormawa_id, ['jumlah' => 0, 'ormawa_id' => $ormawa_id])['jumlah'] ?? 0,
                'total_dokumentasi' => $totalDokumentasi->get($ormawa_id, ['jumlah' => 0, 'ormawa_id' => $ormawa_id])['jumlah'] ?? 0,
                'total_keseluruhan' => $totalKeseluruhanOrmawa,
            ]);
        }
        // Urutkan koleksi berdasarkan total keseluruhan secara descending
        $result = $result->sortByDesc('total_keseluruhan')->take(3);
        // Konversi koleksi menjadi array
        $result = $result->values()->all();
        return $result;
    }
    protected function getChartData($fakultas_id)
    {
        $data = [];
        $data['dataOrmawa'] = ModelsOrmawa::where('fakultas_id', $fakultas_id)->get();
        // Data Kegiatan
        $data_kegiatan = ModelsKegiatan::selectRaw('COUNT(*) AS data, MAX(ormawas.name) AS labels, kegiatans.ormawa_id')
            ->join('ormawas', 'kegiatans.ormawa_id', '=', 'ormawas.id')
            ->join(DB::raw("(SELECT id, name FROM ormawas WHERE fakultas_id = $fakultas_id) as filtered_ormawas"), function ($join) {
                $join->on('ormawas.id', '=', 'filtered_ormawas.id');
            })
            ->groupBy('kegiatans.ormawa_id')
            ->orderBy('ormawas.id')
            ->get()
            ->toArray();
        $chartKegiatan = [
            'labels' => array_column($data_kegiatan, 'labels'),
            'data' => array_column($data_kegiatan, 'data'),
        ];
        // Data Peminjaman Fasilitas
        $data_peminjaman = ModelsPeminjaman::whereHas('fasilitas', function ($query) use ($fakultas_id) {
            $query->where('fakultas_id', $fakultas_id);
        })
            ->where('status', 'setujui')
            ->selectRaw('MONTH(waktu_mulai) AS bulan, COUNT(*) AS jumlah, ormawa_id')
            ->groupBy('bulan', 'ormawa_id')
            ->orderBy('ormawa_id')
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
        $data_pengurus = ModelsPengurus::join('periode_kepengurusans', 'penguruses.kepengurusan_id', '=', 'periode_kepengurusans.id')->join('ormawas', 'periode_kepengurusans.ormawa_id', '=', 'ormawas.id')->join('fakultas', 'ormawas.fakultas_id', '=', 'fakultas.id')->where('fakultas_id', $fakultas_id)->orderBy('ormawas.id')->get();
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
        return $data;
    }
    protected function getChartDataByPeriode($fakultas_id, $periode_id)
    {
        $data = [];
        $data['dataOrmawa'] = ModelsOrmawa::where('fakultas_id', $fakultas_id)->get();

        // Data Kegiatan
        $data_kegiatan = ModelsKegiatan::selectRaw('COUNT(*) AS data, MAX(ormawas.name) AS labels, kegiatans.ormawa_id')
            ->join('ormawas', 'kegiatans.ormawa_id', '=', 'ormawas.id')
            ->join(DB::raw("(SELECT id, name FROM ormawas WHERE fakultas_id = $fakultas_id) as filtered_ormawas"), function ($join) {
                $join->on('ormawas.id', '=', 'filtered_ormawas.id');
            })
            ->join('periode_kepengurusans', 'kegiatans.kepengurusan_id', '=', 'periode_kepengurusans.id')
            ->join('periodes', 'periode_kepengurusans.periode_id', '=', 'periodes.id')
            ->where('periodes.id', $periode_id)
            ->groupBy('kegiatans.ormawa_id')
            ->orderBy('ormawas.id')
            ->get()
            ->toArray();

        $chartKegiatan = [
            'labels' => array_column($data_kegiatan, 'labels'),
            'data' => array_column($data_kegiatan, 'data'),
        ];

        // Data Peminjaman Fasilitas
        $data_peminjaman = ModelsPeminjaman::whereHas('ormawa.periodeKepengurusan', function ($query) use ($fakultas_id, $periode_id) {
            $query->where('periode_id', $periode_id);
        })
            ->whereHas('ormawa', function ($query) use ($fakultas_id) {
                $query->where('fakultas_id', $fakultas_id);
            })
            ->where('status', 'setujui')
            ->selectRaw('MONTH(waktu_mulai) AS bulan, COUNT(*) AS jumlah, ormawa_id')
            ->groupBy('bulan', 'ormawa_id')
            ->orderBy('ormawa_id')
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

        // Ambil data pengurus
        $data_pengurus = ModelsPengurus::join('periode_kepengurusans', 'penguruses.kepengurusan_id', '=', 'periode_kepengurusans.id')->join('ormawas', 'periode_kepengurusans.ormawa_id', '=', 'ormawas.id')->join('fakultas', 'ormawas.fakultas_id', '=', 'fakultas.id')->where('fakultas_id', $fakultas_id)->orderBy('ormawas.id')->selectRaw('COUNT(*) AS total_pengurus, ormawas.name AS ormawa_name')->groupBy('ormawas.name')->get();

        $chartKepengurusan = [
            'labels' => [],
            'data' => [],
        ];
        foreach ($data_pengurus as $pengurus) {
            // Ambil nilai total_pengurus dan ormawa_name dari objek pengurus
            $total_pengurus = $pengurus->total_pengurus;
            $ormawa_name = $pengurus->ormawa_name;

            // Tambahkan nilai ke chartKepengurusan
            $chartKepengurusan['labels'][] = $ormawa_name;
            $chartKepengurusan['data'][] = $total_pengurus;
        }

        $data['chartKepengurusan'] = $chartKepengurusan;
        $data['chartPeminjaman'] = array_values($ormawa_data);
        $data['chartKegiatan'] = $chartKegiatan;

        return $data;
    }
    protected $listeners = ['ubahData' => 'changeData'];
    public function changeData()
    {
        $fakultas = ModelsKemahasiswaan::where('user_id', session('user_id'))->get('fakultas_id');
        $fakultas_id = $fakultas[0]->fakultas_id;
        // Data untuk filter
        $data['dataPeriode'] = periode::get();
        if (isset($this->periode_id)) {
            if ($this->periode_id !== '') {
                $data['keaktifanOrmawa'] = $this->getKeaktifanOrmawaByPeriode($fakultas_id, $this->periode_id);
            } else {
                $data['keaktifanOrmawa'] = $this->getKeaktifanOrmawa($fakultas_id);
            }
        } else {
            $data['keaktifanOrmawa'] = $this->getKeaktifanOrmawa($fakultas_id);
        }

        if (isset($this->periode_id)) {
            if ($this->periode_id !== '') {
                $data += $this->getChartDataByPeriode($fakultas_id, $this->periode_id);
            } else {
                $data += $this->getChartData($fakultas_id);
            }
        } else {
            $data += $this->getChartData($fakultas_id);
        }
        $this->dispatch('ubahDataBerhasil', $data);
    }
    public function render()
    {
        $fakultas = ModelsKemahasiswaan::where('user_id', session('user_id'))->get('fakultas_id');
        $fakultas_id = $fakultas[0]->fakultas_id;
        // Data untuk filter
        $data['dataPeriode'] = periode::get();
        if (isset($this->periode_id)) {
            if ($this->periode_id !== '') {
                $data['keaktifanOrmawa'] = $this->getKeaktifanOrmawaByPeriode($fakultas_id, $this->periode_id);
            } else {
                $data['keaktifanOrmawa'] = $this->getKeaktifanOrmawa($fakultas_id);
            }
        } else {
            $data['keaktifanOrmawa'] = $this->getKeaktifanOrmawa($fakultas_id);
        }
        $data += $this->getChartData($fakultas_id);
        return view('livewire.laporan', $data);
    }
}
