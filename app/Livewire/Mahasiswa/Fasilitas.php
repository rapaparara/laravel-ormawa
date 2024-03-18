<?php

namespace App\Livewire\Mahasiswa;

use App\Livewire\Forms\formFasilitasMahasiswa;
use App\Models\fasilitas as ModelsFasilitas;
use App\Models\users_ormawa as ModelsUsersOrmawa;
use App\Models\ormawa as ModelsOrmawa;
use App\Models\peminjaman_fasilitas as ModelsPeminjaman;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class Fasilitas extends Component
{
    public formFasilitasMahasiswa $form;
    use WithPagination;
    protected $paginationTheme = 'simple-tailwind';
    public $showModal = false;
    public $editModal = false;

    public function save()
    {
        $this->form->store();
    }
    #[On('edit-task')]
    public function edit($id)
    {
        $this->editModal = true;
        $this->form->edit($id);
    }
    public function update()
    {
        $this->form->update();
    }
    public function closeModal()
    {
        $this->showModal = false;
        $this->form->clear();
    }
    public function editStateModal()
    {
        $this->editModal = false;
        $this->form->clear();
    }
    public function delete($id)
    {
        $this->form->delete($id);
    }
    public function deleteConfirm()
    {
        $this->form->deleteConfirm();
    }
    public function render()
    {
        $ormawa_id = (ModelsUsersOrmawa::where('user_id', session('user_id'))->get('ormawa_id'))[0]->ormawa_id;
        $data_fasilitas = ModelsFasilitas::orderBy('fakultas_id')->get();
        $data_peminjaman_ormawa = ModelsPeminjaman::where('ormawa_id', $ormawa_id)
            ->orderBy('waktu_mulai', 'desc')
            ->paginate(5);
        return view('livewire.mahasiswa.fasilitas', [
            'dataPeminjamanOrmawa' => $data_peminjaman_ormawa,
            'dataFasilitas' => $data_fasilitas,
        ]);
    }
}
