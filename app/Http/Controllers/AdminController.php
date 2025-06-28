<?php

namespace App\Http\Controllers;

use App\Models\Asdos;
use App\Models\Setting;
use App\Models\Sertifikat;
use App\Models\Absen;
use App\Models\Dosen;
use App\Models\InputNilai;
use App\Models\Jadwal;
use App\Models\Matkul;
use App\Models\Pendaftar;
use App\Models\Periode;
use App\Models\PilihMatkul;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Smalot\PdfParser\Parser;
use Carbon\Carbon;
use Illuminate\Process\Exceptions\ProcessFailedException;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\Process\Process;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AdminController extends Controller
{
    public function index()
    {
        $periode = Periode::where('status', 'aktif')->first();
        $pendaftar = Pendaftar::where('periode', $periode->id)->count();
        $asdos = Asdos::where('periode', $periode->id)->count();
        $jadwal = Jadwal::where('id_periode', $periode->id)->count();
        $sertifikat = Sertifikat::join('asdos', 'sertifikats.id_asdos', '=', 'asdos.id')
            ->where('asdos.periode', $periode->id)
            ->count();

        // $currentYear = date('Y');
        // $pendaftarPerBulan = Pendaftar::selectRaw('MONTH(created_at) as bulan, COUNT(*) as total')
        //     ->where('periode', $periode->id)
        //     ->whereYear('created_at', $currentYear)
        //     ->groupBy('bulan')
        //     ->orderBy('bulan')
        //     ->get();

        // // Format data untuk chart (isi bulan yang kosong dengan 0)
        // $chartPendaftar = array_fill(1, 12, 0);
        // foreach ($pendaftarPerBulan as $item) {
        //     $chartPendaftar[$item->bulan] = $item->total;
        // }

        // // Data distribusi asdos per jurusan
        // $asdosPerJurusan = Asdos::select('jurusan', \DB::raw('COUNT(*) as total'))
        //     ->where('periode', $periode->id)
        //     ->groupBy('jurusan')
        //     ->orderBy('total', 'desc')
        //     ->get();

        // // dd($asdosPerJurusan);

        return view('admin.dashboard.index', compact(
            'pendaftar',
            'asdos',
            'jadwal',
            'sertifikat',
            // 'chartPendaftar',
            // 'asdosPerJurusan',
            'periode'
        ));
    }

    // master
    // pendaftar
    public function pendaftar()
    {
        $periode = Periode::where('status', 'aktif')->first();
        $pendaftar = Pendaftar::where('periode', $periode->id)->get();
        return view('admin.master.pendaftar.index', compact('pendaftar'));
    }
    public function tambahpendaftar()
    {
        $user = User::where('role', 'mahasiswa')->get();

        return view('admin.master.pendaftar.tambah', compact('user'));
    }
    public function editpendaftar($id)
    {
        $pendaftar = Pendaftar::findOrFail($id);
        $user = User::all();
        return view('admin.master.pendaftar.tambah', compact('user', 'pendaftar'));
    }
    public function detailpendaftar($id)
    {
        $p = Pendaftar::findOrFail($id);
        return view('admin.master.pendaftar.detail', compact('p'));
    }
    public function postpendaftar(Request $request)
    {
        // Validasi input
        $rules = [
            'id_user' => 'required|exists:users,id',
            'stb' => 'required|string|unique:pendaftars,stb,' . ($request->id ?? 'NULL') . ',id',
            'nama' => 'required|string|max:255',
            'alamat' => 'required|string',
            'jurusan' => 'required|string|max:255',
            'ttl' => 'required|date',
            'tempat_lahir' => 'required|string|max:255',
            'no_wa' => 'required|string|max:15',
            'foto' => 'nullable|image|max:10240',
            'transkip' => 'nullable|file|max:10240',
            'surat_pernyataan' => 'nullable|file|max:10240',
            'surat_rekomendasi' => 'nullable|file|max:10240',
        ];

        // Only require files if we are creating a new pendaftar (not updating)
        if (!$request->has('id')) {
            $rules['transkip'] = 'required|file|max:10240';
            $rules['surat_pernyataan'] = 'required|file|max:10240';
            $rules['surat_rekomendasi'] = 'required|file|max:10240';
        }

        // Custom validation messages
        $customMessages = [
            'id_user.required' => 'Akun wajib dipilih.',
            'id_user.exists' => 'Akun yang dipilih tidak valid.',
            'stb.required' => 'Stambuk wajib diisi.',
            'stb.string' => 'Stambuk harus berupa teks.',
            'stb.unique' => 'Stambuk sudah terdaftar.',
            'nama.required' => 'Nama wajib diisi.',
            'nama.string' => 'Nama harus berupa teks.',
            'nama.max' => 'Nama tidak boleh lebih dari 255 karakter.',
            'alamat.required' => 'Alamat wajib diisi.',
            'alamat.string' => 'Alamat harus berupa teks.',
            'jurusan.required' => 'Jurusan wajib diisi.',
            'jurusan.string' => 'Jurusan harus berupa teks.',
            'jurusan.max' => 'Jurusan tidak boleh lebih dari 255 karakter.',
            'ttl.required' => 'Tanggal lahir wajib diisi.',
            'ttl.date' => 'Tanggal lahir harus berupa tanggal yang valid.',
            'tempat_lahir.required' => 'Tempat lahir wajib diisi.',
            'tempat_lahir.string' => 'Tempat lahir harus berupa teks.',
            'tempat_lahir.max' => 'Tempat lahir tidak boleh lebih dari 255 karakter.',
            'no_wa.required' => 'Nomor WhatsApp wajib diisi.',
            'no_wa.string' => 'Nomor WhatsApp harus berupa teks.',
            'no_wa.max' => 'Nomor WhatsApp tidak boleh lebih dari 15 karakter.',
            'foto.image' => 'Foto harus berupa file gambar.',
            'foto.max' => 'Ukuran foto tidak boleh lebih dari 10MB.',
            'transkip.required' => 'Transkip wajib diunggah.',
            'transkip.file' => 'Transkip harus berupa file.',
            'transkip.max' => 'Ukuran file transkip tidak boleh lebih dari 10MB.',
            'surat_pernyataan.required' => 'Surat Pernyataan wajib diunggah.',
            'surat_pernyataan.file' => 'Surat Pernyataan harus berupa file.',
            'surat_pernyataan.max' => 'Ukuran file Surat Pernyataan tidak boleh lebih dari 10MB.',
            'surat_rekomendasi.required' => 'Surat Rekomendasi wajib diunggah.',
            'surat_rekomendasi.file' => 'Surat Rekomendasi harus berupa file.',
            'surat_rekomendasi.max' => 'Ukuran file Surat Rekomendasi tidak boleh lebih dari 10MB.',
        ];

        // Validate the input with custom messages
        $request->validate($rules, $customMessages);


        // Ambil periode aktif
        $periode = Periode::where('status', 'aktif')->first();
        if (!$periode) {
            return redirect()->back()->withErrors(['periode' => 'Tidak ada periode aktif yang ditemukan']);
        }

        // Inisialisasi nama file
        $namaFoto = null;
        $namaTranskip = null;
        $namaPernyataan = null;
        $namaRekomendasi = null;

        // Jika proses edit, ambil data pendaftar
        $pendaftar = $request->id ? Pendaftar::findOrFail($request->id) : new Pendaftar();

        // Proses upload file baru dan hapus file lama jika ada
        if ($request->hasFile('foto')) {
            if ($pendaftar->foto && file_exists(public_path('img/asdos/' . $pendaftar->foto))) {
                unlink(public_path('img/asdos/' . $pendaftar->foto));
            }
            $namaFoto = 'foto_asdos_' . str_replace(' ', '_', strtolower($request->nama)) . '.' . $request->foto->getClientOriginalExtension();
            $request->foto->move(public_path('img/asdos'), $namaFoto);
            $pendaftar->foto = $namaFoto;
        }

        if ($request->hasFile('transkip')) {
            if ($pendaftar->transkip && file_exists(public_path('file/transkip/' . $pendaftar->transkip))) {
                unlink(public_path('file/transkip/' . $pendaftar->transkip));
            }
            $namaTranskip = 'transkip_asdos_' . str_replace(' ', '_', strtolower($request->nama)) . '.' . $request->transkip->getClientOriginalExtension();
            $request->transkip->move(public_path('file/transkip'), $namaTranskip);
            $pendaftar->transkip = $namaTranskip;
        }

        if ($request->hasFile('surat_pernyataan')) {
            if ($pendaftar->surat_pernyataan && file_exists(public_path('file/surat_pernyataan/' . $pendaftar->surat_pernyataan))) {
                unlink(public_path('file/surat_pernyataan/' . $pendaftar->surat_pernyataan));
            }
            $namaPernyataan = 'surat_pernyataan_asdos_' . str_replace(' ', '_', strtolower($request->nama)) . '.' . $request->surat_pernyataan->getClientOriginalExtension();
            $request->surat_pernyataan->move(public_path('file/surat_pernyataan'), $namaPernyataan);
            $pendaftar->surat_pernyataan = $namaPernyataan;
        }

        if ($request->hasFile('surat_rekomendasi')) {
            if ($pendaftar->surat_rekomendasi && file_exists(public_path('file/surat_rekomendasi/' . $pendaftar->surat_rekomendasi))) {
                unlink(public_path('file/surat_rekomendasi/' . $pendaftar->surat_rekomendasi));
            }
            $namaRekomendasi = 'surat_rekomendasi_asdos_' . str_replace(' ', '_', strtolower($request->nama)) . '.' . $request->surat_rekomendasi->getClientOriginalExtension();
            $request->surat_rekomendasi->move(public_path('file/surat_rekomendasi'), $namaRekomendasi);
            $pendaftar->surat_rekomendasi = $namaRekomendasi;
        }

        // Simpan data pendaftar
        $pendaftar->id_user = $request->id_user;
        $pendaftar->stb = $request->stb;
        $pendaftar->nama = $request->nama;
        $pendaftar->alamat = $request->alamat;
        $pendaftar->jurusan = $request->jurusan;
        $pendaftar->ttl = $request->ttl;
        $pendaftar->tempat_lahir = $request->tempat_lahir;
        $pendaftar->no_wa = $request->no_wa;
        $pendaftar->periode = $periode->id;
        $pendaftar->status = "belum diseleksi";
        $pendaftar->save();

        // Proses parsing transkip untuk mendapatkan IPK dan nilai
        if ($namaTranskip) {
            $transkipPath = public_path('file/transkip/' . $namaTranskip);
            $pdfParser = new Parser();
            $pdf = $pdfParser->parseFile($transkipPath);
            $text = $pdf->getText();

            // Ambil IPK
            preg_match('/Indeks Prestasi Komulatif\s+([\d.]+)/', $text, $matches);
            if (!empty($matches[1])) {
                $pendaftar->ipk = $matches[1];
                $pendaftar->save();
            }

            // Hapus nilai lama sebelum menambah nilai baru
            InputNilai::where('id_pendaftar', $pendaftar->id)->delete();

            // Ambil nilai matkul
            preg_match_all('/(\d+)\s+([A-Z0-9-]+)\s+([^0-9\n]+)\s+(\d+)\s+([A-Z+-]+)/', $text, $matches, PREG_SET_ORDER);
            foreach ($matches as $match) {
                if (strpos($match[3], 'Jumlah SKS') === false && strpos($match[3], 'Indeks Prestasi') === false) {
                    InputNilai::create([
                        'id_pendaftar' => $pendaftar->id,
                        'kode' => $match[2],
                        'nama_matkul' => trim($match[3]),
                        'sks' => $match[4],
                        'nilai' => $match[5],
                    ]);
                }
            }
        }
        $u = Auth::user();
        if ($u->role == 'admin') {
            return redirect()->route('pendaftar')->with('success', $request->id ? 'Pendaftar berhasil diupdate.' : 'Pendaftar berhasil ditambahkan.');
        } else {
            return redirect()->route('zpendaftar')->with('success', $request->id ? 'Pendaftar berhasil diupdate.' : 'Pendaftar berhasil ditambahkan.');
        }
    }


    public function hapuspendaftar($id)
    {
        $user = Pendaftar::find($id);

        if ($user) {
            $user->delete(); // Hapus data
            return response()->json(['message' => 'User deleted successfully.'], 200);
        }

        // Jika data tidak ditemukan
        return response()->json(['message' => 'User not found.'], 404);
    }




    // transkip nilai
    public function transkip($id)
    {
        $transkip = InputNilai::where('id_pendaftar', $id)->get();
        return view('admin.master.transkip.index', compact('transkip', 'id'));
    }
    public function tambahtranskip($id)
    {
        return view('admin.master.transkip.tambah', compact('id'));
    }
    public function posttranskip(Request $request)
    {
        $request->validate([
            'kode' => 'required',
            'nama_matkul' => 'required',
            'sks' => 'required',
            'nilai' => 'required',
        ]);

        // Pengecekan apakah STB/NIDN sudah ada di database
        $cekstb = InputNilai::where('kode', $request->kode)->first();
        if ($cekstb && !$request->id) {
            return redirect()->back()->withErrors([
                'kode' => 'sudah terdaftar'
            ])->withInput();
        }

        // proses edit
        if ($request->id) {
            $user = InputNilai::findOrFail($request->id);
            $user->id_pendaftar = $request->id_pendaftar;
            $user->kode = $request->kode;
            $user->nama_matkul = $request->nama_matkul;
            $user->sks = $request->sks;
            $user->nilai = $request->nilai;
            $user->save();
            return redirect()->route('transkip', $request->id_pendaftar)->with('success', 'Transkip berhasil diperbaharui');
        }

        // proses tambah akun
        $user = new InputNilai();
        $user->id_pendaftar = $request->id_pendaftar;
        $user->kode = $request->kode;
        $user->nama_matkul = $request->nama_matkul;
        $user->sks = $request->sks;
        $user->nilai = $request->nilai;
        $user->save();

        return redirect()->route('transkip', $request->id_pendaftar)->with('success', 'Transkip berhasil dibuat');
    }
    public function hapustranskip($id)
    {
        $user = InputNilai::find($id);

        if ($user) {
            $user->delete(); // Hapus data
            return response()->json(['message' => 'User deleted successfully.'], 200);
        }

        // Jika data tidak ditemukan
        return response()->json(['message' => 'User not found.'], 404);
    }





    // akun
    public function akun()
    {
        $user = User::all();
        return view('admin.master.akun.index', compact('user'));
    }
    public function tambahakun()
    {
        return view('admin.master.akun.tambah');
    }
    public function detailakun($id)
    {
        $user = User::findOrFail($id);
        return view('admin.master.akun.detail', compact('user'));
    }
    public function editakun($id)
    {
        $user = User::findOrFail($id);
        return view('admin.master.akun.tambah', compact('user'));
    }
    public function hapusakun($id)
    {
        $user = User::find($id);

        if ($user) {
            $user->delete(); // Hapus data
            return response()->json(['message' => 'User deleted successfully.'], 200);
        }

        // Jika data tidak ditemukan
        return response()->json(['message' => 'User not found.'], 404);
    }
    public function postakun(Request $request)
    {
        $request->validate([
            'stb' => 'required',
            'name' => 'required',
            'email' => 'required',
            'role' => 'required',
            'password' => $request->id ? 'nullable' : 'required'
        ]);

        // Pengecekan apakah STB/NIDN sudah ada di database
        $cekstb = User::where('stb', $request->stb)->first();
        if ($cekstb && !$request->id) {
            return redirect()->back()->withErrors([
                'stb' => 'STB/NIDN sudah terdaftar'
            ])->withInput();
        }

        // proses edit
        if ($request->id) {
            $user = User::findOrFail($request->id);
            $user->stb = $request->stb;
            $user->name = $request->name;
            $user->email = $request->email;
            $user->role = $request->role;
            if ($request->filled('password')) {
                $user->password = Hash::make($request->password);
            }
            $user->save();
            return redirect()->route('akun')->with('success', 'Akun berhasil diperbaharui');
        }

        // proses tambah akun
        $user = new User();
        $user->stb = $request->stb;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->role = $request->role;
        $user->password = Hash::make($request->password);
        $user->save();

        return redirect()->route('akun')->with('success', 'Akun berhasil dibuat');
    }


    // asdos
    public function asdos()
    {
        $periode = Periode::all();
        $periodee = Periode::where('status', 'aktif')->first();
        $asdos = Asdos::where('periode', $periodee->id)->get();

        return view('admin.master.asdos.index', compact('asdos', 'periode'));
    }
    public function tambahasdos()
    {
        return view('admin.master.asdos.tambah');
    }
    public function detailasdos()
    {
        return view('admin.master.asdos.detail');
    }
    public function hapusasdos($id)
    {
        $dosen = Asdos::findOrFail($id);
        if ($dosen) {
            $dosen->delete(); // Hapus data
            return response()->json(['message' => 'User deleted successfully.'], 200);
        }

        // Jika data tidak ditemukan
        return response()->json(['message' => 'User not found.'], 404);
    }




    // dosen
    public function dosen()
    {
        $dosen = Dosen::all();
        return view('admin.master.dosen.index', compact('dosen'));
    }
    public function tambahdosen()
    {
        $user = User::where('role', 'dosen')->get();
        return view('admin.master.dosen.tambah', compact('user'));
    }
    public function editdosen($id)
    {
        $dosen = Dosen::findOrFail($id);
        return view('admin.master.dosen.tambah', compact('dosen'));
    }
    public function detaildosen($id)
    {
        $dosen = Dosen::findOrFail($id);
        return view('admin.master.dosen.detail', compact('dosen'));
    }
    public function hapusdosen($id)
    {
        $dosen = Dosen::findOrFail($id);
        if ($dosen) {
            $dosen->delete(); // Hapus data
            return response()->json(['message' => 'User deleted successfully.'], 200);
        }

        // Jika data tidak ditemukan
        return response()->json(['message' => 'User not found.'], 404);
    }
    public function postdosen(Request $request)
    {
        $request->validate([
            'id_akun' => 'required',
            'nidn' => 'required',
            'nama' => 'required',
            'foto' => 'nullable|image|max:10240',
        ]);

        // Pengecekan apakah STB/NIDN sudah ada di database
        $cekstb = Dosen::where('nidn', $request->nidn)->first();
        if ($cekstb && !$request->id) {
            return redirect()->back()->withErrors([
                'nidn' => 'NIDN sudah terdaftar'
            ])->withInput();
        }

        // Proses unggah foto
        $namaFoto = null;
        if ($request->hasFile('foto')) {
            $namaFoto = 'foto_dosen_' . str_replace(' ', '_', strtolower($request->nama)) . '.' . $request->foto->getClientOriginalExtension();
            $request->foto->move(public_path('img/dosen'), $namaFoto);
        }

        // proses edit
        if ($request->id) {
            $user = Dosen::findOrFail($request->id);
            $user->id_akun = $request->id_akun;
            $user->email = User::where('id', $request->id_akun)->first()->email;
            $user->nama = $request->nama;
            $user->nidn = $request->nidn;
            $user->no_wa = $request->no_wa;
            // Jika ada foto baru, ganti foto lama
            if ($namaFoto) {
                // Hapus foto lama jika ada
                if ($user->foto && file_exists(public_path('img/dosen/' . $user->foto))) {
                    unlink(public_path('img/dosen/' . $user->foto));
                }
                $user->foto = $namaFoto;
            }
            $user->save();
            return redirect()->route('dosen')->with('success', 'Matkul berhasil diperbaharui');
        }

        // proses tambah akun
        $user = new Dosen();
        $user->id_akun = $request->id_akun;
        $user->email = User::where('id', $request->id_akun)->first()->email;
        $user->nama = $request->nama;
        $user->nidn = $request->nidn;
        $user->no_wa = $request->no_wa;
        $user->foto = $namaFoto;
        // dd($user);
        $user->save();

        return redirect()->route('dosen')->with('success', 'Matkul berhasil dibuat');
    }



    // matkul
    public function matkul()
    {
        $matkul = Matkul::all();
        return view('admin.master.matkul.index', compact('matkul'));
    }
    public function tambahmatkul()
    {
        return view('admin.master.matkul.tambah');
    }
    public function editmatkul($id)
    {
        $matkul = Matkul::findOrFail($id);
        return view('admin.master.matkul.tambah', compact('matkul'));
    }
    public function detailmatkul($id)
    {
        $matkul = Matkul::findOrFail($id);
        return view('admin.master.matkul.detail', compact('matkul'));
    }
    public function postmatkul(Request $request)
    {
        $request->validate([
            'kode' => 'required',
            'kode_kelas' => 'required',
            'nama' => 'required',
        ]);

        // Pengecekan apakah STB/NIDN sudah ada di database
        $cekstb = Matkul::where('kode', $request->kode)->first();
        if ($cekstb && !$request->id) {
            return redirect()->back()->withErrors([
                'matkul' => 'KODE sudah terdaftar'
            ])->withInput();
        }

        $cekkode = Matkul::where('kode_kelas', $request->kode_kelas)->first();
        if ($cekkode && !$request->id) {
            return redirect()->back()->withErrors([
                'kelas' => 'Kode Kelas sudah terdaftar'
            ])->withInput();
        }

        // proses edit
        if ($request->id) {
            $user = Matkul::findOrFail($request->id);
            $user->kode = $request->kode;
            $user->kode_kelas = $request->kode_kelas;
            $user->nama = $request->nama;
            $user->save();
            return redirect()->route('matkul')->with('success', 'Matkul berhasil diperbaharui');
        }

        // proses tambah akun
        $user = new Matkul();
        $user->kode = $request->kode;
        $user->kode_kelas = $request->kode_kelas;
        $user->nama = $request->nama;
        $user->save();

        return redirect()->route('matkul')->with('success', 'Matkul berhasil dibuat');
    }
    public function hapusmatkul($id)
    {
        $matkul = Matkul::findOrFail($id);
        if ($matkul) {
            $matkul->delete(); // Hapus data
            return response()->json(['message' => 'User deleted successfully.'], 200);
        }

        // Jika data tidak ditemukan
        return response()->json(['message' => 'User not found.'], 404);
    }



    // periode
    public function periode()
    {
        $periode = Periode::all();
        return view('admin.master.periode.index', compact('periode'));
    }
    public function tambahperiode()
    {
        return view('admin.master.periode.tambah');
    }
    public function editperiode($id)
    {
        $periode = Periode::findOrFail($id);
        return view('admin.master.periode.tambah', compact('periode'));
    }
    public function detailperiode($id)
    {
        $periode = Periode::findOrFail($id);
        return view('admin.master.periode.detail', compact('periode'));
    }
    public function postperiode(Request $request)
    {
        $request->validate([
            'tahun' => 'required',
            'semester' => 'required',
        ]);

        // Pengecekan apakah STB/NIDN sudah ada di database
        $cektahun =
            Periode::where('tahun', $request->tahun)
            ->where('semester', $request->semester)
            ->first();

        if ($cektahun && !$request->id) {
            return redirect()->back()->withErrors([
                'tahun' => 'Periode sudah terdaftar',
                'semester' => 'Semester sudah terdaftar',
            ])->withInput();
        }

        // proses edit
        if ($request->id) {
            $user = Periode::findOrFail($request->id);
            $user->tahun = $request->tahun;
            $user->semester = $request->semester;
            $user->save();
            return redirect()->route('periode')->with('success', 'Akun berhasil diperbaharui');
        }

        // proses tambah akun
        $user = new Periode();
        $user->tahun = $request->tahun;
        $user->semester = $request->semester;
        $user->save();

        return redirect()->route('periode')->with('success', 'Akun berhasil dibuat');
    }

    public function updateperiode(Request $request)
    {
        try {
            $periode = Periode::findOrFail($request->id);

            if ($request->status === 'aktif') {
                // Set all other periods to nonaktif
                Periode::where('id', '!=', $request->id)
                    ->update(['status' => 'nonaktif']);

                // Set this period to aktif
                $periode->status = 'aktif';
            } else {
                // Check if this is the only active period
                $activeCount = Periode::where('status', 'aktif')->count();
                if ($activeCount <= 1 && $periode->status === 'aktif') {
                    return response()->json([
                        'success' => false,
                        'message' => 'Harus ada minimal satu periode yang aktif!'
                    ]);
                }
                $periode->status = 'nonaktif';
            }

            $periode->save();

            return response()->json([
                'success' => true,
                'message' => 'Status berhasil diperbarui'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal memperbarui status'
            ], 500);
        }
    }
    public function hapusperiode($id)
    {
        $user = Periode::find($id);

        if ($user) {
            $user->delete(); // Hapus data
            return response()->json(['message' => 'User deleted successfully.'], 200);
        }

        // Jika data tidak ditemukan
        return response()->json(['message' => 'User not found.'], 404);
    }


    public function jadwal()
    {
        $user = Auth::user();
        $periode = Periode::where('status', 'aktif')->first();
        $asdos = null;

        // Hanya cari data asdos jika user adalah mahasiswa
        if ($user->role == 'mahasiswa') {
            $pendaftar = Pendaftar::where('id_user', $user->id)->first();
            if ($pendaftar) {
                $asdos = Asdos::where('id_pendaftar', $pendaftar->id)
                    ->where('periode', $periode->id)
                    ->first();
            }
        }


        if ($user->role == 'admin') {
            $jadwal = Jadwal::where('id_periode', $periode->id)->get();
        } else if ($user->role == 'mahasiswa') {
            $pen = Pendaftar::where('id_user', $user->id)->where('periode', $periode->id)->first();
            if ($pen) {
                $pilmatkul = PilihMatkul::where('id_pendaftar', $pen->id)->pluck('matkul')->toArray();
                $jadwal = Jadwal::whereIn('nama_matkul', $pilmatkul)->where('id_periode', $periode->id)->get();
            } else {
                $jadwal = collect();
            }
        } else {
            $dosen = Dosen::where('id_akun', $user->id)->first();
            $jadwal = Jadwal::where('nama_dosen', $dosen->nama)->where('id_periode', $periode->id)->get();
        }


        return view('admin.jadwal.index', compact('jadwal', 'asdos'));
    }

    public function tambahjadwal()
    {
        $matkul = Matkul::all();
        $dosen = Dosen::all();
        $periode = Periode::where('status', 'aktif')->first();
        $asdos = Asdos::where('periode', $periode->id)->get();
        // dd($asdos);
        return view('admin.jadwal.tambah', compact('matkul', 'dosen', 'asdos'));
    }
    public function editjadwal($id)
    {
        $jadwal = Jadwal::find($id);
        $matkul = Matkul::all();
        $dosen = Dosen::all();
        $periode = Periode::where('status', 'aktif')->first();
        $asdos = Asdos::where('periode', $periode->id)->get();
        // dd($periode);
        return view('admin.jadwal.tambah', compact('matkul', 'dosen', 'jadwal', 'asdos'));
    }

    public function postjadwal(Request $request)
    {
        $request->validate([
            'hari' => 'required',
            'pukul_mulai' => 'required',
            'ruang' => 'required',
            'kode_kelas' => 'required',
            'huruf_kelas' => 'required',
            'prodi' => 'required',
            'semester' => 'required',
            'nama_matkul' => 'required',
            'nama_dosen' => 'required',
            'asdos1' => 'nullable',
            'asdos2' => 'nullable|different:asdos1',
        ], [
            'hari.required' => 'Hari harus diisi.',
            'pukul_mulai.required' => 'Pukul mulai harus diisi.',
            'ruang.required' => 'Ruang harus diisi.',
            'kode_kelas.required' => 'Kode kelas harus diisi.',
            'huruf_kelas.required' => 'Huruf kelas harus diisi.',
            'prodi.required' => 'Prodi harus diisi.',
            'semester.required' => 'Semester harus diisi.',
            'nama_matkul.required' => 'Nama mata kuliah harus diisi.',
            'nama_dosen.required' => 'Nama dosen harus diisi.',
            'asdos2.different' => 'Asisten dosen 2 tidak boleh sama dengan Asisten dosen 1.',
        ]);

        if ($request->id) {
            $user = Jadwal::findOrFail($request->id);
            $user->id_periode = Periode::where('status', 'aktif')->first()->id;
            $user->hari = $request->hari;
            $user->pukul = substr($request->pukul_mulai, 0, 5);
            $user->kode_kelas = $request->kode_kelas . "-" . $request->huruf_kelas;
            $user->ruang = $request->ruang;
            $user->prodi = $request->prodi;
            $user->semester = $request->semester;
            $user->nama_matkul = $request->nama_matkul;
            $user->nama_dosen = $request->nama_dosen;
            $user->asdos1 = $request->asdos1 ?? null;
            $user->asdos2 = $request->asdos2 ?? null;
            $user->save();
            return redirect()->route('jadwal')->with('success', 'Jadwal berhasil diperbaharui');
        }

        $user = new Jadwal();
        $user->id_periode = Periode::where('status', 'aktif')->first()->id;
        $user->hari = $request->hari;
        $user->pukul = substr($request->pukul_mulai, 0, 5);
        $user->kode_kelas = $request->kode_kelas . "-" . $request->huruf_kelas;
        $user->ruang = $request->ruang;
        $user->prodi = $request->prodi;
        $user->semester = $request->semester;
        $user->nama_matkul = $request->nama_matkul;
        $user->nama_dosen = $request->nama_dosen;
        $user->asdos1 = $request->asdos1 ?? null;
        $user->asdos2 = $request->asdos2 ?? null;
        $user->save();

        return redirect()->route('jadwal')->with('success', 'Jadwal berhasil dibuat');
    }

    public function hapusjadwal($id)
    {
        $user = Jadwal::find($id);

        if ($user) {
            $user->delete(); // Hapus data
            return response()->json(['message' => 'User deleted successfully.'], 200);
        }
        // Jika data tidak ditemukan
        return response()->json(['message' => 'User not found.'], 404);
    }



    // pilih matkul
    public function pilmatkul($id)
    {
        $pendaftaran = Pendaftar::find($id);
        $ko = Matkul::all();
        $matkul = PilihMatkul::where('id_pendaftar', $id)->get();
        return view('admin.master.pil_matkul.index', compact('matkul', 'pendaftaran', 'ko'));
    }

    public function tambahpilmatkul($id)
    {
        $pendaftaran = Pendaftar::find($id);
        $periode = Periode::where('status', 'aktif')->first();
        $matkul = Jadwal::where('id_periode', $periode->id)->select('nama_matkul')->distinct()->get();
        debug($matkul);
        return view('admin.master.pil_matkul.tambah', compact('pendaftaran', 'matkul'));
    }

    public function postpilmatkul(Request $request, $id)
    {
        // Validasi input
        $request->validate([
            'id_pendaftar' => 'required',
            'matkul' => 'required|array|max:3',
        ], [
            'matkul.required' => 'Anda harus memilih setidaknya 1 mata kuliah.',
            'matkul.max' => 'Maksimal 3 mata kuliah yang dapat dipilih.',
        ]);
        // dd($request->matkul);
        // Ambil ID pengguna
        $userId = $request->id_pendaftar;
        // Cek jumlah data di tabel pilmatkul untuk pengguna ini
        $existingCount = PilihMatkul::where('id_pendaftar', $userId)->count();
        $remainingSlots = 3 - $existingCount;

        if ($existingCount + count($request->matkul) > 3) {
            return redirect()->back()->withErrors([
                'matkul' => " Anda hanya dapat menambahkan $remainingSlots mata kuliah lagi."
            ]);
        }
        // Cek duplikasi mata kuliah
        foreach ($request->matkul as $matkulId) {
            $exists = PilihMatkul::where('id_pendaftar', $userId)->where('matkul', $matkulId)->exists();
            if ($exists) {
                return redirect()->back()->withErrors(['matkul' => 'Mata kuliah yang sama tidak boleh dipilih lebih dari sekali.']);
            }
        }

        // Simpan data ke tabel `pilmatkul`
        foreach ($request->matkul as $matkulId) {
            PilihMatkul::create([
                'id_pendaftar' => $userId,
                'matkul' => $matkulId,
            ]);
        }

        return redirect()->route('pilmatkul', $userId)->with('success', 'Pilihan mata kuliah berhasil disimpan.');
    }

    public function hapuspilmatkul($id)
    {
        $user = PilihMatkul::find($id);

        if ($user) {
            $user->delete(); // Hapus data
            return response()->json(['message' => 'User deleted successfully.'], 200);
        }
        // Jika data tidak ditemukan
        return response()->json(['message' => 'User not found.'], 404);
    }



    public function login()
    {
        $user = Auth::user();
        if ($user) {
            // if ($user->role == 'admin') {
            return redirect()->intended('admin');
            // }
        }
        return view('login.login');
    }

    // master 
    public function ketentuan()
    {
        return view('admin.master.ketentuan.index');
    }

    public function zpendaftar()
    {
        $user = Auth::user();
        $periode = Periode::where('status', 'aktif')->first();
        debug($periode);
        debug($user);
        $pendaftar = Pendaftar::where('id_user', $user->id)->where('periode', $periode->id)->first();
        debug($pendaftar);
        return view('admin.master.pendaftar.zindex', compact('pendaftar', 'periode'));
    }


    // ambil kelas
    public function ambilkelas($id)
    {
        $user = Auth::user();
        $periode = Periode::where('status', 'aktif')->first();
        $asdos = Asdos::where('id_user', $user->id)->where('periode', $periode->id)->first();
        $jadwal = Jadwal::find($id);

        if ($jadwal->asdos2 == $asdos->nama) {
            return redirect()->route('jadwal')->with('error', 'Kamu Telah Terdaftar di kelas ini');
        } else {
            $jadwal->asdos1 = $asdos->nama;
            $jadwal->save();
            return redirect()->route('jadwal')->with([
                'success' => 'Verifikasi berhasil dilakukan.',
                'jadwal' => $jadwal->nama_matkul
            ]);
        }
    }

    public function ambilkelas2($id)
    {
        $user = Auth::user();
        $periode = Periode::where('status', 'aktif')->first();
        $asdos = Asdos::where('id_user', $user->id)->where('periode', $periode->id)->first();
        $jadwal = Jadwal::find($id);
        if ($jadwal->asdos1 == $asdos->nama) {
            return redirect()->route('jadwal')->with('error', 'Kamu Telah Terdaftar di kelas ini');
        } else {
            $jadwal->asdos2 = $asdos->nama;
            $jadwal->save();
            return redirect()->route('jadwal')->with([
                'success' => 'Verifikasi berhasil dilakukan.',
                'jadwal' => $jadwal->nama_matkul
            ]);
        }
    }


    // update absensi
    public function absensi2()
    {
        $user = Auth::user();
        $periode = Periode::where('status', 'aktif')->first();
        $asdos = Asdos::where('id_user', $user->id)->where('periode', $periode->id)->first();

        if (!$asdos) {
            $data = true;
            return view('admin.absensi.index', compact('data'))->with('error', 'Tidak ada data absensi yang ditemukan.');
        }
        $jadwal = Jadwal::where('id_periode', $periode->id)
            ->where(function ($query) use ($asdos) {
                $query->where('asdos1', $asdos->nama)
                    ->orWhere('asdos2', $asdos->nama);
            })
            ->get();
        $data = false;
        return view('admin.absensi.index', compact('jadwal', 'data'));
    }
    public function detailabsensi2($id)
    {
        $user = Auth::user();
        $asdos = Asdos::where('id_user', $user->id)->first();
        $jadwal = Jadwal::find($id);
        $absensi = Absen::where('id_asdos', $asdos->id)->where('id_jadwal', $jadwal->id)->get();
        // dd($absensi);
        $summary = [
            'total' => $absensi->where('verifikasi', 'terima')->count(),
            'hadir' => $absensi->where('status', 'hadir')->where('verifikasi', 'terima')->count(),
            'izin' => $absensi->where('status', 'izin')->where('verifikasi', 'terima')->count(),
            'alpa' => $absensi->where('status', 'alpa')->where('verifikasi', 'terima')->count(),
            'terima' => $absensi->where('verifikasi', 'terima')->count(),
        ];
        return view('admin.absensi.absen', compact('absensi', 'summary', 'jadwal'));
    }

    public function postabsensi2(Request $request)
    {
        $request->validate([
            'pertemuan' => 'required',
            'status' => 'required',
        ]);
        // dd($request->all());

        $user = Auth::user();
        $asdos = Asdos::where('id_user', $user->id)->first();
        $jadwal = Jadwal::find($request->id_jadwal);
        $periode = Periode::where('status', 'aktif')->first();

        $absen = new Absen();
        $absen->id_asdos = $asdos->id;
        $absen->id_jadwal = $jadwal->id;
        $absen->status = $request->status;
        $absen->periode = $periode->id;
        $absen->pertemuan = $request->pertemuan;
        $absen->verifikasi = 'pending';
        $absen->save();

        return redirect()->back();
    }

    public function kelolaabsensi()
    {
        $user = Auth::user();
        if ($user->role == 'admin') {
            $periode = Periode::where('status', 'aktif')->first();
            $jadwal = Jadwal::where('id_periode', $periode->id)->get();
            // dd($jadwal);
            return view('admin.absensi.dosen.index', compact('jadwal'));
        } else {
            $dosen = Dosen::where('id_akun', $user->id)->first();
            $periode = Periode::where('status', 'aktif')->first();
            $jadwal = Jadwal::where('id_periode', $periode->id)->where('nama_dosen', $dosen->nama)->get();
            return view('admin.absensi.dosen.index', compact('jadwal'));
        }
    }
    public function verifikasiabsensi($id)
    {

        $absensi = Absen::where('id_jadwal', $id)->get();
        $periode = Periode::where('status', 'aktif')->first();
        $asdos = Asdos::where('periode', $periode->id)->get();
        $summary = [
            'total' => $absensi->where('verifikasi', 'terima')->count(),
            'hadir' => $absensi->where('status', 'hadir')->where('verifikasi', 'terima')->count(),
            'izin' => $absensi->where('status', 'izin')->where('verifikasi', 'terima')->count(),
            'alpa' => $absensi->where('status', 'alpa')->where('verifikasi', 'terima')->count(),
            'terima' => $absensi->where('verifikasi', 'terima')->count(),
        ];
        return view('admin.absensi.dosen.verifikasi', compact('absensi', 'summary', 'asdos'));
    }
    public function terima_absensi($id)
    {
        $absensi = Absen::find($id);
        $absensi->verifikasi = 'terima';
        $absensi->save();
        return redirect()->back();
    }

    // financial
    public function financial()
    {
        $user = Auth::user();
        $periode = Periode::where('status', 'aktif')->first();
        $asdos = Asdos::where('id_user', $user->id)
            ->where('periode', $periode->id)
            ->first();
        if (!$asdos) {
            $data = true;
            return view('admin.financial.index', compact('data'))->with('error', 'Tidak ada data absensi yang ditemukan.');
        }

        $absen = Absen::where('id_asdos', $asdos->id)->where('periode', $periode->id)->where('verifikasi', 'terima')->get();


        $pendapatan = [
            'kehadiran' => $absen->count(),
            'gajipokok' => 15000,
            'pendapatan' => 15000 * $absen->count(),
            'pajak' => (15000 * $absen->count()) * 0.05,
            'hasilbersih' => (15000 * $absen->count()) * (1 - 0.05)
        ];
        $data = false;
        return view('admin.financial.index', compact('asdos', 'pendapatan', 'data'));
    }
    public function rekapfinancial()
    {
        $periodeAktif = Periode::where('status', 'aktif')->first();

        if (!$periodeAktif) {
            return redirect()->back()->with('error', 'Tidak ada periode aktif yang ditemukan');
        }

        $asdosList = Asdos::where('periode', $periodeAktif->id)->get();

        $absenList = Absen::where('periode', $periodeAktif->id)->get();
        $datapajak = Setting::first();
        $pajak = $datapajak->pajak / 100;

        $asdosWithEarnings = $asdosList->map(function ($asdos) use ($absenList, $pajak) {
            $jumlahKehadiran = $absenList->where('id_asdos', $asdos->id)->count();
            $pendapatan = ($jumlahKehadiran * 15000) * (1 - $pajak); // Rp 15.000 per meeting

            $asdos->kehadiran = $jumlahKehadiran;
            $asdos->pendapatan = $pendapatan;

            return $asdos;
        });

        $totalPengeluaran = ($asdosWithEarnings->sum('pendapatan'));

        return view('admin.financial.admin', [
            'asdos' => $asdosWithEarnings,
            'pengeluaran' => $totalPengeluaran,
            'absen' => $absenList
        ]);
    }


    // sertifikat
    public function sertifikat()
    {
        $user = Auth::user();

        $periode = Periode::where('status', 'aktif')->first();
        $asdos = Asdos::where('id_user', $user->id)
            ->where('periode', $periode->id)
            ->first();
        // dd($asdos);

        if ($user->role == "mahasiswa") {
            if (!$asdos) {
                $ada = true;
                return view('admin.sertifikat.index', compact('ada'));
            }
        }
        $ada = false;

        // Ambil semua jadwal untuk periode aktif
        $jadwals = Jadwal::where('id_periode', $periode->id)->get();

        $data = [];

        foreach ($jadwals as $jadwal) {
            // Cek asdos1
            $asdos1 = Asdos::where('nama', $jadwal->asdos1)->first();

            if ($asdos1) {
                $this->prosesAsdos($asdos1, $jadwal, $periode, $data);
            }

            // Cek asdos2
            $asdos2 = Asdos::where('nama', $jadwal->asdos2)->first();
            if ($asdos2) {
                $this->prosesAsdos($asdos2, $jadwal, $periode, $data);
            }
        }
        // dd($data);
        if ($user->role == "mahasiswa") {
            $asdos = Asdos::where('id_user', $user->id)->where('periode', $periode->id)->first();
            // dd($asdos);
            if ($asdos) {
                // Ambil sertifikat berdasarkan id_asdos
                $sertifikat = Sertifikat::where('id_asdos', $asdos->id)->first();
                // dd($sertifikat);
                if ($sertifikat) {
                    // Jika sertifikat ditemukan, set data hanya satu sertifikat
                    $jumlahHadir = Absen::where('id_asdos', $asdos->id)
                        ->where('id_jadwal', $jadwal->id)
                        ->where('periode', $periode->id)
                        ->where('status', 'hadir')
                        ->where('verifikasi', 'terima')
                        ->count();
                    $data = [[
                        'id' => $sertifikat->id,
                        'asdos' => $asdos,
                        'jumlah_hadir' => $jumlahHadir,
                        'periode' => $periode,
                        'url' => $sertifikat->url,
                        'qr_code' => $sertifikat->qr_code,
                        'file_path' => $sertifikat->file_path
                    ]];
                } else {
                    $data = [];
                }
            }
        }
        return view('admin.sertifikat.index', compact('data', 'ada'));
    }

    private function prosesAsdos($asdos, $jadwal, $periode, &$data)
    {
        // Hitung absen hadir yang sudah terverifikasi
        $jumlahHadir = Absen::where('id_asdos', $asdos->id)
            ->where('id_jadwal', $jadwal->id)
            ->where('periode', $periode->id)
            ->where('status', 'hadir')
            ->where('verifikasi', 'terima')
            ->count();

        // Jika memenuhi syarat (minimal 2x hadir)
        $batas = Setting::first()->minimal_sertifikat;
        if ($jumlahHadir >= $batas) {
            $sertifikat = Sertifikat::firstOrNew(['id_asdos' => $asdos->id]);

            $filePath = null;

            // Jika sertifikat sudah ada, ambil file_path-nya
            if ($sertifikat->exists && $sertifikat->file_path) {
                $filePath = $sertifikat->file_path;
            }

            // Jika sertifikat baru dibuat
            if (!$sertifikat->exists) {
                $timestamp = Carbon::now()->format('Ymd_His');
                $url = url("/storage/sertifikat/{$asdos->nama}_{$periode->id}_{$timestamp}.pdf");

                // Buat direktori QR code jika belum ada
                $qrDirectory = public_path('qrcode');
                if (!file_exists($qrDirectory)) {
                    mkdir($qrDirectory, 0755, true);
                }

                $qrFilename = "{$asdos->nama}_{$periode->id}_{$timestamp}.png";
                $qrPath = public_path("qrcode/{$qrFilename}");

                // Generate QR Code
                try {
                    $process = new Process([
                        'C:\\Users\\Admin\\AppData\\Local\\Programs\\Python\\Python313\\python.exe',
                        base_path('app/Python/generate_qr.py'),
                        $url,
                        $qrPath
                    ]);
                    $process->mustRun();
                } catch (ProcessFailedException $e) {
                    Log::error('Gagal generate QR Code: ' . $e->getMessage());
                    $qrFilename = null; // Tetap simpan data meski QR gagal
                }

                // Simpan data sertifikat
                $sertifikat->fill([
                    'url' => $url,
                    'qr_code' => $qrFilename,
                    'file_path' => null
                ])->save();
            }

            // Tambahkan ke data output
            $data[] = [
                'id' => $sertifikat->id,
                'asdos' => $asdos,
                'jadwal' => $jadwal,
                'jumlah_hadir' => $jumlahHadir,
                'periode' => $periode,
                'url' => $sertifikat->url,
                'qr_code' => $sertifikat->qr_code,
                'file_path' => $filePath
            ];
        }
    }

    public function uploadSertifikat(Request $request, $name)
    {
        $request->validate([
            'sertifikat_pdf' => 'required|mimes:pdf|max:20000' // ~20MB
        ]);


        $sertifikat = Sertifikat::where('qr_code', $name)->firstOrFail();
        // dd($name);

        // Hapus file lama jika ada
        if ($sertifikat->file_path) {
            $oldFilePath = str_replace('sertifikat/', 'public/sertifikat/', $sertifikat->file_path);
            if (Storage::exists($oldFilePath)) {
                Storage::delete($oldFilePath);
            }
        }

        // Generate nama file (hilangkan .png dari qr_code)
        $fileName = str_replace('.png', '.pdf', $name);
        // dd($fileName);

        // Simpan file baru
        $path = $request->file('sertifikat_pdf')->storeAs(
            'public/sertifikat',
            $fileName
        );

        // Simpan path relatif ke database
        $publicPath = 'sertifikat/' . $fileName;

        $sertifikat->file_path = $publicPath;
        $sertifikat->update();
        // dd($sertifikat);

        return redirect()->back()->with('success', 'Sertifikat berhasil diupload');
    }
}
