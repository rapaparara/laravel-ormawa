<?php

namespace App\Livewire\Admin;

use App\Livewire\Forms\formPengguna;
use App\Models\User;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;


class Pengguna extends Component
{
    public $katakunci = '';
    public formPengguna $form;
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
        if ($this->katakunci != null) {
            $data = User::orderBy('id')->where('role', 'admin')->orWhere('role', 'kemahasiswaan')->get();
            $data_filter = User::orderBy('id')
                ->where('username', 'like', '%' . $this->katakunci . '%')
                ->orWhere('name', 'like', '%' . $this->katakunci . '%')
                ->paginate(10);
        } else $data_filter = User::orderBy('id')->where('role', 'admin')->orWhere('role', 'kemahasiswaan')->paginate(10);
        return view('livewire.admin.pengguna', ['dataPengguna' => $data_filter]);
    }
}
