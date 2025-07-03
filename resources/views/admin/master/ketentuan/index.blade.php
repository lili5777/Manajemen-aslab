@extends('admin.layout.master')
@section('konten')
    <div class="page-wrapper">
        <div class="content">
            <!-- Modern Header -->
            <div class="page-header mb-4">
                <div class="d-flex align-items-center">
                    <div class="me-3">
                        <div class="icon-shape bg-primary bg-opacity-10 text-primary rounded-3 p-3">
                            <i class="fas fa-clipboard-list fs-4"></i>
                        </div>
                    </div>
                    <div>
                        <h4 class="fw-bold mb-1">Ketentuan</h4>
                        <p class="text-muted mb-0">Kelola Persyaratan</p>
                    </div>
                </div>
            </div>

            <!-- Modern Card Design -->
            <div class="card border-0 rounded-4 shadow-sm overflow-hidden">
                <div class="card-header bg-primary bg-opacity-10 border-bottom py-3">
                    <p class="mb-0 fw-bold text-primary " style="font-size: 20px">
                        <i class="fas fa-info-circle me-2"></i>
                        Sebelum melakukan pendaftaran, calon pendaftar wajib menyiapkan berkas-berkas
                        berikut:
                    </p>
                </div>

                <div class="card-body p-4">
                    {{-- <div class="alert alert-primary bg-primary bg-opacity-05 border-primary border-opacity-25">
                        <i class="fas fa-info-circle me-2"></i>
                        <strong>Sebelum melakukan pendaftaran</strong>, calon pendaftar wajib menyiapkan berkas-berkas
                        berikut:
                    </div> --}}

                    <!-- Modern Requirements List -->
                    <div class="requirements-list">
                        <!-- Requirement Item 1 -->
                        <div class="requirement-item">
                            <div class="requirement-header">
                                <span class="requirement-number bg-primary text-white">1</span>
                                <h5 class="fw-bold mb-0">Surat Pernyataan</h5>
                            </div>
                            <div class="requirement-content">
                                <ul class="mb-0">
                                    <li>Berisi pernyataan kesediaan dan ditandatangani oleh pendaftar</li>
                                    <li>File harus diunggah dalam format <strong class="text-primary">PDF</strong></li>
                                    <li class="mt-2">
                                        <a href="{{ asset('file/surat/suratpernyataan.pdf') }}"
                                            class="btn btn-sm btn-outline-primary" download>
                                            <i class="fas fa-download me-1"></i> Download Template
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <!-- Requirement Item 2 -->
                        <div class="requirement-item">
                            <div class="requirement-header">
                                <span class="requirement-number bg-primary text-white">2</span>
                                <h5 class="fw-bold mb-0">Surat Rekomendasi</h5>
                            </div>
                            <div class="requirement-content">
                                <ul class="mb-0">
                                    <li>Diisi dan ditandatangani oleh dosen yang memberikan rekomendasi</li>
                                    <li>File harus diunggah dalam format <strong class="text-primary">PDF</strong></li>
                                    <li class="mt-2">
                                        <a href="{{ asset('file/surat/suratrekomendasi.pdf') }}"
                                            class="btn btn-sm btn-outline-primary" download>
                                            <i class="fas fa-download me-1"></i> Download Template
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <!-- Requirement Item 3 -->
                        <div class="requirement-item">
                            <div class="requirement-header">
                                <span class="requirement-number bg-primary text-white">3</span>
                                <h5 class="fw-bold mb-0">Transkrip Nilai</h5>
                            </div>
                            <div class="requirement-content">
                                <ul class="mb-0">
                                    <li>Format transkrip nilai dapat dilihat pada contoh di bawah ini</li>
                                    <li class="mt-2">
                                        <a href="{{ asset('file/surat/transkip.pdf') }}" class="btn btn-sm btn-outline-primary" download>
                                            <i class="fas fa-download me-1"></i> Download Template
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <!-- Additional Requirements -->
                    <div class="additional-requirements mt-5 pt-3 border-top">
                        <h5 class="fw-bold mb-3 text-primary">
                            <i class="fas fa-clipboard-check me-2"></i>
                            Syarat Pendaftaran:
                        </h5>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="d-flex align-items-start">
                                    <span class="badge bg-primary bg-opacity-10 text-primary rounded-circle me-3 p-2">
                                        <i class="fas fa-check"></i>
                                    </span>
                                    <div>
                                        <p class="mb-0">IPK minimal <strong class="text-primary">3.0</strong></p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="d-flex align-items-start">
                                    <span class="badge bg-primary bg-opacity-10 text-primary rounded-circle me-3 p-2">
                                        <i class="fas fa-check"></i>
                                    </span>
                                    <div>
                                        <p class="mb-0">Lulus mata kuliah dengan nilai minimal <strong
                                                class="text-primary">B</strong></p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="d-flex align-items-start">
                                    <span class="badge bg-primary bg-opacity-10 text-primary rounded-circle me-3 p-2">
                                        <i class="fas fa-check"></i>
                                    </span>
                                    <div>
                                        <p class="mb-0">Bersedia mematuhi semua peraturan</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        /* Modern Card Styling */
        .card {
            border: none;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
        }

        .card:hover {
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.1);
        }

        /* Requirements List Styling */
        .requirements-list {
            margin-top: 1.5rem;
        }

        .requirement-item {
            margin-bottom: 0.5rem;
            padding-bottom: 0.5rem;
            border-bottom: 1px dashed rgba(0, 0, 0, 0.1);
        }

        .requirement-item:last-child {
            border-bottom: none;
            margin-bottom: 0;
            padding-bottom: 0;
        }

        .requirement-header {
            display: flex;
            align-items: center;
            margin-bottom: 0.75rem;
        }

        .requirement-number {
            width: 28px;
            height: 28px;
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            margin-right: 12px;
            font-size: 14px;
        }

        .requirement-content ul {
            padding-left: 1.5rem;
        }

        .requirement-content li {
            margin-bottom: 0.5rem;
        }

        /* Responsive Adjustments */
        @media (max-width: 768px) {
            .requirement-header {
                flex-direction: column;
                align-items: flex-start;
            }

            .requirement-number {
                margin-bottom: 0.5rem;
            }
        }
    </style>
@endsection