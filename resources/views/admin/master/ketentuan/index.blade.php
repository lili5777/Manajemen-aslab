@extends('admin.layout.master')
@section('konten')
    <div class="page-wrapper">
        <div class="content">
            <div class="page-header">
                <div class="page-title">
                    <h4>Ketentuan</h4>
                    <h6>Kelola Kehadiran Aslab</h6>
                </div>
            </div>

            <div class="card shadow-sm mb-4">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">Persyaratan Pendaftaran Calon Asisten Laboratorium</h4>
                </div>
                <div class="card-body">
                    <p class="mb-3"><strong>Sebelum melakukan pendaftaran, calon pendaftar wajib menyiapkan berkas-berkas
                            berikut:</strong></p>
                    <ul class="list-group mb-4">
                        <li class="list-group-item">
                            <strong>1. Surat Pernyataan</strong>
                            <ul>
                                <li>Berisi pernyataan kesediaan dan ditandatangani oleh pendaftar.</li>
                                <li>File surat pernyataan harus diunggah dalam format <strong>PDF</strong>.</li>
                                <li>Surat pernyataan dapat diunduh dengan mengklik tombol <a href="{{ asset('file/surat/suratpernyataan.pdf') }}"
                                        class="btn btn-sm btn-secondary" download>Download</a>.</li>
                            </ul>
                        </li>
                        <li class="list-group-item">
                            <strong>2. Surat Rekomendasi</strong>
                            <ul>
                                <li>Diisi dan ditandatangani oleh dosen yang memberikan rekomendasi.</li>
                                <li>File surat rekomendasi harus diunggah dalam format <strong>PDF</strong>.</li>
                                <li>Surat rekomendasi dapat diunduh dengan mengklik tombol <a href="{{ asset('file/surat/suratrekomendasi.pdf') }}"
                                        class="btn btn-sm btn-secondary" download>Download</a>.</li>
                            </ul>
                        </li>
                        <li class="list-group-item">
                            <strong>3. Transkrip Nilai</strong>
                            <ul>
                                <li>Format transkrip nilai dapat dilihat pada contoh di bawah ini.</li>
                                <li><em>(Penjelasan mengenai format transkrip menyusul.)</em></li>
                            </ul>
                        </li>
                    </ul>

                    <h5 class="mt-4">Syarat Pendaftaran:</h5>
                    <ul>
                        <li>IPK minimal <strong>3.0</strong>.</li>
                        <li>Lulus mata kuliah yang diasistensikan dengan nilai minimal <strong>B</strong>.</li>
                        <li>Bersedia mematuhi semua peraturan yang berlaku.</li>
                    </ul>
                </div>
            </div>


        </div>
    </div>
@endsection