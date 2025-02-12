<?php

namespace App\Http\Controllers;

use App\Models\Asdos;
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

class AdminController extends Controller
{
    public function index()
    {
        $pendaftar = Pendaftar::count();
        $asdos = Asdos::count();
        $jadwal = Jadwal::count();
        return view('admin.dashboard.index', compact('pendaftar', 'asdos', 'jadwal'));
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
        $asdos = Asdos::all();

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
        $user->id_akun = $request->id_akun;
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


    public function jadwal()
    {
        $user = Auth::user();
        $periode = Periode::where('status', 'aktif')->first();


        if ($user->role == 'admin') {
            $jadwal = Jadwal::where('id_periode', $periode->id)->get();
        } else if ($user->role == 'mahasiswa') {
            $pen = Pendaftar::where('id_user', $user->id)->where('periode', $periode->id)->first();
            if ($pen) {
                $pilmatkul = PilihMatkul::where('id_pendaftar', $pen->id)->pluck('matkul')->toArray();
                $jadwal = Jadwal::whereIn('nama_matkul', $pilmatkul)->where('id_periode', $periode->id)->get();
            } else {
                $jadwal = collect(); // Jika $pen tidak ditemukan, buat koleksi kosong
            }
        } else {
            $dosen = Dosen::where('id_akun', $user->id)->first();
            $jadwal = Jadwal::where('nama_dosen', $dosen->nama)->where('id_periode', $periode->id)->get();
        }


        return view('admin.jadwal.index', compact('jadwal'));
    }

    public function tambahjadwal()
    {
        $matkul = Matkul::all();
        $dosen = Dosen::all();
        $periode = Periode::where('status', 'aktif')->first();
        $asdos = Asdos::where('periode', $periode->tahun)->get();
        // dd($asdos);
        return view('admin.jadwal.tambah', compact('matkul', 'dosen', 'asdos'));
    }
    public function editjadwal($id)
    {
        $jadwal = Jadwal::find($id);
        $matkul = Matkul::all();
        $dosen = Dosen::all();
        $periode = Periode::where('status', 'aktif')->first();
        $asdos = Asdos::where('periode', $periode->tahun)->get();
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


    public function verifikasi()
    {
        return view('admin.verifikasi.index');
    }
    public function postverifikasi()
    {
        $bobot = [
            'ipk' => 0.4, // 40%
            'nilai_matkul' => 0.3, // 30%
            'rekomendasi' => 0.2, // 20%
            'pernyataan' => 0.1, // 10%
        ];
        $periode = Periode::where('status', 'aktif')->first();
        $pendaftar = Pendaftar::where('periode', $periode->id)->get();
        $ranking = [];
        $n = [];
        foreach ($pendaftar as $p) {
            $pilmatkul = InputNilai::where('id_pendaftar', $p->id)->get();
            // Array untuk menyimpan bobot nilai
            $nilai = PilihMatkul::where('id_pendaftar', $p->id)->get();

            foreach ($pilmatkul as $m) {
                foreach ($nilai as $ni) {
                    $relasi = Matkul::where('kode_kelas', $ni->matkul)->first();

                    if ($relasi->kode == $m->kode) {
                        // Cek nilai dan tambahkan bobot sesuai
                        if ($m->nilai == 'A') {
                            $n[] = 4.0;
                        } elseif ($m->nilai == 'A-') {
                            $n[] = 3.75;
                        } elseif ($m->nilai == 'B+') {
                            $n[] = 3.50;
                        } elseif ($m->nilai == 'B') {
                            $n[] = 3.00;
                        } elseif ($m->nilai == 'B-') {
                            $n[] = 2.75;
                        } elseif ($m->nilai == 'C+') {
                            $n[] = 2.50;
                        } elseif ($m->nilai == 'C') {
                            $n[] = 2.00;
                        } elseif ($m->nilai == 'D') {
                            $n[] = 1.00;
                        } elseif ($m->nilai == 'E') {
                            $n[] = 0;
                        }
                    }
                }
            }


            $sp = $p->surat_pernyataan ? 1 : 0; // Cek surat pernyataan
            $sr = $p->surat_rekomendasi ? 1 : 0; // Cek surat rekomendasi
            $ip = ($p->ipk / 4.0) * $bobot['ipk'];
            $pm = (array_sum($n) / (count($n) * 4)) * $bobot['nilai_matkul'];
            $sup = $sp * $bobot['pernyataan'];
            $sur = $sr * $bobot['rekomendasi'];
            $skor =  $ip + $pm + $sur + $sup;
            $ranking[] = [
                'id_user' => $p->id_user,
                'id_pendaftar' => $p->id,
                'nama' => $p->nama,
                'stb' => $p->stb,
                'jurusan' => $p->jurusan,
                'no_wa' => $p->no_wa,
                'foto' => $p->foto,
                'skor' => $skor,
                'ip' => $ip,
                'pm' => $pm,
                'sup' => $sup,
                'sur' => $sur,


            ];
        }

        usort($ranking, function ($a, $b) {
            return $b['skor'] <=> $a['skor'];
        });
        // dd(vars: $ranking);
        $jmlulus = Jadwal::count() / 2;
        foreach ($ranking as $index => $asdos) {
            $status = $index < $jmlulus ? 'lulus' : 'tidak';

            if ($index < $jmlulus) {
                Asdos::Create(
                    [
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
                    ]
                );
                $pen = Pendaftar::findOrFail($asdos['id_pendaftar']);
                $pen->status = $status;
                $pen->save();
            } else {
                $pen = Pendaftar::findOrFail($asdos['id_pendaftar']);
                $pen->status = $status;
                $pen->save();
            }
        }


        return redirect()->route('asdos')->with('success', 'asdos berhasil diverifikasi.');
    }


    public function absen()
    {
        $asdos = Asdos::all();
        return view('admin.absensi.absen.index', compact('asdos'));
    }


    public function verifyabsen()
    {
        return view('admin.absensi.verifikasi.index');
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
            return redirect()->route('jadwal')->with('error', 'jadwal telah terdaftar');
        } else {
            $jadwal->asdos1 = $asdos->nama;
            $jadwal->save();
            return redirect()->route('jadwal')->with('success', 'jadwal berhasil diupdate.');
        }
    }

    public function ambilkelas2($id)
    {
        $user = Auth::user();
        $periode = Periode::where('status', 'aktif')->first();
        $asdos = Asdos::where('id_user', $user->id)->where('periode', $periode->id)->first();
        $jadwal = Jadwal::find($id);
        if ($jadwal->asdos1 == $asdos->nama) {
            return redirect()->route('jadwal')->with('error', 'jadwal telah terdaftar');
        } else {
            $jadwal->asdos2 = $asdos->nama;
            $jadwal->save();
            return redirect()->route('jadwal')->with('success', 'jadwal berhasil diupdate.');
        }
    }
}
