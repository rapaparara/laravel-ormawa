<?php

namespace App\Livewire\Mahasiswa;

use App\Models\periode as ModelsPeriode;
use App\Models\periode_kepengurusan as ModelsKepengurusan;
use App\Models\users_ormawa as ModelsUsersOrmawa;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\On;
use Livewire\Attributes\Rule;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class Kepengurusan extends Component
{
    #[Title('Manajemen Kepengurusan Ormawa')]
    #[Rule(['required'])]
    public string $periode_id = '';
    public string $ormawa_id = '';
    #[Rule(['required', 'file', 'min:3', 'max:2048'])]
    public $file_sk;
    public string $status = '';

    public $embed_file_sk;
    public $id = '';
    use WithPagination;
    use WithFileUploads;
    protected $paginationTheme = 'simple-tailwind';
    public $showModal = false;
    public $editModal = false;
    public function save(): void
    {
        if ($this->validate()) {
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
    }
    public function lihat($file_sk)
    {
        $this->embed_file_sk = $file_sk;
    }
    #[On('edit-task')]
    public function edit($id)
    {
        // $this->editModal = true;
        // $this->form->edit($id);
    }
    public function update()
    {
        // $this->form->update();
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
    public function clear()
    {
        $this->periode_id = '';
        $this->ormawa_id = '';
        $this->file_sk = '';
        $this->status = '';
        $this->id = '';
    }
    public function render()
    {
        if (session('user_role') == 'mahasiswa') {
            $ormawa_id = (ModelsUsersOrmawa::where('user_id', session('user_id'))->get('ormawa_id'))[0]->ormawa_id;
            $data_kepengurusan = ModelsKepengurusan::orderBy('id')->where('ormawa_id', $ormawa_id)->paginate(10);
        } else {
            $data_kepengurusan = ModelsKepengurusan::orderBy('id')->paginate(10);
        }
        $data_periode = ModelsPeriode::orderBy('id')->paginate(10);
        return view('livewire.mahasiswa.kepengurusan', [
            'dataKepengurusan' => $data_kepengurusan,
            'dataPeriode' => $data_periode,
        ]);
    }
}
