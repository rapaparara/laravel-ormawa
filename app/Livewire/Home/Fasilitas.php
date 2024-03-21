<?php

namespace App\Livewire\Home;

use Livewire\Attributes\Title;
use Livewire\Component;

class Fasilitas extends Component
{
    #[Title('Jadwal Peminjaman Fasilitas')]
    public function render()
    {
        return view('livewire.home.fasilitas');
    }
}
