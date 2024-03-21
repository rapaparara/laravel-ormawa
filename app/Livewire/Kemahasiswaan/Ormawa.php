<?php

namespace App\Livewire\Kemahasiswaan;

use App\Livewire\Forms\formOrmawa;
use App\Models\ormawa as ModelsOrmawa;
use App\Models\users_kemahasiswaan as ModelsKemahasiswaan;
use Livewire\Attributes\On;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

class Ormawa extends Component
{
    #[Title('Manajemen Ormawa')]
    public $katakunci = '';
    public formOrmawa $form;
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
        $fakultas = ModelsKemahasiswaan::where('user_id', session('user_id'))->get('fakultas_id');
        $fakultas_id = $fakultas[0]->fakultas_id;
        $data_ormawa = ModelsOrmawa::where('fakultas_id', $fakultas_id);
        if ($this->katakunci != null) {
            $data = $data_ormawa->where(function ($query) {
                $query->where('name', 'like', '%' . $this->katakunci . '%')
                    ->orWhere('type', 'like', '%' . $this->katakunci . '%');
            })->orderBy('updated_at', 'desc')
                ->paginate(10);
        } else $data = $data_ormawa->orderBy('updated_at', 'desc')->paginate(10);
        return view('livewire.kemahasiswaan.ormawa', [
            'dataOrmawa' => $data,
        ]);
    }
}
