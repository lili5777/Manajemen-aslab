<?php

namespace App\Http\Controllers;

use App\Models\Asdos;
use App\Models\Pendaftar;
use Illuminate\Support\Str;
use Illuminate\Http\Response;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class IdcardController extends Controller
{
    public function show($id)
    {
        try {
            if(auth()->user()->role == 'admin') {
                $user = Asdos::findOrFail($id);
            }else{
                $user = Pendaftar::findOrFail($id);
            }
            

            // Buat instance ImageManager dengan driver GD
            $manager = new ImageManager(new Driver());

            // Pastikan path file ada
            $templatePath = public_path('idcard/template/canvas.png');
            $photoPath = public_path('img/asdos/' . $user->foto);

            if (!file_exists($templatePath)) {
                throw new \Exception("Template ID Card tidak ditemukan");
            }

            if (!file_exists($photoPath)) {
                throw new \Exception("Foto asdos tidak ditemukan");
            }

            // Buka template dan foto
            $canvas = $manager->read($templatePath);
            $photo = $manager->read($photoPath)->cover(375, 453);

            // Sisipkan foto
            $canvas->place($photo, 'top-left', 106, 261);

            // Tambahkan teks nama
            $fontPath = public_path('fonts/ARIALBD.TTF'); // atau font lain yang Anda miliki

            $canvas->text(
                Str::upper($user->nama),
                295, // posisi X (horizontal)
                790, // posisi Y (vertikal) - disesuaikan
                function ($font) use ($fontPath) {
                    $font->filename($fontPath); // gunakan font custom
                    $font->size(25); // ukuran lebih realistis
                    $font->color('#FFFFFF');
                    $font->align('center');
                    $font->valign('middle');
                }
            );

            // Pastikan folder generated ada
            $outputDir = public_path('idcard/generated');
            if (!file_exists($outputDir)) {
                mkdir($outputDir, 0755, true);
            }

            $path = $outputDir . '/idcard_' . $user->id . '.png';
            $canvas->save($path, quality: 90);

            return response()->download($path)->deleteFileAfterSend();
        } catch (\Exception $e) {
            // Log error untuk debugging
            \Log::error('Error generating ID Card: ' . $e->getMessage());

            return response()->json([
                'error' => 'Terjadi kesalahan saat membuat ID Card',
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
