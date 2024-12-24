<?php

namespace App\Http\Controllers;

use App\Models\Dosen;
use App\Models\InputNilai;
use App\Models\Matkul;
use App\Models\Pendaftar;
use App\Models\Periode;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Smalot\PdfParser\Parser;

class AdminController extends Controller
{
    public function index()
    {
        return view('admin.dashboard.index');
    }

    // master
    // pendaftar
    public function pendaftar()
    {
        $pendaftar = Pendaftar::all();
        return view('admin.master.pendaftar.index', compact('pendaftar'));
    }
    public function tambahpendaftar()
    {
        $user = User::all();
        return view('admin.master.pendaftar.tambah', compact('user'));
    }
    public function detailpendaftar()
    {
        return view('admin.master.pendaftar.detail');
    }
    public function postpendaftar(Request $request)
    {
        // Validasi input
        $request->validate([
            'id_user' => 'required|exists:users,id',
            'stb' => 'required|string|unique:pendaftars,stb',
            'nama' => 'required|string|max:255',
            'alamat' => 'required|string',
            'jurusan' => 'required|string|max:255',
            'ttl' => 'required|date',
            'tempat_lahir' => 'required|string|max:255',
            'no_wa' => 'required|string|max:15',
            'foto' => 'nullable|image|max:10240',
            'transkip' => 'required|file|max:10240',
            'surat_pernyataan' => 'required|file|max:10240',
            'surat_rekomendasi' => 'required|file|max:10240',
        ]);

        // Ambil periode aktif
        $periode = Periode::where('status', 'aktif')->first();
        if (!$periode) {
            return redirect()->back()->withErrors(['periode' => 'Tidak ada periode aktif yang ditemukan']);
        }

        // Proses upload file
        // $namaFoto = null;
        if ($request->hasFile('foto')) {
            $namaFoto = 'foto_asdos_' . str_replace(' ', '_', strtolower($request->nama)) . '.' . $request->foto->getClientOriginalExtension();
            $request->foto->move(public_path('img/asdos'), $namaFoto);
        }

        $namaTranskip = null;
        if ($request->hasFile('transkip')) {
            $namaTranskip = 'transkip_asdos_' . str_replace(' ', '_', strtolower($request->nama)) . '.' . $request->transkip->getClientOriginalExtension();
            $request->transkip->move(public_path('file/transkip'), $namaTranskip);
            $transkipPath = public_path('file/transkip/' . $namaTranskip);
        }

        $namaPernyataan = null;
        if ($request->hasFile('surat_pernyataan')) {
            $namaPernyataan = 'surat_pernyataan_asdos_' . str_replace(' ', '_', strtolower($request->nama)) . '.' . $request->surat_pernyataan->getClientOriginalExtension();
            $request->surat_pernyataan->move(public_path('file/surat_pernyataan'), $namaPernyataan);
        }

        $namaRekomendasi = null;
        if ($request->hasFile('surat_rekomendasi')) {
            $namaRekomendasi = 'surat_rekomendasi_asdos_' . str_replace(' ', '_', strtolower($request->nama)) . '.' . $request->surat_rekomendasi->getClientOriginalExtension();
            $request->surat_rekomendasi->move(public_path('file/surat_rekomendasi'), $namaRekomendasi);
        }

        // Simpan data ke tabel pendaftar
        $pendaftar = new Pendaftar();
        $pendaftar->id_user = $request->id_user;
        $pendaftar->stb = $request->stb;
        $pendaftar->nama = $request->nama;
        $pendaftar->alamat = $request->alamat;
        $pendaftar->jurusan = $request->jurusan;
        $pendaftar->ttl = $request->ttl;
        $pendaftar->tempat_lahir = $request->tempat_lahir;
        $pendaftar->no_wa = $request->no_wa;
        $pendaftar->foto = $namaFoto;
        $pendaftar->transkip = $namaTranskip;
        $pendaftar->surat_pernyataan = $namaPernyataan;
        $pendaftar->surat_rekomendasi = $namaRekomendasi;
        $pendaftar->periode = $periode->tahun;
        $pendaftar->status = "belum diseleksi";
        $pendaftar->save();

        if (isset($transkipPath) && file_exists($transkipPath)) {
            $pdfParser = new Parser();
            $pdf = $pdfParser->parseFile($transkipPath);
            $text = $pdf->getText();

            preg_match_all('/(\d+)\s+([A-Z0-9-]+)\s+([^0-9\n]+)\s+(\d+)\s+([A-Z+-]+)\s+/', $text, $matches, PREG_SET_ORDER);

            foreach ($matches as $match) {
                InputNilai::create([
                    'id_pendaftar' => $pendaftar->id,
                    'kode' => $match[2],
                    'nama_matkul' => trim($match[3]),
                    'sks' => $match[4],
                    'nilai' => $match[5]
                ]);
            }
        }
        // Redirect dengan pesan sukses
        return redirect()->route('pendaftar')->with('success', 'Pendaftar berhasil ditambahkan.');
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
        return view('admin.master.asdos.index');
    }
    public function tambahasdos()
    {
        return view('admin.master.asdos.tambah');
    }
    public function detailasdos()
    {
        return view('admin.master.asdos.detail');
    }




    // dosen
    public function dosen()
    {
        $dosen = Dosen::all();
        return view('admin.master.dosen.index', compact('dosen'));
    }
    public function tambahdosen()
    {
        return view('admin.master.dosen.tambah');
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
            $user->email = $request->email;
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
        $user->email = $request->email;
        $user->nama = $request->nama;
        $user->nidn = $request->nidn;
        $user->no_wa = $request->no_wa;
        $user->foto = $namaFoto;
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
            'nama' => 'required',
        ]);

        // Pengecekan apakah STB/NIDN sudah ada di database
        $cekstb = Matkul::where('kode', $request->kode)->first();
        if ($cekstb && !$request->id) {
            return redirect()->back()->withErrors([
                'kode' => 'KODE sudah terdaftar'
            ])->withInput();
        }

        // proses edit
        if ($request->id) {
            $user = Matkul::findOrFail($request->id);
            $user->kode = $request->kode;
            $user->nama = $request->nama;
            $user->save();
            return redirect()->route('matkul')->with('success', 'Matkul berhasil diperbaharui');
        }

        // proses tambah akun
        $user = new Matkul();
        $user->kode = $request->kode;
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
}
