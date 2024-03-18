<?php

namespace App\Livewire\Mahasiswa;

use Livewire\Attributes\Title;
use Livewire\Component;

class Index extends Component
{
    #[Title('Halaman Utama Mahasiswa')]
    public function render()
    {
        return view('livewire.mahasiswa.index');
    }
}
