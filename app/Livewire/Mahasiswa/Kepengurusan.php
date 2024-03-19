<?php

namespace App\Livewire\Mahasiswa;

use App\Models\periode as ModelsPeriode;
use App\Models\periode_kepengurusan as ModelsKepengurusan;
use App\Models\users_ormawa as ModelsUsersOrmawa;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\On;
use Livewire\Attributes\Rule;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class Kepengurusan extends Component
{
    #[Title('Manajemen Kepengurusan Ormawa')]

    public function render()
    {
        return view('livewire.mahasiswa.kepengurusan');
    }
}
