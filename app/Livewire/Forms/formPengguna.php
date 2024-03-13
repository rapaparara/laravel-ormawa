<?php

namespace App\Livewire\Forms;

use App\Livewire\Admin\Pengguna;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Livewire\Attributes\Rule;
use Livewire\Attributes\Validate;
use Livewire\Form;

class formPengguna extends Form
{
    #[Rule(['required', 'string', 'min:5', 'max:255'])]
    public string $name = '';
    #[Rule(['required', 'string', 'min:5', 'max:255'])]
    public string $username = '';
    #[Rule(['required', 'string', 'min:6', 'max:255'])]
    public string $password = '';
    #[Rule(['required', 'string', 'min:3'])]
    public string $role = '';

    public string $id = '';
    public string $password_temp = '';
    public function store(): void
    {
        if ($this->validate()) {
            $pengguna = User::create([
                'name' => $this->name,
                'username' => $this->username,
                'password' => Hash::make($this->password),
                'role' => $this->role,
            ]);
            flash('Pengguna berhasil dibuat.', 'bg-green-100 text-green-800');
            $this->reset();
        }
    }
    public function update()
    {
        if ($this->validate()) {
            $data = User::find($this->id);
            if ($this->password_temp == '') {
                $data->update([
                    'name' => $this->name,
                    'username' => $this->username,
                    'role' => $this->role,
                    'password' => $this->password,
                ]);
            } else {
                $data->update([
                    'name' => $this->name,
                    'username' => $this->username,
                    'role' => $this->role,
                    'password' => Hash::make($this->password_temp),
                ]);
            }
            flash('Pengguna berhasil diupdate.', 'bg-green-100 text-green-800');
            $this->reset();
        }
    }
    public function edit($id)
    {
        $data = User::findOrFail($id);
        $this->id = $data->id;
        $this->name = $data->name;
        $this->username = $data->username;
        $this->role = $data->role;
        $this->password = $data->password;
    }

    public function delete($id)
    {
        $data = User::findOrFail($id);
        $this->id = $data->id;
    }
    public function deleteConfirm()
    {
        User::find($this->id)->delete();
        flash('Pengguna berhasil dihapus.',  'bg-green-100 text-green-800');
        $this->reset();
    }
    public function clear()
    {
        $this->name = '';
        $this->username = '';
        $this->role = '';
        $this->password = '';
        $this->password_temp = '';
    }
}
