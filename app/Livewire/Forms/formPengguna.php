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
}
