<?php

namespace App\Livewire\Forms;

use App\Models\fasilitas as ModelsFasilitas;
use App\Models\users_kemahasiswaan as ModelsKemahasiswaan;
use Livewire\Attributes\Rule;
use Livewire\Attributes\Validate;
use Livewire\Form;

class formFasilitas extends Form
{
    #[Rule(['required', 'string', 'min:5', 'max:255'])]
    public string $name = '';

    public $fakultas_id;
    public $id = '';
    public function store(): void
    {
        $fakultas = ModelsKemahasiswaan::where('user_id', session('user_id'))->get('fakultas_id');
        $this->fakultas_id = $fakultas[0]->fakultas_id;
        if ($this->validate()) {
            $fasilitas = ModelsFasilitas::create([
                'name' => $this->name,
                'fakultas_id' => $this->fakultas_id,
            ]);
            flash('Fasilitas berhasil ditambahkan.', 'bg-green-100 text-green-800');
            $this->reset();
        }
    }
    public function edit($id)
    {
        $data = ModelsFasilitas::findOrFail($id);
        $this->id = $data->id;
        $this->name = $data->name;
        $this->fakultas_id = $data->fakultas_id;
    }

    public function update()
    {
        if ($this->validate()) {
            $data = ModelsFasilitas::find($this->id);
            $data->update([
                'name' => $this->name,
                'fakultas_id' => $this->fakultas_id,
            ]);
        }
        flash('Fasilitas berhasil diupdate.', 'bg-green-100 text-green-800');
        $this->reset();
    }
    public function delete($id)
    {
        $data = ModelsFasilitas::findOrFail($id);
        $this->id = $data->id;
    }
    public function deleteConfirm()
    {
        ModelsFasilitas::find($this->id)->delete();
        flash('Fasilitas berhasil dihapus.',  'bg-green-100 text-green-800');
        $this->reset();
    }

    public function clear()
    {
        $this->name = '';
    }
}
