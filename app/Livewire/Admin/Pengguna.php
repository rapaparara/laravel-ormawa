<?php

namespace App\Livewire\Admin;

use App\Livewire\Forms\formPengguna;
use App\Models\User;
use Livewire\Component;

class Pengguna extends Component
{

    public formPengguna $form;
    public function save()
    {
        $this->form->store();
    }

    public function render()
    {
        $data = User::orderBy('id')->where('role', 'admin')->orWhere('role', 'kemahasiswaan')->paginate(5);
        return view('livewire.admin.pengguna', ['dataPengguna' => $data]);
    }
}
