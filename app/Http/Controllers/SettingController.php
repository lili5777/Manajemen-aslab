<?php

namespace App\Http\Controllers;

use App\Models\Kriteria;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    // Batasa Asdos
    public function index(){
        $setting = Setting::first();
        if (!$setting) {
            $setting = new Setting();
            $setting->batasan_asdos = 0;
            $setting->minimal_sertifikat = 0;
            $setting->save();
        }
        return view('settings.index', compact('setting',''));
    }
    public function update($id){
        $setting = Setting::findOrFail($id);
        $setting->batasan_asdos = request('batasan_asdos');
        $setting->save();
        return redirect()->back()->with('success', 'Pengaturan berhasil diperbarui.');
    }

    // minimal sertifikat
    public function sertifikatIndex(){
        $setting = Setting::first();
        if (!$setting) {
            $setting = new Setting();
            $setting->minimal_sertifikat = 0;
            $setting->save();
        }
        return view('settings.sertifikat', compact('setting'));
    }
    public function sertifikatUpdate($id){
        $setting = Setting::findOrFail($id);
        $setting->minimal_sertifikat = request('minimal_sertifikat');
        $setting->save();
        return redirect()->back()->with('success', 'Pengaturan berhasil diperbarui.');
    }

    // Kriteria
    public function kriteriaIndex(){
        $kriterias = Kriteria::all();
        return view('settings.kriteria', compact('kriterias'));
    }
    public function kriteriaStore(Request $request){
        $request->validate([
            'nama_kriteria' => 'required',
            'bobot' => 'required'
        ]);
        if($request->id){
            $kriteria = Kriteria::findOrFail($request->id);
            $kriteria->nama_kriteria = $request->nama_kriteria;
            $kriteria->bobot = $request->bobot;
            $kriteria->save();
            return redirect()->back()->with('success', 'Kriteria berhasil diperbarui.');
        }
        $kriteria = new Kriteria();
        $kriteria->nama_kriteria = $request->nama_kriteria;
        $kriteria->bobot = $request->bobot;
        $kriteria->save();

        return redirect()->back()->with('success', 'Kriteria berhasil ditambahkan.');
    }
    
    public function kriteriaDestroy($id){
        $kriteria = Kriteria::findOrFail($id);
        $kriteria->delete();
        return redirect()->back()->with('success', 'Kriteria berhasil dihapus.');
    }

}
