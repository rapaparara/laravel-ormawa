<?php

namespace App\Livewire\Home;

use Livewire\Attributes\Title;
use Livewire\Component;

class Kegiatan extends Component
{
    #[Title('Kegiatan Ormawa')]
    public function render()
    {
        return view('livewire.home.kegiatan');
    }
}
