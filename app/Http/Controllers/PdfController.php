<?php

namespace App\Http\Controllers;

use App\Models\kegiatan as ModelsKegiatan;
use App\Models\peminjaman_fasilitas;
use App\Models\periode_kepengurusan;
use App\Models\users_kemahasiswaan as ModelsKemahasiswaan;

use Illuminate\Http\Request;

class PdfController extends Controller
{
    public function index()
    {

    }
    public function laporanPeminjaman()
    {
        $mpdf = new \Mpdf\Mpdf([
            'mode' => 'utf-8',
            'orientation' => 'L', // L untuk landscape, P untuk portrait (default)
        ]);
        if (session('user_role') !== 'kemahasiswaan') {
            $data_peminjaman = peminjaman_fasilitas::orderBy('waktu_mulai', 'desc')->get();
        } else {
            $fakultas = ModelsKemahasiswaan::where('user_id', session('user_id'))->get('fakultas_id');
            $fakultas_id = $fakultas[0]->fakultas_id;
            $data_peminjaman = peminjaman_fasilitas::whereHas('fasilitas', function ($query) use ($fakultas_id) {
                $query->where('fakultas_id', $fakultas_id);
            })
                ->orderBy('waktu_mulai', 'desc')->get();
        }
        $data = [
            'dataPeminjaman' => $data_peminjaman,
        ];
        
        $mpdf->WriteHTML(view('pdfs.peminjaman', $data));
        $pdf_content = $mpdf->Output(); // Simpan output PDF ke dalam variabel
        return $pdf_content;
    }
    public function laporanKepengurusan()
    {
        $mpdf = new \Mpdf\Mpdf([
            'mode' => 'utf-8',
            'orientation' => 'L', // L untuk landscape, P untuk portrait (default)
        ]);
        if (session('user_role') !== 'kemahasiswaan') {
            $data_kepengurusan = periode_kepengurusan::orderBy('updated_at', 'desc')->get();
        } else {
            $fakultas = ModelsKemahasiswaan::where('user_id', session('user_id'))->get('fakultas_id');
            $fakultas_id = $fakultas[0]->fakultas_id;
            $data_kepengurusan = periode_kepengurusan::whereHas('ormawa', function ($query) use ($fakultas_id) {
                $query->where('fakultas_id', $fakultas_id);
            })
                ->orderBy('updated_at', 'desc')
                ->get();
        }
        $data = [
            'dataKepengurusan' => $data_kepengurusan,
        ];
        
        $mpdf->WriteHTML(view('pdfs.kepengurusan', $data));
        $pdf_content = $mpdf->Output(); // Simpan output PDF ke dalam variabel
        return $pdf_content;
    }
    public function laporanKegiatan()
    {
        $mpdf = new \Mpdf\Mpdf([
            'mode' => 'utf-8',
            'orientation' => 'L', // L untuk landscape, P untuk portrait (default)
        ]);
        if (session('user_role') == 'kemahasiswaan') {
            $fakultas = ModelsKemahasiswaan::where('user_id', session('user_id'))->get('fakultas_id');
            $fakultas_id = $fakultas[0]->fakultas_id;
            $data_kegiatan = ModelsKegiatan::whereHas('ormawa', function ($query) use ($fakultas_id) {
                $query->where('fakultas_id', $fakultas_id);
            })
                ->orderBy('updated_at', 'desc')
                ->paginate(10);
            $data_kepengurusan = '';
        } else {
            $data_kegiatan = ModelsKegiatan::orderBy('updated_at', 'desc')->paginate(10);
            $data_kepengurusan = '';
        }
        $data = [
            'dataKepengurusan' => $data_kepengurusan,
            'dataKegiatan' => $data_kegiatan,
        ];

        $mpdf->WriteHTML(view('pdfs.kegiatan', $data));
        $pdf_content = $mpdf->Output(); // Simpan output PDF ke dalam variabel
        return $pdf_content;
    }
}
