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
    public function kriteria(){
        $ipk = Kriteria::where('nama_kriteria', 'ipk')->first();
        $matkul = Kriteria::where('nama_kriteria', 'nilai_matkul')->first();
        $rekomendasi = Kriteria::where('nama_kriteria', 'rekomendasi')->first();
        $pernyataan = Kriteria::where('nama_kriteria', 'pernyataan')->first();
        if (!$ipk) {
            $ipk = new Kriteria();
            $ipk->nama_kriteria = 'ipk';
            $ipk->bobot = 0;
            $ipk->save();
        }
        if (!$matkul) {
            $matkul = new Kriteria();
            $matkul->nama_kriteria = 'matkul';
            $matkul->bobot = 0;
            $matkul->save();
        }
        if (!$rekomendasi) {
            $rekomendasi = new Kriteria();
            $rekomendasi->nama_kriteria = 'rekomendasi';
            $rekomendasi->bobot = 0;
            $rekomendasi->save();
        }
        if (!$pernyataan) {
            $pernyataan = new Kriteria();
            $pernyataan->nama_kriteria = 'pernyataan';
            $pernyataan->bobot = 0;
            $pernyataan->save();
        }
        return view('admin.setting.kriteria.index', compact('ipk', 'matkul', 'rekomendasi', 'pernyataan'));
    }
    public function kriteriaUpdate(Request $request)
    {
        $request->validate([
            'criteria' => 'required|in:ipk,nilai_matkul,rekomendasi,pernyataan',
            'value' => 'required|numeric|min:0|max:100'
        ]);
        
        // Konversi dari persentase ke desimal (100% -> 1.0)
        $newBobot = $request->value / 100;

        // Hitung total bobot saat ini (tanpa kriteria yang sedang diupdate)
        $totalBobot = Kriteria::where('nama_kriteria', '!=', $request->criteria)
            ->sum('bobot');
        // dd($totalBobot);
        // Total baru setelah update
        $newTotal = $totalBobot + $newBobot;

        if ($newTotal > 1.0) { // 1.0 = 100%
            return back()->with('error', 'Total bobot melebihi 100% setelah perubahan ini');
        }

        // Update data kriteria
        $kriteria = Kriteria::where('nama_kriteria', $request->criteria)->first();

        if (!$kriteria) {
            return back()->with('error', 'Kriteria tidak ditemukan');
        }

        $kriteria->bobot = $newBobot;
        $kriteria->save();

        return back()->with('success', 'Bobot berhasil diperbarui');
    }

    public function batasan()
    {
        $setting = Setting::first();
        if (!$setting) {
            $setting = new Setting();
            $setting->batasan_asdos = 0;
            $setting->minimal_sertifikat = 0;
            $setting->save();
        }
        return view('admin.setting.batasan.index', compact('setting'));
    }

    public function batasanUpdate(Request $request)
    {
        $request->validate([
            'setting_type' => 'required|in:schedule,certificate',
            'batasan_asdos' => 'required_if:setting_type,schedule|integer|min:1|max:20',
            'minimal_sertifikat' => 'required_if:setting_type,certificate|integer|min:0|max:10'
        ]);
        // dd($request->all());

        try {
            $setting = Setting::firstOrFail();

            if ($request->setting_type == 'schedule') {
                $setting->batasan_asdos = $request->batasan_asdos;
                $message = 'Batas jadwal berhasil diperbarui menjadi ' . $request->batasan_asdos;
            } else {
                $setting->minimal_sertifikat = $request->minimal_sertifikat;
                $message = 'Batas sertifikat berhasil diperbarui menjadi ' . $request->minimal_sertifikat;
            }

            $setting->save();

            return redirect()->route('setting.batasan')->with('success', $message);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal memperbarui pengaturan: ' . $e->getMessage());
        }
    }

    public function pajak()
    {
        $pajak = Setting::first();
        if (!$pajak) {
            $pajak = new Setting();
            $pajak->pajak = 0; // Default pajak 0%
            $pajak->save();
        }
        return view('admin.financial.pajak', compact('pajak'));
    }

    public function updatePajak(Request $request)
    {
        $request->validate([
            'tax_percentage' => 'required|numeric|min:0|max:100'
        ]);

        try {
            $pajak = Setting::firstOrFail();
            $pajak->pajak = $request->tax_percentage;
            $pajak->save();

            return redirect()->back()->with('success', 'Pengaturan pajak berhasil diperbarui.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal memperbarui pengaturan pajak: ' . $e->getMessage());
        }
    }
    
}
