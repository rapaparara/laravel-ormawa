<?php

namespace App\Livewire;

use App\Livewire\Forms\loginForm;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Title;

class Login extends Component
{
    #[Title('Halaman Login')]
    public loginForm $form;
    public function login()
    {
        $this->form->login();
    }
    public function logout()
    {
        Auth::logout();
        Session::flush();
        return redirect()->route('login');
    }
    public function render()
    {
        return view('livewire.login');
    }
}
