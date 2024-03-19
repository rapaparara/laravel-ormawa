<?php

namespace App\Livewire;

use App\Models\periode as ModelsPeriode;
use App\Models\periode_kepengurusan as ModelsKepengurusan;
use App\Models\users_ormawa as ModelsUsersOrmawa;
use App\Models\users_kemahasiswaan as ModelsKemahasiswaan;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\On;
use Livewire\Attributes\Rule;
use Livewire\Attributes\Title;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use Livewire\Component;

class Kepengurusan extends Component
{
    public string $periode_id = '';
    public string $ormawa_id = '';
    public $file_sk;
    public $temp_file_sk;
    public string $status = '';

    public $embed_file_sk;
    public $id = '';

    public $showModal = false;
    public $editModal = false;
    use WithPagination;
    use WithFileUploads;
    protected $paginationTheme = 'simple-tailwind';
    public function save(): void
    {
        $this->validateSave();
        $path = $this->file_sk->store('file-sk', 'public');
        $ormawa_id = (ModelsUsersOrmawa::where('user_id', session('user_id'))->get('ormawa_id'))[0]->ormawa_id;
        $kepengurusan = ModelsKepengurusan::create([
            'periode_id' => $this->periode_id,
            'ormawa_id' => $ormawa_id,
            'file_sk' => $path,
            'status' => 'belum',
        ]);
        flash('Periode kepengurusan berhasil dibuat.', 'bg-green-100 text-green-800');
        $this->reset();
    }
    public function lihat($file_sk)
    {
        $this->embed_file_sk = $file_sk;
    }
    #[On('edit-task')]
    public function edit($id)
    {
        $this->editModal = true;
        $data = ModelsKepengurusan::findOrFail($id);
        $this->id = $data->id;
        $this->periode_id = $data->periode_id;
        $this->file_sk = $data->file_sk;
    }
    public function update()
    {
        $data_kepengurusan = ModelsKepengurusan::find($this->id);
        if ($this->temp_file_sk == '') {
            $data_kepengurusan->update([
                'periode_id' => $this->periode_id,
            ]);
        } else {
            $this->validateUpdate();
            unlink('storage/' . $data_kepengurusan->file_sk);
            $path = $this->temp_file_sk->store('file-sk', 'public');
            $data_kepengurusan->update([
                'periode_id' => $this->periode_id,
                'file_sk' => $path,
            ]);
        }
        flash('Periode kepengurusan berhasil diupdate.', 'bg-green-100 text-green-800');
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
        $data = ModelsKepengurusan::findOrFail($id);
        $this->id = $data->id;
    }
    public function deleteConfirm()
    {
        $kepengurusan = ModelsKepengurusan::find($this->id);
        unlink('storage/' . $kepengurusan->file_sk);
        $kepengurusan->delete();
        flash('Periode kepengurusan berhasil dihapus.',  'bg-green-100 text-green-800');
        $this->reset();
    }

    public function validateSave()
    {
        $this->validate([
            'file_sk' => ['required', 'file', 'mimetypes:application/pdf', 'min:3', 'max:2048'],
        ]);
    }
    public function validateUpdate()
    {
        $this->validate([
            'temp_file_sk' => ['required', 'file', 'mimetypes:application/pdf', 'min:3', 'max:2048'],
        ]);
    }
    #[On('edit-task')]
    public function ganti($id)
    {
        $data = ModelsKepengurusan::findOrFail($id);
        $this->id = $data->id;
        $this->status = $data->status;
    }

    public function updateStatus()
    {
        $data = ModelsKepengurusan::find($this->id);
        $data->update([
            'status' => $this->status,
        ]);
        flash('Status berhasil diupdate.', 'bg-green-100 text-green-800');
        $this->reset();
    }
    public function clear()
    {
        $this->periode_id = '';
        $this->ormawa_id = '';
        $this->file_sk = '';
        $this->temp_file_sk = '';
        $this->status = '';
        $this->id = '';
    }
    public function render()
    {
        if (session('user_role') == 'mahasiswa') {
            $ormawa_id = (ModelsUsersOrmawa::where('user_id', session('user_id'))->get('ormawa_id'))[0]->ormawa_id;
            $data_kepengurusan = ModelsKepengurusan::orderBy('id')->where('ormawa_id', $ormawa_id)->paginate(10);
        } else {
            $fakultas = ModelsKemahasiswaan::where('user_id', session('user_id'))->get('fakultas_id');
            $fakultas_id = $fakultas[0]->fakultas_id;
            $data_kepengurusan = ModelsKepengurusan::whereHas('ormawa', function ($query) use ($fakultas_id) {
                $query->where('fakultas_id', $fakultas_id);
            })
                ->orderBy('id')
                ->paginate(10);
        }
        $data_periode = ModelsPeriode::orderBy('id')->paginate(10);
        return view('livewire.kepengurusan', [
            'dataKepengurusan' => $data_kepengurusan,
            'dataPeriode' => $data_periode,
        ]);
    }
}
