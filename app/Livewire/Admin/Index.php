<?php

namespace App\Livewire\Admin;

use Livewire\Attributes\Title;
use Livewire\Component;

class Index extends Component
{
    #[Title('Halaman Utama Admin')]
    public function render()
    {
        return view('livewire.admin.index');
    }
}
