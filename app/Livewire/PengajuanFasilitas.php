<?php

namespace App\Livewire;

use App\Models\peminjaman_fasilitas as ModelsPeminjaman;
use App\Models\users_kemahasiswaan as ModelsKemahasiswaan;
use Livewire\Attributes\On;
use Livewire\Attributes\Rule;
use Livewire\Component;

class PengajuanFasilitas extends Component
{
    #[Rule(['required', 'string', 'min:2'])]
    public $status = '';
    public $id = '';
    
    public $embed_file_surat;
    #[On('edit-task')]
    public function ganti($id)
    {
        $data = ModelsPeminjaman::findOrFail($id);
        $this->id = $data->id;
        $this->status = $data->status;
    }
    
    public function lihat($file_surat)
    {
        $this->embed_file_surat = $file_surat;
    }

    public function update()
    {
        if ($this->validate()) {
            $data = ModelsPeminjaman::find($this->id);
            $data->update([
                'status' => $this->status,
            ]);
        }
        flash('Status berhasil diupdate.', 'bg-green-100 text-green-800');
        $this->reset();
    }
    public function render()
    {
        if (session('user_role') == 'kemahasiswaan') {
            $fakultas = ModelsKemahasiswaan::where('user_id', session('user_id'))->get('fakultas_id');
            $fakultas_id = $fakultas[0]->fakultas_id;
            $data_peminjaman = ModelsPeminjaman::whereHas('fasilitas', function ($query) use ($fakultas_id) {
                $query->where('fakultas_id', $fakultas_id);
            })
                ->orderBy('waktu_mulai', 'desc')
                ->paginate(10);
        } else {
            $data_peminjaman = ModelsPeminjaman::orderBy('waktu_mulai', 'desc')
                ->where('status', 'setujui')
                ->paginate(10);
        }
        return view('livewire.pengajuan-fasilitas', [
            'dataPeminjaman' => $data_peminjaman,
        ]);
    }
}
