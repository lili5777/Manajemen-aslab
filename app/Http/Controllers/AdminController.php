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
        $pendaftar->periode = $periode->tahun;
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

        return redirect()->route('pendaftar')->with('success', $request->id ? 'Pendaftar berhasil diupdate.' : 'Pendaftar berhasil ditambahkan.');
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
        return view('admin.master.transkip.index', compact('transkip'));
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
}
