<?php

namespace App\Livewire\Admin;

use App\Livewire\Forms\formPeriode;
use App\Models\periode as ModelsPeriode;
use Livewire\Attributes\On;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

class Periode extends Component
{
    #[Title('Manajemen Periode')]
    public $katakunci = '';
    public formPeriode $form;
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
        $data = ModelsPeriode::orderBy('id')->paginate(10);
        return view('livewire.admin.periode', ['dataPeriode' => $data]);
    }
}
