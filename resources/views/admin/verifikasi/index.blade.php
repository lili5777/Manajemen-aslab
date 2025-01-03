@extends('admin.layout.master')
@section('konten')
    <div class="page-wrapper">
        <div class="content">
            <div class="page-header">
                <div class="page-title">
                    <h4>Verifikasi Pendaftar</h4>
                    <h6>Penentuan Penerimaan Asisten Laboratorium</h6>
                </div>
            </div>

            <div class="card shadow-lg border-0">
                <div class="card-header bg-success text-white text-center">
                    <h5 class="mb-0">Ketentuan Verifikasi</h5>
                </div>
                <div class="card-body">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item d-flex align-items-center">
                            <i class="fas fa-check-circle text-success me-2"></i> Pastikan semua dokumen yang disyaratkan
                            telah diterima.
                        </li>
                        <li class="list-group-item d-flex align-items-center">
                            <i class="fas fa-check-circle text-success me-2"></i> Periksa kelengkapan data pendaftar sesuai
                            standar yang ditentukan.
                        </li>
                        <li class="list-group-item d-flex align-items-center">
                            <i class="fas fa-exclamation-circle text-warning me-2"></i> Verifikasi hanya dapat dilakukan
                            satu kali dan tidak dapat dibatalkan.
                        </li>
                    </ul>

                    <div class="text-center mt-4">
                        <a href="{{ route('postverifikasi') }}" class="btn btn-success btn-lg px-4"">
                            <i class="fas fa-user-check"></i> Verifikasi
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
