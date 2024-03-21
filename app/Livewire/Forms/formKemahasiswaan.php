<?php

namespace App\Livewire\Forms;

use App\Models\users_kemahasiswaan;
use Livewire\Attributes\Rule;
use Livewire\Attributes\Validate;
use Livewire\Form;
use PDO;

class formKemahasiswaan extends Form
{
    #[Rule(['required'])]
    public $user_id = '';
    #[Rule(['required'])]
    public $fakultas_id = '';

    public $id = '';
    public function store(): void
    {
        if ($this->validate()) {
            $data = users_kemahasiswaan::where('user_id', $this->user_id)->first();
            if ($data == null) {
                $kemahasiswaan = users_kemahasiswaan::create([
                    'user_id' => $this->user_id,
                    'fakultas_id' => $this->fakultas_id,
                ]);
                flash('User kemahasiswaan berhasil ditambahkan.', 'bg-green-100 text-green-800');
                $this->reset();
            } else {
                flash('User ini sudah tercatat.', 'bg-red-100 text-red-800');
                $this->reset();
            }
        }
    }
    public function edit($id)
    {
        $data = users_kemahasiswaan::findOrFail($id);
        $this->id = $data->id;
        $this->user_id = $data->user_id;
        $this->fakultas_id = $data->fakultas_id;
    }

    public function update()
    {
        if ($this->validate()) {
            $data = users_kemahasiswaan::find($this->id);
            $isDone = users_kemahasiswaan::where('user_id', $this->user_id)->first();
            if ($isDone == null) {
                $data->update([
                    'user_id' => $this->user_id,
                    'fakultas_id' => $this->fakultas_id,
                ]);
                flash('User kemahasiswaan berhasil diupdate.', 'bg-green-100 text-green-800');
            } elseif ($data->user_id == $isDone->user_id) {
                $data->update([
                    'user_id' => $this->user_id,
                    'fakultas_id' => $this->fakultas_id,
                ]);
                flash('User kemahasiswaan berhasil diupdate.', 'bg-green-100 text-green-800');
            } else {
                flash('User ini sudah tercatat.', 'bg-red-100 text-red-800');
            }
        }
        $this->reset();
    }
    public function delete($id)
    {
        $data = users_kemahasiswaan::findOrFail($id);
        $this->id = $data->id;
    }
    public function deleteConfirm()
    {
        users_kemahasiswaan::find($this->id)->delete();
        flash('User kemahasiswaan berhasil dihapus.',  'bg-green-100 text-green-800');
        $this->reset();
    }

    public function clear()
    {
        $this->user_id = '';
        $this->fakultas_id = '';
    }
}
