<?php

namespace App\Livewire\Kemahasiswaan;

use Livewire\Attributes\Title;
use Livewire\Component;

class Kegiatan extends Component
{
    #[Title('Kegiatan Ormawa')]
    public function render()
    {
        return view('livewire.kemahasiswaan.kegiatan');
    }
}
