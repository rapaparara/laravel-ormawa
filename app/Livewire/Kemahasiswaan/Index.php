<?php

namespace App\Livewire\Kemahasiswaan;

use Livewire\Attributes\Title;
use Livewire\Component;

class Index extends Component
{
    #[Title('Halaman Utama Kemahasiswaan')]
    public function render()
    {
        return view('livewire.kemahasiswaan.index');
    }
}
