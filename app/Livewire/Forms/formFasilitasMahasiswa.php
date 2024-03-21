<?php

namespace App\Livewire\Forms;

use App\Models\peminjaman_fasilitas as ModelsPeminjaman;
use App\Models\users_ormawa as ModelsUsersOrmawa;
use App\Models\User;
use Livewire\Attributes\Rule;
use Livewire\Attributes\Validate;
use Livewire\Form;

class formFasilitasMahasiswa extends Form
{
    #[Rule(['required'])]
    public string $fasilitas_id = '';
    #[Rule(['required'])]
    public string $waktu_mulai = '';
    #[Rule(['required'])]
    public string $waktu_selesai = '';
    public string $status = '';

    public $id = '';
    public function store(): void
    {
        if ($this->validate()) {

            $ormawa_id = (ModelsUsersOrmawa::where('user_id', session('user_id'))->get('ormawa_id'))[0]->ormawa_id;
            $ambil_peminjaman = ModelsPeminjaman::where('fasilitas_id', $this->fasilitas_id)
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
            if ($ambil_peminjaman !== null) {
                flash('Peminjaman fasilitas gagal diajukan.', 'bg-red-100 text-red-800');
                $this->reset();
            } else {
                // Menyimpan peminjaman fasilitas baru
                $store_peminjaman = ModelsPeminjaman::create([
                    'fasilitas_id' => $this->fasilitas_id,
                    'ormawa_id' => $ormawa_id,
                    'waktu_mulai' => $this->waktu_mulai,
                    'waktu_selesai' => $this->waktu_selesai,
                    'status' => 'belum',
                ]);
                flash('Peminjaman fasilitas berhasil diajukan.', 'bg-green-100 text-green-800');
                $this->reset();
            }
        }
    }
    public function edit($id)
    {
        $data = ModelsPeminjaman::findOrFail($id);
        $this->fasilitas_id = $data->fasilitas_id;
        $this->waktu_mulai = $data->waktu_mulai;
        $this->waktu_selesai = $data->waktu_selesai;
        $this->id = $data->id;
    }

    public function update()
    {
        if ($this->validate()) {
            $ormawa_id = (ModelsUsersOrmawa::where('user_id', session('user_id'))->get('ormawa_id'))[0]->ormawa_id;
            $datapeminjaman = ModelsPeminjaman::find($this->id);
            $datapeminjaman->update(
                [
                    'fasilitas_id' => $this->fasilitas_id,
                    'waktu_mulai' => $this->waktu_mulai,
                    'waktu_selesai' => $this->waktu_selesai,
                ]
            );
            flash('Pengajuan peminjaman berhasil diupdate.', 'bg-green-100 text-green-800');
            $this->reset();
        }
    }
    public function delete($id)
    {
        $data = ModelsPeminjaman::findOrFail($id);
        $this->id = $data->id;
    }
    public function deleteConfirm()
    {
        ModelsPeminjaman::find($this->id)->delete();
        flash('Pengajuan peminjaman berhasil dihapus.',  'bg-green-100 text-green-800');
        $this->reset();
    }

    public function clear()
    {
        $this->fasilitas_id = '';
        $this->waktu_mulai = '';
        $this->waktu_selesai = '';
        $this->id = '';
    }
}
