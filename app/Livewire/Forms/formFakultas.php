<?php

namespace App\Livewire\Forms;

use App\Models\fakultas;
use Livewire\Attributes\Rule;
use Livewire\Attributes\Validate;
use Livewire\Form;

class formFakultas extends Form
{
    #[Rule(['required', 'string', 'min:5', 'max:255'])]
    public string $name = '';

    public $id = '';
    public function store(): void
    {
        if ($this->validate()) {
            $fakultas = fakultas::create([
                'name' => $this->name,
            ]);
            flash('Fakultas berhasil dibuat.', 'bg-green-100 text-green-800');
            $this->reset();
        }
    }
    public function edit($id)
    {
        $data = fakultas::findOrFail($id);
        $this->id = $data->id;
        $this->name = $data->name;
    }

    public function update()
    {
        if ($this->validate()) {
            $data = fakultas::find($this->id);
            $data->update([
                'name' => $this->name,
            ]);
        }
        flash('Fakultas berhasil diupdate.', 'bg-green-100 text-green-800');
        $this->reset();
    }
    public function delete($id)
    {
        $data = fakultas::findOrFail($id);
        $this->id = $data->id;
    }
    public function deleteConfirm()
    {
        fakultas::find($this->id)->delete();
        flash('Fakultas berhasil dihapus.',  'bg-green-100 text-green-800');
        $this->reset();
    }
    public function clear()
    {
        $this->name = '';
    }
}
