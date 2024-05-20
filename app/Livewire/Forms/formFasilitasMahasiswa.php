<?php

namespace App\Livewire\Forms;

use App\Models\peminjaman_fasilitas as ModelsPeminjaman;
use App\Models\users_ormawa as ModelsUsersOrmawa;
use App\Models\User;
use Livewire\Attributes\Rule;
use Livewire\Attributes\Validate;
use Livewire\Form;
use Livewire\WithFileUploads;

class formFasilitasMahasiswa extends Form
{
    public $fasilitas_id, $waktu_mulai, $waktu_selesai, $status, $id;
    public $file_surat, $temp_file_surat, $embed_file_surat;
    use WithFileUploads;
    public function validateData()
    {
        $this->validate([
            'fasilitas_id' => ['required',],
            'waktu_mulai' => ['required',],
            'waktu_selesai' => ['required',],
        ]);
    }
    public function store(): void
    {
        $this->validateData();
        $this->validate([
            'file_surat' => ['required', 'file', 'mimetypes:application/pdf', 'min:3', 'max:2048'],
        ]);
        $ormawa_id = (ModelsUsersOrmawa::where('user_id', session('user_id'))->get('ormawa_id'))[0]->ormawa_id;
        $cek_peminjaman = ModelsPeminjaman::where('fasilitas_id', $this->fasilitas_id)
            ->where('status', 'setujui')
            ->where(function ($query) {
                $query->where(function ($query) {
                    $query->where('waktu_mulai', '>=', $this->waktu_mulai)
                        ->where('waktu_mulai', '<', $this->waktu_selesai);
                })
                    ->orWhere(function ($query) {
                        $query->where('waktu_selesai', '>', $this->waktu_mulai)
                            ->where('waktu_selesai', '<=', $this->waktu_selesai);
                    });
            })
            ->first();
        if ($cek_peminjaman !== null) {
            flash('Peminjaman fasilitas gagal diajukan.', 'bg-red-100 text-red-800');
            $this->reset();
        } else {
            $path = $this->file_surat->store('file-surat', 'public');
            ModelsPeminjaman::create([
                'fasilitas_id' => $this->fasilitas_id,
                'ormawa_id' => $ormawa_id,
                'file_surat' => $path,
                'waktu_mulai' => $this->waktu_mulai,
                'waktu_selesai' => $this->waktu_selesai,
                'status' => 'belum',
            ]);
            flash('Peminjaman fasilitas berhasil diajukan.', 'bg-green-100 text-green-800');
            $this->reset();
        }
    }
    public function edit($id)
    {
        $data = ModelsPeminjaman::findOrFail($id);
        $this->fasilitas_id = $data->fasilitas_id;
        $this->waktu_mulai = $data->waktu_mulai;
        $this->waktu_selesai = $data->waktu_selesai;
        $this->file_surat = $data->file_surat;
        $this->id = $data->id;
    }

    public function update()
    {
        $datapeminjaman = ModelsPeminjaman::find($this->id);
        if (empty($this->temp_file_surat)) {
            $this->validateData();
            $datapeminjaman->update(
                [
                    'fasilitas_id' => $this->fasilitas_id,
                    'waktu_mulai' => $this->waktu_mulai,
                    'waktu_selesai' => $this->waktu_selesai,
                ]
            );
        } else {
            $this->validateData();
            $this->validate([
                'temp_file_surat' => ['required', 'file', 'mimetypes:application/pdf', 'min:3', 'max:2048'],
            ]);
            unlink('storage/' . $datapeminjaman->file_surat);
            $path = $this->temp_file_surat->store('file-surat', 'public');
            $datapeminjaman->update(
                [
                    'fasilitas_id' => $this->fasilitas_id,
                    'waktu_mulai' => $this->waktu_mulai,
                    'waktu_selesai' => $this->waktu_selesai,
                    'file_surat' => $path,
                ]
            );
        }
        flash('Pengajuan peminjaman berhasil diupdate.', 'bg-green-100 text-green-800');
        $this->reset();
    }
    public function delete($id)
    {
        $data = ModelsPeminjaman::findOrFail($id);
        $this->id = $data->id;
    }
    public function deleteConfirm()
    {
        $data = ModelsPeminjaman::find($this->id);
        unlink('storage/' . $data->file_surat);
        $data->delete();
        flash('Pengajuan peminjaman berhasil dihapus.',  'bg-green-100 text-green-800');
        $this->reset();
    }

    public function clear()
    {
        $this->fasilitas_id = '';
        $this->waktu_mulai = '';
        $this->waktu_selesai = '';
        $this->file_surat = '';
        $this->temp_file_surat = '';
        $this->id = '';
    }
}
