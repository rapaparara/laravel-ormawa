<?php

namespace App\Livewire\Admin;

use App\Livewire\Forms\formKemahasiswaan;
use App\Models\fakultas;
use App\Models\User;
use App\Models\users_kemahasiswaan;
use Livewire\Attributes\On;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

class Kemahasiswaan extends Component
{
    #[Title('Manajemen Pengguna Kemahasiswaan')]
    public formKemahasiswaan $form;
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
        $data_kemahasiswaan = users_kemahasiswaan::orderBy('updated_at', 'desc')->paginate(10);
        $data_users = User::orderBy('name')->where('role', 'kemahasiswaan')->get();
        $data_fakultas = fakultas::orderBy('name')->get();
        return view('livewire.admin.kemahasiswaan', [
            'dataKemahasiswaan' => $data_kemahasiswaan,
            'dataUsers' => $data_users,
            'dataFakultas' => $data_fakultas,
        ]);
    }
}
