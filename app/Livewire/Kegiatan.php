<?php

namespace App\Livewire;

use App\Models\kegiatan as ModelsKegiatan;
use App\Models\periode_kepengurusan as ModelsKepengurusan;
use App\Models\users_kemahasiswaan as ModelsKemahasiswaan;
use App\Models\users_ormawa as ModelsUsersOrmawa;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\WithFileUploads;
use Livewire\WithPagination;

class Kegiatan extends Component
{
    public $kepengurusan_id, $ormawa_id, $name, $deskripsi, $waktu_mulai, $waktu_selesai, $image, $temp_image, $id;

    public $showModal = false;
    public $editModal = false;
    use WithPagination;
    use WithFileUploads;
    protected $paginationTheme = 'simple-tailwind';

    public function validateData()
    {
        $this->validate([
            'kepengurusan_id' => ['required'],
            'name' => ['required', 'string', 'min:5', 'max:255'],
            'deskripsi' => [
                'required', 'string', 'min:20',
                function ($attribute, $value, $fail) {
                    if (preg_match('/^([\p{Z}\s])*$/', $value)) {
                        $fail('Deskripsi hanya berisi spasi atau karakter yang sama.');
                    }
                    $words = str_word_count($value, 1);
                    $meaningfulWords = array_filter($words, function ($word) {
                        $allowedWords = [
                            'mahasiswa', 'organisasi', 'universitas', 'gorontalo', 'ung', 'kampus', 'kegiatan', 'prestasi', 'pengurus', 'rektor',
                            'dekade', 'eksklusif', 'magang', 'internasional', 'sertifikat', 'program', 'partisipasi', 'pelatih', 'olahraga', 'badminton',
                            'akademi', 'seleksi', 'motivasi', 'adaptasi', 'bahasa', 'asing', 'penilaian', 'wawasan', 'pengalaman', 'kesejahteraan',
                            'pembangunan', 'sosialisasi', 'pembinaan', 'kreatifitas', 'pengembangan', 'keterampilan', 'kemitraan', 'hubungan',
                            'strategis', 'kolaborasi', 'kemajuan', 'perkuliahan', 'kebudayaan', 'pendidikan', 'budaya', 'sosial', 'event', 'pencapaian',
                            'kompetisi', 'bimbingan', 'orientasi', 'rekognisi', 'pelatihan', 'workshop', 'seminar', 'saringan', 'aspirasi', 'kepedulian',
                            'pemberdayaan', 'kebersamaan', 'solidaritas', 'partisipatif', 'komunitas', 'lembaga', 'pimpinan', 'kebijakan', 'penelitian',
                            'struktur', 'komunikasi', 'dokumentasi', 'pelaporan', 'koordinasi', 'evaluasi', 'pemetaan', 'strategi', 'pengaruh', 'pemimpin',
                            'kualitas', 'kinerja', 'pengelolaan', 'pelayanan', 'efisiensi', 'pendampingan', 'perencanaan', 'monitoring', 'implementasi',
                            'manajemen', 'perubahan', 'perkembangan', 'peningkatan', 'kemampuan', 'wirausaha', 'inovasi', 'keberhasilan', 'kepuasan',
                            'penerimaan', 'penghargaan', 'kesempatan', 'prestisius', 'internasionalisasi', 'kompetitif', 'berkualitas', 'teknologi',
                            'informasi', 'seminar', 'pameran', 'pemrograman', 'pengembang', 'pengguna', 'perangkat', 'lunak', 'website', 'aplikasi',
                            'belajar', 'berkarya', 'membaca', 'menulis', 'berhitung', 'berbicara', 'mendengarkan', 'kritis', 'analitis', 'inovatif',
                            'komunikatif', 'adaptif', 'fleksibel', 'pemecahan', 'masalah', 'pengambilan', 'keputusan', 'pengaturan', 'koordinasi',
                            'penyusunan', 'laporan', 'pemahaman', 'konsep', 'prinsip', 'teori', 'model', 'teknik', 'metode', 'standar', 'prosedur'
                        ];

                        return in_array($word, $allowedWords);
                    });
                    if (count($meaningfulWords) < 3) {
                        $fail('Deskripsi terlalu pendek atau hanya berisi kata-kata yang tidak bermakna.');
                    }
                    if (mb_strlen($value) > 10000) {
                        $fail('Deskripsi terlalu panjang.');
                    }
                },
            ],
            'waktu_mulai' => ['required'],
            'waktu_selesai' => ['required'],
        ]);
    }
    public function validateSave()
    {
        $this->validate([
            'image' => ['required', 'file', 'image', 'max:5120'],
        ]);
    }
    public function validateUpdate()
    {
        $this->validate([
            'temp_image' => ['required', 'file', 'image', 'max:5120'],
        ]);
    }
    public function save(): void
    {
        $this->validateData();
        $this->validateSave();
        $path = $this->image->store('gambar-kegiatan', 'public');
        $kegiatan = ModelsKegiatan::create([
            'kepengurusan_id' => $this->kepengurusan_id,
            'ormawa_id' => $this->ormawa_id,
            'name' => $this->name,
            'deskripsi' => $this->deskripsi,
            'waktu_mulai' => $this->waktu_mulai,
            'waktu_selesai' => $this->waktu_selesai,
            'image' => $path,
        ]);
        flash('Kegiatan berhasil dibuat.', 'bg-green-100 text-green-800');
        $this->reset();
    }
    #[On('edit-task')]
    public function edit($id)
    {
        $this->editModal = true;
        $data = ModelsKegiatan::findOrFail($id);
        $this->id = $id;
        $this->kepengurusan_id = $data->kepengurusan_id;
        $this->ormawa_id = $data->ormawa_id;
        $this->name = $data->name;
        $this->deskripsi = $data->deskripsi;
        $this->waktu_mulai = $data->waktu_mulai;
        $this->waktu_selesai = $data->waktu_selesai;
    }
    public function update()
    {
        $data_kegiatan = ModelsKegiatan::find($this->id);
        if (empty($this->temp_image)) {
            $this->validateData();
            $data_kegiatan->update([
                'kepengurusan_id' => $this->kepengurusan_id,
                'name' => $this->name,
                'deskripsi' => $this->deskripsi,
                'waktu_mulai' => $this->waktu_mulai,
                'waktu_selesai' => $this->waktu_selesai,
            ]);
        } else {
            $this->validateData();
            $this->validateUpdate();
            unlink('storage/' . $data_kegiatan->image);
            $path = $this->temp_image->store('gambar-kegiatan', 'public');
            $data_kegiatan->update([
                'kepengurusan_id' => $this->kepengurusan_id,
                'name' => $this->name,
                'deskripsi' => $this->deskripsi,
                'waktu_mulai' => $this->waktu_mulai,
                'waktu_selesai' => $this->waktu_selesai,
                'image' => $path,
            ]);
        }
        flash('Kegiatan berhasil diupdate.', 'bg-green-100 text-green-800');
        $this->reset();
    }
    public function closeModal()
    {
        $this->showModal = false;
        $this->clear();
    }
    public function editStateModal()
    {
        $this->editModal = false;
        $this->clear();
    }
    public function delete($id)
    {
        $data = ModelsKegiatan::findOrFail($id);
        $this->id = $data->id;
    }
    public function deleteConfirm()
    {
        try {
            $kegiatan = ModelsKegiatan::find($this->id);
            $path = $kegiatan->image;
            $kegiatan->delete();
            unlink('storage/' . $path);
            flash('Kegiatan berhasil dihapus.',  'bg-green-100 text-green-800');
        } catch (\Throwable $th) {
            flash('Gagal menghapus kegiatan.',  'bg-red-100 text-red-800');
        }
        $this->reset();
    }
    public function clear()
    {
        $this->kepengurusan_id = '';
        $this->ormawa_id = '';
        $this->name = '';
        $this->deskripsi = '';
        $this->waktu_mulai = '';
        $this->waktu_selesai = '';
        $this->image = '';
        $this->temp_image = '';
        $this->id = '';
    }
    public function render()
    {
        if (session('user_role') == 'mahasiswa') {
            $this->ormawa_id = (ModelsUsersOrmawa::where('user_id', session('user_id'))->get('ormawa_id'))[0]->ormawa_id;
            $data_kepengurusan = ModelsKepengurusan::orderBy('id')->where('status', 'setujui')->where('ormawa_id', $this->ormawa_id)->paginate(10);
            $data_kegiatan = ModelsKegiatan::orderBy('updated_at', 'desc')->where('ormawa_id', $this->ormawa_id)->paginate(10);
        } elseif(session('user_role') == 'kemahasiswaan') {
            $fakultas = ModelsKemahasiswaan::where('user_id', session('user_id'))->get('fakultas_id');
            $fakultas_id = $fakultas[0]->fakultas_id;
            $data_kegiatan = ModelsKegiatan::whereHas('ormawa', function ($query) use ($fakultas_id) {
                $query->where('fakultas_id', $fakultas_id);
            })
                ->orderBy('updated_at', 'desc')
                ->paginate(10);
            $data_kepengurusan = '';
        } else {
            $data_kegiatan = ModelsKegiatan::orderBy('updated_at', 'desc')
                ->paginate(10);
            $data_kepengurusan = '';
        }
        return view('livewire.kegiatan', [
            'dataKepengurusan' => $data_kepengurusan,
            'dataKegiatan' => $data_kegiatan,
        ]);
    }
}
