<?php

namespace App\Http\Controllers;

use App\Models\Asdos;
use App\Models\InputNilai;
use App\Models\Jadwal;
use App\Models\Kriteria;
use App\Models\Matkul;
use App\Models\Pendaftar;
use App\Models\Periode;
use App\Models\PilihMatkul;
use App\Models\Setting;
use Illuminate\Http\Request;

class VerifikasiController extends Controller
{
    //
    public function verifikasi()
    {
        return view('admin.verifikasi.index');
    }
    
    public function postverifikasi()
    {
        $kriteria = Kriteria::all();

        $periode = Periode::where('status', 'aktif')->first();
        if (!$periode) {
            return redirect()->back()->with('error', 'Periode aktif tidak ditemukan.');
        }

        $pendaftar = Pendaftar::where('periode', $periode->id)->get();
        if ($pendaftar->isEmpty()) {
            return redirect()->back()->with('error', 'Tidak ada pendaftar untuk periode ini.');
        }

        $dataasdos = Asdos::where('periode', $periode->id)->get();
        
        if ($dataasdos->isNotEmpty()) {
            return redirect()->back()->with('error', 'Anda Sudah Mengverifikasi Pendaftar Di periode ini');
        }
        // dd($dataasdos);

        $ranking = [];

        foreach ($pendaftar as $p) {
            $n = [];
            $pilmatkul = InputNilai::where('id_pendaftar', $p->id)->get();
            $nilai = PilihMatkul::where('id_pendaftar', $p->id)->get();

            foreach ($pilmatkul as $m) {
                foreach ($nilai as $ni) {
                    $relasi = Matkul::where('nama', $ni->matkul)->first();
                    if ($relasi && $relasi->kode == $m->kode) {
                        switch ($m->nilai) {
                            case 'A':
                                $n[] = 4.0;
                                break;
                            case 'A-':
                                $n[] = 3.75;
                                break;
                            case 'B+':
                                $n[] = 3.50;
                                break;
                            case 'B':
                                $n[] = 3.00;
                                break;
                            case 'B-':
                                $n[] = 2.75;
                                break;
                            case 'C+':
                                $n[] = 2.50;
                                break;
                            case 'C':
                                $n[] = 2.00;
                                break;
                            case 'D':
                                $n[] = 1.00;
                                break;
                            case 'E':
                                $n[] = 0;
                                break;
                        }
                    }
                }
            }

            $surat_pernyataan = $p->surat_pernyataan ? 1 : 0;
            $surat_rekomendasi = $p->surat_rekomendasi ? 1 : 0;
            // menghitung nilai bobot ipk pendaftar
            $ipk = ($p->ipk / 4.0) * $kriteria->where('nama_kriteria', 'ipk')->first()->bobot;
            // menghitung nilai bobot mata kuliah pendaftar (4 nilai maksimal ipk)
            $nilai_matkul = count($n) > 0 ? (array_sum($n) / (count($n) * 4)) * $kriteria->where('nama_kriteria', 'nilai_matkul')->first()->bobot : 0;
            // menghitung nilai bobot surat rekomendasi dan pernyataan
            $rekomendasi = $surat_rekomendasi * $kriteria->where('nama_kriteria', 'rekomendasi')->first()->bobot;
            // menghitung nilai bobot surat pernyataan
            $pernyataan = $surat_pernyataan * $kriteria->where('nama_kriteria', 'pernyataan')->first()->bobot;
            // menghitung total skor
            $skor = $ipk + $nilai_matkul + $rekomendasi + $pernyataan;

            // Menambahkan data ke ranking
            $ranking[] = [
                'id_user' => $p->id_user,
                'id_pendaftar' => $p->id,
                'nama' => $p->nama,
                'stb' => $p->stb,
                'jurusan' => $p->jurusan,
                'no_wa' => $p->no_wa,
                'foto' => $p->foto,
                'ipk' => $ipk,
                'nilai_matkul' => $nilai_matkul,
                'rekomendasi' => $rekomendasi,
                'pernyataan' => $pernyataan,
                'skor' => $skor,
            ];
        }

        if (empty($ranking)) {
            return redirect()->back()->with('error', 'Data tidak cukup untuk melakukan verifikasi.');
        }

        // Mengurutkan ranking berdasarkan skor tertinggi
        usort($ranking, function ($a, $b) {
            return $b['skor'] <=> $a['skor'];
        });

        // dd($ranking);
        // Mengambil jumlah pendaftar yang lulus berdasarkan batasan asdos
        $jumlah_lulus = ceil(Jadwal::count() / Setting::first()->batasan_asdos);

        // Memastikan jumlah lulus tidak melebihi jumlah pendaftar
        foreach ($ranking as $index => $asdos) {
            $status = $index < $jumlah_lulus ? 'lulus' : 'tidak lulus';

            $pen = Pendaftar::find($asdos['id_pendaftar']);
            if (!$pen) continue;

            if ($status === 'lulus') {
                Asdos::create([
                    'rank' => $index + 1,
                    'id_user' => $asdos['id_user'],
                    'id_pendaftar' => $asdos['id_pendaftar'],
                    'nama' => $asdos['nama'],
                    'stb' => $asdos['stb'],
                    'jurusan' => $asdos['jurusan'],
                    'no_wa' => $asdos['no_wa'],
                    'foto' => $asdos['foto'],
                    'skor' => $asdos['skor'],
                    'periode' => $periode->id
                ]);
            }

            $pen->status = $status;
            $pen->save();
        }

        $asdoslolos = Asdos::where('periode', $periode->id)->count();
        if ($asdoslolos == 0) {
            return redirect()->back()->with('error', 'Tidak ada pendaftar yang lulus verifikasi.');
        }


        return redirect()->route('asdos')->with([
            'success' => 'Verifikasi berhasil dilakukan.',
            'jumlah_lulus' => $asdoslolos,
        ]);
    }

}
