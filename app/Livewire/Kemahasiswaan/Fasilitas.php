<?php

namespace App\Livewire\Kemahasiswaan;

use App\Livewire\Forms\formFasilitas;
use App\Models\fasilitas as ModelsFasilitas;
use App\Models\users_kemahasiswaan as ModelsKemahasiswaan;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class Fasilitas extends Component
{
    public $katakunci = '';
    public formFasilitas $form;
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
        if ($this->katakunci != null) {
            $data = ModelsFasilitas::orderBy('id')
                ->where('fakultas_id', $fakultas_id)
                ->where('name', 'like', '%' . $this->katakunci . '%')
                ->paginate(5);
        } else $data = ModelsFasilitas::orderBy('id')->where('fakultas_id', $fakultas_id)->paginate(5);
        return view('livewire.kemahasiswaan.fasilitas', ['dataFasilitas' => $data]);
    }
}
