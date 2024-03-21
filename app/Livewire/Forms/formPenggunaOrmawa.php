<?php

namespace App\Livewire\Forms;

use App\Models\User;
use App\Models\users_ormawa as ModelsPengguna;
use Illuminate\Support\Facades\Hash;
use Livewire\Attributes\Rule;
use Livewire\Attributes\Validate;
use Livewire\Form;

class formPenggunaOrmawa extends Form
{
    // Data Users
    #[Rule(['required', 'string', 'min:5', 'max:255'])]
    public string $name = '';
    #[Rule(['required', 'string', 'min:5', 'max:255', 'unique:users'])]
    public string $username = '';
    #[Rule(['required', 'string', 'min:6', 'max:255'])]
    public string $password = '';
    public string $role = '';

    // Data Pengguna Ormawa
    #[Rule(['required'])]
    public $ormawa_id = '';
    public $user_id = '';

    public $password_temp = '';
    public $id = '';
    public function store(): void
    {
        if ($this->validate()) {
            $pengguna = User::create([
                'name' => $this->name,
                'username' => $this->username,
                'password' => Hash::make($this->password),
                'role' => 'mahasiswa',
            ]);
            $this->user_id = $pengguna->id;
            $penggunaOrmawa = ModelsPengguna::create([
                'user_id' => $this->user_id,
                'ormawa_id' => $this->ormawa_id,
            ]);
            flash('Pengguna ormawa berhasil ditambahkan.', 'bg-green-100 text-green-800');
            $this->reset();
        }
    }
    public function edit($id)
    {
        $data = ModelsPengguna::findOrFail($id);
        $this->name = $data->user->name;
        $this->username = $data->user->username;
        $this->password = $data->user->password;
        $this->ormawa_id = $data->ormawa_id;
        $this->user_id = $data->user->id;
    }

    public function update()
    {
        if ($this->validate()) {
            $data_user = User::find($this->user_id);
            $data_user_ormawa = ModelsPengguna::where('user_id', $this->user_id)->first();
            if ($this->password_temp == '') {
                $data_user->update([
                    'name' => $this->name,
                    'username' => $this->username,
                    'password' => $this->password,
                ]);
                $data_user_ormawa->update(['ormawa_id' => $this->ormawa_id]);
            } else {
                $data_user->update([
                    'name' => $this->name,
                    'username' => $this->username,
                    'password' => Hash::make($this->password_temp),
                ]);
                $data_user_ormawa->update(['ormawa_id' => $this->ormawa_id]);
            }
            flash('Pengguna ormawa berhasil diupdate.', 'bg-green-100 text-green-800');
            $this->reset();
        }
    }
    public function delete($id)
    {
        $data = ModelsPengguna::findOrFail($id);
        $this->user_id = $data->user_id;
        $this->id = $data->id;
    }
    public function deleteConfirm()
    {
        ModelsPengguna::find($this->id)->delete();
        User::find($this->user_id)->delete();
        flash('Pengguna ormawa berhasil dihapus.',  'bg-green-100 text-green-800');
        $this->reset();
    }

    public function clear()
    {
        $this->user_id = '';
        $this->ormawa_id = '';
        $this->id = '';
        $this->name = '';
        $this->username = '';
        $this->password = '';
    }
}
