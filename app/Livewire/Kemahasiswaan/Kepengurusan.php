<?php

namespace App\Livewire\Kemahasiswaan;

use Livewire\Attributes\Title;
use Livewire\Component;

class Kepengurusan extends Component
{
    #[Title('Manajemen Kepengurusan Ormawa')]
    public function render()
    {
        return view('livewire.kemahasiswaan.kepengurusan');
    }
}
