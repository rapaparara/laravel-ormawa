<?php

namespace App\Livewire\Home;

use App\Models\dokumentasi as ModelsDokumentasi;
use App\Models\kegiatan as ModelsKegiatan;
use App\Models\ormawa as ModelsOrmawa;
use App\Models\tahapan_kegiatan as ModelsTahapan;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

class Kegiatan extends Component
{
    use WithPagination;
    #[Title('Kegiatan Ormawa')]
    public $katakunci, $byOrmawa;
    public $id, $name, $deskripsi, $ormawa, $waktu_mulai, $waktu_selesai, $image, $data_dokumentasi, $data_tahapan;

    public function lihat($id)
    {
        $data = ModelsKegiatan::findOrFail($id);
        $this->id = $id;
        $this->name = $data->name;
        $this->ormawa = $data->ormawa->name;
        $this->deskripsi = $data->deskripsi;
        $this->waktu_mulai = $data->waktu_mulai;
        $this->waktu_selesai = $data->waktu_selesai;
        $this->image = $data->image;
        $this->data_tahapan = ModelsTahapan::where('kegiatan_id', $id)->get();
        $data_dokumentasi = [];
        foreach ($this->data_tahapan as $value) {
            $dokumentasi = ModelsDokumentasi::where('tahapan_kegiatan_id', $value->id)->get();
            foreach ($dokumentasi as $item) {
                $data_dokumentasi[] = [
                    'tahapan_kegiatan_id' => $item->tahapan_kegiatan_id,
                    'file_dokumentasi' => $item->file_dokumentasi,
                ];
            }
        }
        $this->data_dokumentasi = $data_dokumentasi;
    }
    public function render()
    {
        $data = [];
        $data_kegiatan = ModelsKegiatan::orderBy('created_at', 'desc');
        $data['dataOrmawa'] = ModelsOrmawa::orderBy('fakultas_id')->get();
        if ($this->katakunci != null) {
            $data_kegiatan = ModelsKegiatan::orderBy('created_at', 'desc')
                ->where('name', 'like', '%' . $this->katakunci . '%')
                ->orWhere('deskripsi', 'like', '%' . $this->katakunci . '%');
        }
        if ($this->byOrmawa != null) {
            $data_kegiatan = ModelsKegiatan::orderBy('created_at', 'desc')
                ->where('ormawa_id', $this->byOrmawa);
        }
        $data['dataDokumentasi'] = $this->data_dokumentasi;
        $data['dataTahapan'] = $this->data_tahapan;
        $data['dataKegiatan'] = $data_kegiatan->paginate(6);
        return view('livewire.home.kegiatan', $data);
    }
}
