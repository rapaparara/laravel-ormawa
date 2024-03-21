<?php

namespace App\Livewire;

use App\Models\kegiatan as ModelsKegiatan;
use App\Models\periode_kepengurusan as ModelsKepengurusan;
use App\Models\users_kemahasiswaan as ModelsKemahasiswaan;
use App\Models\users_ormawa as ModelsUsersOrmawa;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\WithFileUploads;
use Livewire\WithPagination;

class Kegiatan extends Component
{
    public string $kepengurusan_id = '';
    public string $ormawa_id = '';
    public $name = '';
    public $deskripsi = '';
    public $waktu_mulai = '';
    public $waktu_selesai = '';
    public $image;

    public $temp_image;
    public $id = '';

    public $showModal = false;
    public $editModal = false;
    use WithPagination;
    use WithFileUploads;
    protected $paginationTheme = 'simple-tailwind';

    public function validateSave()
    {
        if ($this->image !== '') {
            $this->validate([
                'kepengurusan_id' => ['required'],
                'name' => ['required', 'string', 'min:5', 'max:255'],
                'deskripsi' => ['required', 'string', 'min:20'],
                'waktu_mulai' => ['required'],
                'waktu_selesai' => ['required'],
            ]);
        } else {
            $this->validate([
                'kepengurusan_id' => ['required'],
                'name' => ['required', 'string', 'min:5', 'max:255'],
                'deskripsi' => ['required', 'string', 'min:20'],
                'waktu_mulai' => ['required'],
                'waktu_selesai' => ['required'],
                'image' => ['image', 'max:1000'],
            ]);
        }
    }
    public function validateUpdate()
    {
        $this->validate([
            'kepengurusan_id' => ['required'],
            'name' => ['required', 'string', 'min:5', 'max:255'],
            'deskripsi' => ['required', 'string', 'min:20'],
            'waktu_mulai' => ['required'],
            'waktu_selesai' => ['required'],
            'temp_image' => ['image', 'max:1000'],
        ]);
    }
    public function save(): void
    {
        $this->validateSave();
        if ($this->image !== '') {
            $path = $this->image->store('gambar-kegiatan', 'public');
            $kegiatan = ModelsKegiatan::create([
                'kepengurusan_id' => $this->kepengurusan_id,
                'ormawa_id' => $this->ormawa_id,
                'name' => $this->name,
                'deskripsi' => $this->deskripsi,
                'waktu_mulai' => $this->waktu_mulai,
                'waktu_selesai' => $this->waktu_selesai,
                'image' => $path,
            ]);
        } else {
            $kegiatan = ModelsKegiatan::create([
                'kepengurusan_id' => $this->kepengurusan_id,
                'ormawa_id' => $this->ormawa_id,
                'name' => $this->name,
                'deskripsi' => $this->deskripsi,
                'waktu_mulai' => $this->waktu_mulai,
                'waktu_selesai' => $this->waktu_selesai,
            ]);
        }
        flash('Kegiatan berhasil dibuat.', 'bg-green-100 text-green-800');
        $this->reset();
    }
    #[On('edit-task')]
    public function edit($id)
    {
        $this->editModal = true;
        $data = ModelsKegiatan::findOrFail($id);
        $this->id = $id;
        $this->kepengurusan_id = $data->kepengurusan_id;
        $this->ormawa_id = $data->ormawa_id;
        $this->name = $data->name;
        $this->deskripsi = $data->deskripsi;
        $this->waktu_mulai = $data->waktu_mulai;
        $this->waktu_selesai = $data->waktu_selesai;
    }
    public function update()
    {
        $data_kegiatan = ModelsKegiatan::find($this->id);
        if ($this->temp_image == '') {
            $data_kegiatan->update([
                'kepengurusan_id' => $this->kepengurusan_id,
                'name' => $this->name,
                'deskripsi' => $this->deskripsi,
                'waktu_mulai' => $this->waktu_mulai,
                'waktu_selesai' => $this->waktu_selesai,
            ]);
        } else {
            $this->validateUpdate();
            unlink('storage/' . $data_kegiatan->image);
            $path = $this->temp_image->store('gambar-kegiatan', 'public');
            $data_kegiatan->update([
                'kepengurusan_id' => $this->kepengurusan_id,
                'name' => $this->name,
                'deskripsi' => $this->deskripsi,
                'waktu_mulai' => $this->waktu_mulai,
                'waktu_selesai' => $this->waktu_selesai,
                'image' => $path,
            ]);
        }
        flash('Kegiatan berhasil diupdate.', 'bg-green-100 text-green-800');
        $this->reset();
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
        $data = ModelsKegiatan::findOrFail($id);
        $this->id = $data->id;
    }
    public function deleteConfirm()
    {
        $kegiatan = ModelsKegiatan::find($this->id);
        unlink('storage/' . $kegiatan->image);
        $kegiatan->delete();
        flash('Kegiatan berhasil dihapus.',  'bg-green-100 text-green-800');
        $this->reset();
    }
    public function clear()
    {
        $this->kepengurusan_id = '';
        $this->ormawa_id = '';
        $this->name = '';
        $this->deskripsi = '';
        $this->waktu_mulai = '';
        $this->waktu_selesai = '';
        $this->image = '';
        $this->temp_image = '';
        $this->id = '';
    }
    public function render()
    {
        if (session('user_role') == 'mahasiswa') {
            $this->ormawa_id = (ModelsUsersOrmawa::where('user_id', session('user_id'))->get('ormawa_id'))[0]->ormawa_id;
            $data_kepengurusan = ModelsKepengurusan::orderBy('id')->where('ormawa_id', $this->ormawa_id)->paginate(10);
            $data_kegiatan = ModelsKegiatan::orderBy('updated_at', 'desc')->where('ormawa_id', $this->ormawa_id)->paginate(10);
        } else {
            $fakultas = ModelsKemahasiswaan::where('user_id', session('user_id'))->get('fakultas_id');
            $fakultas_id = $fakultas[0]->fakultas_id;
            $data_kegiatan = ModelsKegiatan::whereHas('ormawa', function ($query) use ($fakultas_id) {
                $query->where('fakultas_id', $fakultas_id);
            })
                ->orderBy('updated_at', 'desc')
                ->paginate(10);
            $data_kepengurusan = '';
        }
        return view('livewire.kegiatan', [
            'dataKepengurusan' => $data_kepengurusan,
            'dataKegiatan' => $data_kegiatan,
        ]);
    }
}
