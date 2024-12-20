<?php

namespace App\Http\Controllers;

use App\Models\Periode;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

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
        return view('admin.master.pendaftar.index');
    }
    public function tambahpendaftar()
    {
        return view('admin.master.pendaftar.tambah');
    }
    public function detailpendaftar()
    {
        return view('admin.master.pendaftar.detail');
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
        return view('admin.master.dosen.index');
    }
    public function tambahdosen()
    {
        return view('admin.master.dosen.tambah');
    }
    public function detaildosen()
    {
        return view('admin.master.dosen.detail');
    }



    // matkul
    public function matkul()
    {
        return view('admin.master.matkul.index');
    }
    public function tambahmatkul()
    {
        return view('admin.master.matkul.tambah');
    }
    public function detailmatkul()
    {
        return view('admin.master.matkul.detail');
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
        return view('admin.master.periode.detail',compact('periode'));
    }
    public function postperiode(Request $request)
    {
        $request->validate([
            'tahun' => 'required',
        ]);

        // Pengecekan apakah STB/NIDN sudah ada di database
        $cektahun = Periode::where('tahun', $request->tahun)->first();
        if ($cektahun && !$request->id) {
            return redirect()->back()->withErrors([
                'tahun' => 'Periode sudah terdaftar'
            ])->withInput();
        }

        // proses edit
        if ($request->id) {
            $user = Periode::findOrFail($request->id);
            $user->tahun = $request->tahun;
            $user->save();
            return redirect()->route('periode')->with('success', 'Akun berhasil diperbaharui');
        }

        // proses tambah akun
        $user = new Periode();
        $user->tahun = $request->tahun;
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
