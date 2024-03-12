<?php

namespace App\Livewire\Forms;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Validate;
use Livewire\Form;

class loginForm extends Form
{
    #[\Livewire\Attributes\Rule(['required', 'string', 'min:3'])]
    public string $username = '';
    #[\Livewire\Attributes\Rule(['required', 'string', 'min:6'])]
    public string $password = '';
    public function login()
    {
        $this->validate();
        $user = User::where('username', $this->username)->first();
        if (Auth::attempt(['username' => $this->username, 'password' => $this->password])) {
            session(['user_id' => $user->id]);
            session(['name' => $user->name]);
            session(['username' => $user->username]);
            session(['user_role' => $user->role]);
            if ($user->role == 'admin') {
                return redirect()->route('admin.index')->with('role', $user->role);
            } elseif (($user->role == 'kemahasiswaan')) {
                return redirect()->route('kemahasiswaan.index')->with('role', $user->role);
            } elseif (($user->role == 'mahasiswa')) {
                return redirect()->route('mahasiswa.index')->with('role', $user->role);
            }
        } else {
            flash('Email/password yang anda masukkan salah.', 'bg-red-100 text-red-800');
            return redirect()->route('login');
        }
    }
}
