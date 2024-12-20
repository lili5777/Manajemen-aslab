<?php

namespace App\Http\Controllers;

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
    public function detailakun()
    {
        return view('admin.master.akun.detail');
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
            return response()->json(['success' => 'Akun berhasil dibuat.'], 200);
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
        return view('admin.master.periode.index');
    }
    public function tambahperiode()
    {
        return view('admin.master.periode.tambah');
    }
    public function detailperiode()
    {
        return view('admin.master.periode.detail');
    }
}
