<?php

namespace App\Livewire\Forms;

use App\Models\ormawa as ModelsOrmawa;
use App\Models\users_kemahasiswaan as ModelsKemahasiswaan;
use Livewire\Attributes\Rule;
use Livewire\Attributes\Validate;
use Livewire\Form;

class formOrmawa extends Form
{
    #[Rule(['required', 'string', 'min:5', 'max:255'])]
    public string $name = '';
    #[Rule(['required', 'string', 'min:3', 'max:255'])]
    public string $type = '';

    public $fakultas_id;
    public $id = '';
    public function store(): void
    {
        $fakultas = ModelsKemahasiswaan::where('user_id', session('user_id'))->get('fakultas_id');
        $this->fakultas_id = $fakultas[0]->fakultas_id;
        if ($this->validate()) {
            $ormawa = ModelsOrmawa::create([
                'name' => $this->name,
                'type' => $this->type,
                'fakultas_id' => $this->fakultas_id,
            ]);
            flash('Ormawa berhasil dibuat.', 'bg-green-100 text-green-800');
            $this->reset();
        }
    }
    public function edit($id)
    {
        $data = ModelsOrmawa::findOrFail($id);
        $this->id = $data->id;
        $this->name = $data->name;
        $this->type = $data->type;
        $this->fakultas_id = $data->fakultas_id;
    }

    public function update()
    {
        if ($this->validate()) {
            $data = ModelsOrmawa::find($this->id);
            $data->update([
                'name' => $this->name,
                'type' => $this->type,
                'fakultas_id' => $this->fakultas_id,
            ]);
        }
        flash('Ormawa berhasil diupdate.', 'bg-green-100 text-green-800');
        $this->reset();
    }
    public function delete($id)
    {
        $data = ModelsOrmawa::findOrFail($id);
        $this->id = $data->id;
    }
    public function deleteConfirm()
    {
        ModelsOrmawa::find($this->id)->delete();
        flash('Ormawa berhasil dihapus.',  'bg-green-100 text-green-800');
        $this->reset();
    }

    public function clear()
    {
        $this->name = '';
        $this->type = '';
    }
}
