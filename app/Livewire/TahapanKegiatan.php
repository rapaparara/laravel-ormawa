<?php

namespace App\Livewire;

use App\Models\dokumentasi as ModelsDokumentasi;
use App\Models\kegiatan as ModelsKegiatan;
use App\Models\tahapan_kegiatan as ModelsTahapan;
use App\Models\users_kemahasiswaan as ModelsKemahasiswaan;
use App\Models\users_ormawa as ModelsUsersOrmawa;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class TahapanKegiatan extends Component
{
    public $kegiatan_id, $name, $deskripsi, $katakunci, $byKegiatan, $waktu_mulai, $waktu_selesai, $status, $id;
    public $showModal = false;
    public $editModal = false;

    use WithPagination;
    use WithFileUploads;
    public $dokumentasi;
    public $data_dokumentasi = [];
    public function closeModal()
    {
        $this->showModal = false;
        $this->clear();
    }
    public function editStateModal()
    {
        $this->editModal = false;
        $this->clear();
    }
    public function clear()
    {
        $this->kegiatan_id = '';
        $this->name = '';
        $this->deskripsi = '';
        $this->waktu_mulai = '';
        $this->waktu_selesai = '';
        $this->status = '';
        $this->id = '';
    }
    public function save()
    {
        $this->validateData();
        ModelsTahapan::create([
            'kegiatan_id' => $this->kegiatan_id,
            'name' => $this->name,
            'deskripsi' => $this->deskripsi,
            'waktu_mulai' => $this->waktu_mulai,
            'waktu_selesai' => $this->waktu_selesai,
            'status' => 'belum',
        ]);
        flash('Tahapan kegiatan berhasil ditambahkan.', 'bg-green-100 text-green-800');
        $this->reset();
    }
    public function validateData()
    {
        $this->validate([
            'kegiatan_id' => ['required'],
            'name' => ['required', 'string', 'min:5', 'max:255'],
            'deskripsi' => ['required', 'string', 'min:3', 'max:500'],
            'waktu_mulai' => ['required'],
            'waktu_selesai' => ['required'],
        ]);
    }
    #[On('edit-task')]
    public function edit($id)
    {
        $this->editModal = true;
        $data = ModelsTahapan::findOrFail($id);
        $this->id = $id;
        $this->kegiatan_id = $data->kegiatan_id;
        $this->name = $data->name;
        $this->deskripsi = $data->deskripsi;
        $this->waktu_mulai = $data->waktu_mulai;
        $this->waktu_selesai = $data->waktu_selesai;
        $this->status = $data->status;
    }
    public function update()
    {
        $data = ModelsTahapan::find($this->id);
        $this->validateData();
        try {
            $data->update([
                'kegiatan_id' => $this->kegiatan_id,
                'name' => $this->name,
                'deskripsi' => $this->deskripsi,
                'waktu_mulai' => $this->waktu_mulai,
                'waktu_selesai' => $this->waktu_selesai,
                'status' => $this->status,
            ]);
            flash('Tahapan kegiatan berhasil diubah.', 'bg-green-100 text-green-800');
        } catch (\Throwable $th) {
            flash('Gagal mengubah tahapan kegiatan.', 'bg-red-100 text-red-800');
        }
        $this->reset();
    }
    public function delete($id)
    {
        $data = ModelsTahapan::findOrFail($id);
        $this->id = $data->id;
    }
    public function deleteConfirm()
    {
        try {
            ModelsTahapan::find($this->id)->delete();
            flash('Tahapan kegiatan berhasil dihapus.', 'bg-green-100 text-green-800');
        } catch (\Throwable $th) {
            flash('Gagal menghapus tahapan kegiatan.', 'bg-red-100 text-red-800');
        }
        $this->reset();
    }
    public function lihat($id)
    {
        $this->editModal = true;
        $data = ModelsTahapan::findOrFail($id);
        $this->id = $id;
        $this->kegiatan_id = $data->kegiatan_id;
        $this->name = $data->name;
        $this->deskripsi = $data->deskripsi;
        $this->waktu_mulai = $data->waktu_mulai;
        $this->waktu_selesai = $data->waktu_selesai;
        $this->status = $data->status;
        $this->data_dokumentasi = ModelsDokumentasi::where('tahapan_kegiatan_id', $id)->get();
    }
    public function validateUpload()
    {
        $this->validate([
            'dokumentasi' => ['required', 'file', 'image', 'max:512'],
        ]);
    }
    public function uploadFile()
    {
        try {
            $this->validateUpload();
            $path = $this->dokumentasi->store('dokumentasi', 'public');
            ModelsDokumentasi::create([
                'tahapan_kegiatan_id' => $this->id,
                'file_dokumentasi' => $path,
            ]);
            flash('Dokumentasi berhasil ditambahkan.', 'bg-green-100 text-green-800');
        } catch (\Throwable $th) {
            flash('Gagal menambahkan dokumentasi.', 'bg-red-100 text-red-800');
        }
        $this->clear();
        $this->reset();
    }
    public function deleteDokumentasi($id)
    {
        try {
            $dokumentasi = ModelsDokumentasi::find($id);
            $path = $dokumentasi->file_dokumentasi;
            $dokumentasi->delete();
            unlink('storage/' . $path);
            flash('Dokumentasi berhasil dihapus.', 'bg-green-100 text-green-800');
            $this->reset();
        } catch (\Throwable $th) {
            flash('Gagal menghapus dokumentasi.', 'bg-red-100 text-red-800');
        }
        $this->clear();
    }
    public function render()
    {
        $data = [];
        if (session('user_role') == 'mahasiswa') {
            $ormawa_id = ModelsUsersOrmawa::where('user_id', session('user_id'))->value('ormawa_id');
            $data['dataKegiatan'] = ModelsKegiatan::where('ormawa_id', $ormawa_id)->get();
            $data_tahapan_query = ModelsTahapan::whereHas('kegiatan', function ($query) use ($ormawa_id) {
                $query->where('ormawa_id', $ormawa_id);
            })->orderBy('tahapan_kegiatans.updated_at', 'desc');
        } elseif(session('user_role') == 'kemahasiswaan') {
            $fakultas_id = ModelsKemahasiswaan::where('user_id', session('user_id'))->value('fakultas_id');
            $data_tahapan_query = ModelsTahapan::join('kegiatans', 'tahapan_kegiatans.kegiatan_id', '=', 'kegiatans.id')->join('ormawas', 'kegiatans.ormawa_id', '=', 'ormawas.id')->join('fakultas', 'ormawas.fakultas_id', '=', 'fakultas.id')->select('tahapan_kegiatans.id as tahapan_id', 'tahapan_kegiatans.*')->where('fakultas_id', $fakultas_id)->orderBy('tahapan_kegiatans.updated_at', 'desc');
            $data['dataKegiatan'] = ModelsKegiatan::whereHas('ormawa', function ($query) use ($fakultas_id) {
                $query->where('fakultas_id', $fakultas_id);
            })
                ->orderBy('updated_at', 'desc')
                ->get();
        } else {
            $data_tahapan_query = ModelsTahapan::join('kegiatans', 'tahapan_kegiatans.kegiatan_id', '=', 'kegiatans.id')->join('ormawas', 'kegiatans.ormawa_id', '=', 'ormawas.id')->select('tahapan_kegiatans.id as tahapan_id', 'tahapan_kegiatans.*')->orderBy('tahapan_kegiatans.updated_at', 'desc');
            $data['dataKegiatan'] = ModelsKegiatan::orderBy('updated_at', 'desc')
                ->get();
        }
        if ($this->katakunci != null) {
            $data_tahapan_query->where(function ($query) {
                $query->where('tahapan_kegiatans.name', 'like', '%' . $this->katakunci . '%')->orWhere('tahapan_kegiatans.deskripsi', 'like', '%' . $this->katakunci . '%');
            });
        }
        if ($this->byKegiatan != null) {
            $data_tahapan_query->where(function ($query) {
                $query->where('kegiatan_id', $this->byKegiatan);
            });
        }
        $data['dataDokumentasi'] = $this->data_dokumentasi;
        $data['dataTahapan'] = $data_tahapan_query->paginate(10);
        return view('livewire.tahapan-kegiatan', $data);
    }
}
