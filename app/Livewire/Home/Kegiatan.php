<?php

namespace App\Livewire\Home;

use App\Models\kegiatan as ModelsKegiatan;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

class Kegiatan extends Component
{
    use WithPagination;
    #[Title('Kegiatan Ormawa')]
    public $katakunci = '';
    public function render()
    {
        if ($this->katakunci != null) {
            $data_kegiatan = ModelsKegiatan::orderBy('created_at', 'desc')
                ->where('name', 'like', '%' . $this->katakunci . '%')
                ->orWhere('deskripsi', 'like', '%' . $this->katakunci . '%')
                ->paginate(6);
        } else $data_kegiatan = ModelsKegiatan::orderBy('created_at', 'desc')->paginate(6);
        return view('livewire.home.kegiatan', [
            'dataKegiatan' => $data_kegiatan,
        ]);
    }
}
