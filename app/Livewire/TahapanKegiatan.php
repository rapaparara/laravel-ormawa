<?php

namespace App\Livewire;

use App\Models\kegiatan as ModelsKegiatan;
use App\Models\tahapan_kegiatan as ModelsTahapan;
use App\Models\users_kemahasiswaan as ModelsKemahasiswaan;
use App\Models\users_ormawa as ModelsUsersOrmawa;
use Livewire\Component;

class TahapanKegiatan extends Component
{
    public $kegiatan_id, $name, $deskripsi, $katakunci,
        $waktu_mulai, $waktu_selesai, $status, $id;
    public function render()
    {
        $data = [];
        if (session('user_role') == 'mahasiswa') {
            $ormawa_id = ModelsUsersOrmawa::where('user_id', session('user_id'))->value('ormawa_id');
            $data['dataKegiatan'] = ModelsKegiatan::where('ormawa_id', $ormawa_id)->get();
            $data_tahapan_query = ModelsTahapan::whereHas('kegiatan', function ($query) use ($ormawa_id) {
                $query->where('ormawa_id', $ormawa_id)->orderBy('tahapan_kegiatans.id', 'desc');
            });
        } else {
            $fakultas_id = ModelsKemahasiswaan::where('user_id', session('user_id'))->value('fakultas_id');
            $data_tahapan_query = ModelsTahapan::join('kegiatans', 'tahapan_kegiatans.kegiatan_id', '=', 'kegiatans.id')
                ->join('ormawas', 'kegiatans.ormawa_id', '=', 'ormawas.id')
                ->join('fakultas', 'ormawas.fakultas_id', '=', 'fakultas.id')
                ->where('fakultas_id', $fakultas_id)->orderBy('tahapan_kegiatans.id', 'desc');
        }
        if ($this->katakunci != null) {
            $data_tahapan_query->where(function ($query) {
                $query->where('nama', 'like', '%' . $this->katakunci . '%');
            });
        }
        $data['dataTahapan'] = $data_tahapan_query->paginate(10);
        return view('livewire.tahapan-kegiatan', $data);
    }
}
