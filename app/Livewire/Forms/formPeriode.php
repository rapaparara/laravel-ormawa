<?php

namespace App\Livewire\Forms;

use App\Models\periode as ModelsPeriode;
use Livewire\Attributes\Rule;
use Livewire\Attributes\Validate;
use Livewire\Form;

class formPeriode extends Form
{
    #[Rule(['required', 'string', 'min:5', 'max:255'])]
    public string $name = '';

    public $id = '';
    public function store(): void
    {
        if ($this->validate()) {
            $periode = ModelsPeriode::create([
                'name' => $this->name,
            ]);
            flash('Periode berhasil ditambahkan.', 'bg-green-100 text-green-800');
            $this->reset();
        }
    }
    public function edit($id)
    {
        $data = ModelsPeriode::findOrFail($id);
        $this->id = $data->id;
        $this->name = $data->name;
    }
    public function update()
    {
        if ($this->validate()) {
            $data = ModelsPeriode::find($this->id);
            $data->update([
                'name' => $this->name,
            ]);
        }
        flash('Periode berhasil diupdate.', 'bg-green-100 text-green-800');
        $this->reset();
    }
    public function delete($id)
    {
        $data = ModelsPeriode::findOrFail($id);
        $this->id = $data->id;
    }
    public function deleteConfirm()
    {
        ModelsPeriode::find($this->id)->delete();
        flash('Periode berhasil dihapus.',  'bg-green-100 text-green-800');
        $this->reset();
    }
    public function clear()
    {
        $this->name = '';
    }
}
