@extends('admin.layout.master')
@section('konten')
    <div class="page-wrapper">
        <div class="container-fluid">
            @if($pendaftar)
                <!-- Header dengan Breadcrumb -->
                <div class="row page-titles">
                    <div class="col-md-5 align-self-center">
                        <h4 class="text-themecolor">Profil Pendaftar</h4>
                        <div class="d-flex align-items-center">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="javascript:void(0)">Dashboard</a></li>
                                <li class="breadcrumb-item active">Profil Pendaftar</li>
                            </ol>
                        </div>
                    </div>
                    <div class="col-md-7 align-self-center text-end">
                        <a href="{{ route('editpendaftar', $pendaftar->id) }}" class="btn btn-info text-white">
                            <i class="fas fa-edit me-2"></i> Edit Profil
                        </a>
                    </div>
                </div>

                <!-- Card Utama -->
                <div class="row">
                    <div class="col-lg-4 col-xlg-3 col-md-5">
                        <!-- Profile Card -->
                        <div class="card">
                            <div class="card-body">
                                <center class="mt-4">
                                    <div class="avatar-container">
                                        <div class="avatar-wrapper">
                                            <img src="{{ asset('img/asdos/' . $pendaftar->foto) }}" class="avatar-image"
                                                onerror="this.src='https://ui-avatars.com/api/?name={{ urlencode($pendaftar->nama) }}&background=random'">
                                        </div>
                                    </div>
                                    <h4 class="card-title mt-3">{{ $pendaftar->nama }}</h4>
                                    <h6 class="card-subtitle text-muted">{{ $pendaftar->jurusan }}</h6>
                                    <div class="badge bg-success text-white mt-2">{{ $pendaftar->status }}</div>

                                    @if($pendaftar->status == 'lulus')
                                        <div class="mt-3">
                                            <a href="{{ route('idcard.show', $pendaftar->id) }}" class="btn btn-primary">
                                                <i class="fas fa-id-card me-2"></i> Download ID Card
                                            </a>
                                        </div>
                                    @endif
                                </center>
                            </div>
                            <div class="card-footer text-center bg-light">
                                <div class="row">
                                    <div class="col-6 border-end">
                                        <h4 class="mb-0 cfs2">{{ $pendaftar->ipk }}</h4>
                                        <small class="text-muted">IPK</small>
                                    </div>
                                    <div class="col-6">
                                        <h4 class="mb-0 cfs2">{{ $periode->tahun }}</h4>
                                        <small class="text-muted">Periode</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-8 col-xlg-9 col-md-7">
                        <div class="card">
                            <!-- Nav tabs -->
                            <ul class="nav nav-tabs profile-tab" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" data-bs-toggle="tab" href="#profile" role="tab">
                                        <i class="fas fa-user me-1"></i> Profil
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-bs-toggle="tab" href="#documents" role="tab">
                                        <i class="fas fa-file-alt me-1"></i> Dokumen
                                    </a>
                                </li>
                            </ul>

                            <!-- Tab panes -->
                            <div class="tab-content">
                                <!-- Profil Tab -->
                                <div class="tab-pane active" id="profile" role="tabpanel">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label class="form-label text-muted">STB</label>
                                                    <p class="cfs">{{ $pendaftar->stb }}</p class="cfs">
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label text-muted">No. WhatsApp</label>
                                                    <p class="cfs">{{ $pendaftar->no_wa }}</p class="cfs">
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label text-muted">Tempat/Tanggal Lahir</label>
                                                    <p class="cfs">{{ $pendaftar->tempat_lahir }}, {{ $pendaftar->ttl }}</p
                                                        class="cfs">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label class="form-label text-muted">Alamat</label>
                                                    <p class="cfs">{{ $pendaftar->alamat }}</p class="cfs">
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label text-muted">Jurusan</label>
                                                    <p class="cfs">{{ $pendaftar->jurusan }}</p class="cfs">
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label text-muted">Mata Kuliah Pilihan</label><br>
                                                    <a href="{{ route('pilmatkul', $pendaftar->id) }}"
                                                        class="btn btn-sm btn-outline-primary">
                                                        <i class="fas fa-book me-1"></i> Lihat
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Dokumen Tab -->
                                <div class="tab-pane" id="documents" role="tabpanel">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-4 mb-3">
                                                <div class="card document-card h-100">
                                                    <div class="card-body text-center d-flex flex-column">
                                                        <div class="doc-icon mb-3">
                                                            <i class="fas fa-file-signature text-primary"
                                                                style="font-size: 2.5rem;"></i>
                                                        </div>
                                                        <p class="cfs3">Surat Pernyataan</p>
                                                        <div class="mt-auto">
                                                            <a href="{{ asset('file/surat_pernyataan/' . $pendaftar->surat_pernyataan) }}"
                                                                target="_blank" class="btn btn-sm btn-primary">
                                                                <i class="fas fa-eye me-1"></i> Lihat
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4 mb-3">
                                                <div class="card document-card h-100">
                                                    <div class="card-body text-center d-flex flex-column">
                                                        <div class="doc-icon mb-3">
                                                            <i class="fas fa-file-contract text-success"
                                                                style="font-size: 2.5rem;"></i>
                                                        </div>
                                                        <p class="cfs3">Surat Rekomendasi</p>
                                                        <div class="mt-auto">
                                                            <a href="{{ asset('file/surat_rekomendasi/' . $pendaftar->surat_rekomendasi) }}"
                                                                target="_blank" class="btn btn-sm btn-success">
                                                                <i class="fas fa-eye me-1"></i> Lihat
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4 mb-3">
                                                <div class="card document-card h-100">
                                                    <div class="card-body text-center d-flex flex-column">
                                                        <div class="doc-icon mb-3">
                                                            <i class="fas fa-file-invoice text-warning"
                                                                style="font-size: 2.5rem;"></i>
                                                        </div>
                                                        <p class=" cfs3">Transkrip Nilai</p>
                                                        <div class="mt-auto">
                                                            <a href="{{ route('transkip', $pendaftar->id) }}"
                                                                class="btn btn-sm btn-warning text-white">
                                                                <i class="fas fa-eye me-1"></i> Lihat
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <!-- Empty State -->
                <div class="row justify-content-center">
                    <div class="col-lg-6">
                        <div class="card">
                            <div class="card-body text-center">
                                <img src="{{ asset('assets/images/empty-state.svg') }}" alt="Empty" class="img-fluid mb-4"
                                    style="max-height: 200px;">
                                <h4 class="text-danger">Data Pendaftar Tidak Ditemukan</h4>
                                <p class="text-muted">Silakan melakukan pendaftaran terlebih dahulu.</p>
                                <a href="{{ route('tambahpendaftar') }}" class="btn btn-primary">
                                    <i class="fas fa-user-plus me-2"></i> Daftar Sekarang
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <style>
        .avatar-container {
            display: flex;
            justify-content: center;
            margin-bottom: 1.5rem;
        }

        .avatar-wrapper {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            overflow: hidden;
            border: 5px solid #f8f9fa;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            position: relative;
        }

        .cfs {
            font-size: 14px;
            font-weight: 500;
        }
        .cfs2 {
            font-size: 18px;
        }
        .cfs3 {
            font-size: 16px;
            font-weight: lighter;
        }

        .avatar-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
            object-position: center;
        }

        .document-card {
            transition: all 0.3s ease;
            border-radius: 10px;
            border: none;
            box-shadow: 0 2px 15px rgba(0, 0, 0, 0.1);
            min-height: 220px;
            /* Tinggi minimum yang dipatenkan */
        }

        .document-card .doc-icon {
            height: 60px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .document-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.15);
        }

        .profile-tab .nav-link {
            font-weight: 500;
            border: none;
            padding: 12px 20px;
        }

        .profile-tab .nav-link.active {
            border-bottom: 3px solid #7460ee;
            color: #7460ee;
            background: transparent;
        }

        .card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 2px 15px rgba(0, 0, 0, 0.1);
        }

        .h-100 {
            height: 100%;
        }
    </style>
@endsection