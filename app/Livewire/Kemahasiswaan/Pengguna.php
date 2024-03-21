<?php

namespace App\Livewire\Kemahasiswaan;

use App\Livewire\Forms\formPenggunaOrmawa;
use App\Models\fakultas;
use App\Models\ormawa;
use App\Models\User;
use App\Models\users_kemahasiswaan;
use App\Models\users_ormawa as ModelsPengguna;
use App\Models\users_ormawa;
use Livewire\Attributes\On;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

class Pengguna extends Component
{
    #[Title('Manajemen Pengguna Ormawa')]
    public formPenggunaOrmawa $form;
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
        $fakultas_id = (users_kemahasiswaan::where('user_id', session('user_id'))->get('fakultas_id'))[0]->fakultas_id;
        $data_ormawa = ormawa::where('fakultas_id', $fakultas_id)->get();
        $data_pengguna = ModelsPengguna::with('ormawa')
            ->whereHas('ormawa', function ($query) use ($fakultas_id) {
                $query->where('fakultas_id', $fakultas_id);
            })->orderBy('updated_at', 'desc')
            ->paginate(10);
        return view('livewire.kemahasiswaan.pengguna', [
            'dataPengguna' => $data_pengguna,
            'dataOrmawa' => $data_ormawa,
        ]);
    }
}
