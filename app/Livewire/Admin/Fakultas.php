<?php

namespace App\Livewire\Admin;

use App\Livewire\Forms\formFakultas;
use App\Models\fakultas as ModelsFakultas;
use Livewire\Attributes\On;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

class Fakultas extends Component
{
    #[Title('Manajemen Fakultas')]
    public $katakunci = '';
    public formFakultas $form;
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
            $data = ModelsFakultas::orderBy('updated_at', 'desc')
                ->where('name', 'like', '%' . $this->katakunci . '%')
                ->paginate(10);
        } else $data = ModelsFakultas::orderBy('updated_at', 'desc')->paginate(10);
        return view('livewire.admin.fakultas', ['dataFakultas' => $data]);
    }
}
