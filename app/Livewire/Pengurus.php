<?php

namespace App\Livewire;

use App\Imports\PengurusImport;
use App\Models\pengurus as ModelsPengurus;
use App\Models\periode_kepengurusan as ModelsKepengurusan;
use App\Models\users_kemahasiswaan as ModelsKemahasiswaan;
use App\Models\users_ormawa as ModelsUsersOrmawa;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;

class Pengurus extends Component
{
    public $id, $nama, $nim, $kepengurusan_id, $katakunci;
    public $showModal = false;
    public $editModal = false;
    use WithPagination;
    use WithFileUploads;

    public $file_upload;

    #[On('edit-task')]
    public function edit($id)
    {
        $this->editModal = true;
        $data = ModelsPengurus::findOrFail($id);
        $this->id = $id;
        $this->kepengurusan_id = $data->kepengurusan_id;
        $this->nama = $data->nama;
        $this->nim = $data->nim;
    }
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
    public function delete($id)
    {
        $data = ModelsPengurus::findOrFail($id);
        $this->id = $data->id;
    }
    public function deleteConfirm()
    {
        $data = ModelsPengurus::find($this->id);
        $data->delete();
        flash('Kegiatan berhasil dihapus.',  'bg-green-100 text-green-800');
        $this->reset();
    }
    public function clear()
    {
        $this->id = '';
        $this->kepengurusan_id = '';
        $this->nama = '';
        $this->nim = '';
    }
    public function update()
    {
        $data = ModelsPengurus::find($this->id);
        $this->validateUpdate();
        $data->update([
            'kepengurusan_id' => $this->kepengurusan_id,
            'nama' => $this->nama,
            'nim' => $this->nim,
        ]);
        flash('Pengurus berhasil diupdate.', 'bg-green-100 text-green-800');
        $this->reset();
    }
    public function validateUpdate()
    {
        $this->validate([
            'kepengurusan_id' => ['required'],
            'nama' => ['required', 'string', 'min:5', 'max:255'],
            'nim' => ['required', 'string', 'min:3', 'max:13'],
        ]);
    }
    public function validateUpload()
    {
        $this->validate([
            'kepengurusan_id' => ['required'],
            'file_upload' => ['required', 'mimes:csv,xls,xlsx', 'max:2048'],
        ]);
    }
    public function uploadFile()
    {
        try {
            $this->validateUpload();
            $path = $this->file_upload->store('file-import', 'public');
            Excel::import(new PengurusImport($this->kepengurusan_id), public_path('/storage/' . $path));
            unlink(public_path('storage/' . $path));
            flash('Pengurus berhasil diupload.', 'bg-green-100 text-green-800');
            $this->reset();
        } catch (\Exception $e) {
            flash('Terjadi kesalahan saat mengunggah pengurus.', 'bg-red-100 text-red-800');
        }
    }
    public function validateSave()
    {
        $this->validate([
            'kepengurusan_id' => ['required'],
            'nama' => ['required', 'string', 'min:5', 'max:255'],
            'nim' => ['required', 'string', 'min:3', 'max:13'],
        ]);
    }
    public function save()
    {
        $this->validateSave();
        $pengurus = ModelsPengurus::create([
            'kepengurusan_id' => $this->kepengurusan_id,
            'nama' => $this->nama,
            'nim' => $this->nim,
        ]);
        flash('Pengurus berhasil ditambahkan.', 'bg-green-100 text-green-800');
        $this->reset();
    }
    public function render()
    {
        $data = [];
        if (session('user_role') == 'mahasiswa') {
            $ormawa_id = ModelsUsersOrmawa::where('user_id', session('user_id'))->value('ormawa_id');
            $data['dataKepengurusan'] = ModelsKepengurusan::where('ormawa_id', $ormawa_id)
                ->where('status', 'setujui')
                ->get();
            $data_pengurus_query = ModelsPengurus::whereHas('kepengurusan', function ($query) use ($ormawa_id) {
                $query->where('ormawa_id', $ormawa_id)->orderBy('penguruses.id', 'desc');
            });
        } else {
            $fakultas_id = ModelsKemahasiswaan::where('user_id', session('user_id'))->value('fakultas_id');
            $data_pengurus_query = ModelsPengurus::join('periode_kepengurusans', 'penguruses.kepengurusan_id', '=', 'periode_kepengurusans.id')
                ->join('ormawas', 'periode_kepengurusans.ormawa_id', '=', 'ormawas.id')
                ->join('fakultas', 'ormawas.fakultas_id', '=', 'fakultas.id')
                ->where('fakultas_id', $fakultas_id)->orderBy('penguruses.id', 'desc');
        }
        if ($this->katakunci != null) {
            $data_pengurus_query->where(function ($query) {
                $query->where('nama', 'like', '%' . $this->katakunci . '%')
                    ->orWhere('nim', 'like', '%' . $this->katakunci . '%');
            });
        }
        $data['dataPengurus'] = $data_pengurus_query->paginate(10);
        return view('livewire.pengurus', $data);
    }
}
