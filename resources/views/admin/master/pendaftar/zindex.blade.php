@extends('admin.layout.master')
@section('konten')
<div class="page-wrapper">
    <div class="content">
        @if($pendaftar)
            <div class="page-header">
                <div class="page-title">
                    <h4>Profil Pendaftar</h4>
                    <h6>Informasi Lengkap Pendaftar</h6>
                </div>
                <div class="page-btn">
                    <a href="{{ route('editpendaftar', $pendaftar->id) }}" class="btn btn-outline-secondary">
                        <i class="fa fa-edit me-1"></i> Edit Profil
                    </a>
                </div>
            </div>

            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Detail Profil Pendaftar</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <!-- Foto -->
                        <div class="col-md-3 text-center">
                            <img src="{{ asset('img/asdos/' . $pendaftar->foto) }}" alt="Foto Pendaftar"
                                class="img-thumbnail mb-3" style="width: 100%; max-height: 200px;">
                            <h6 class="mt-2">{{ $pendaftar->nama }}</h6>
                        </div>

                        <!-- Data Pribadi -->
                        <div class="col-md-9">
                            <table class="table table-borderless">
                                <tbody>
                                    <tr>
                                        <th width="25%">Nama</th>
                                        <td>: {{ $pendaftar->nama }}</td>
                                    </tr>
                                    <tr>
                                        <th>STB</th>
                                        <td>: {{ $pendaftar->stb }}</td>
                                    </tr>
                                    <tr>
                                        <th>Alamat</th>
                                        <td>: {{ $pendaftar->alamat }}</td>
                                    </tr>
                                    <tr>
                                        <th>Jurusan</th>
                                        <td>: {{ $pendaftar->jurusan }}</td>
                                    </tr>
                                    <tr>
                                        <th>Tempat, Tanggal Lahir</th>
                                        <td>: {{ $pendaftar->tempat_lahir }}, {{ $pendaftar->ttl }}</td>
                                    </tr>
                                    <tr>
                                        <th>No. WA</th>
                                        <td>: {{ $pendaftar->no_wa }}</td>
                                    </tr>
                                    <tr>
                                        <th>Periode</th>
                                        <td>: {{$periode->tahun}}</td>
                                    </tr>
                                    <tr>
                                        <th>Status</th>
                                        <td>: {{ $pendaftar->status }}</td>
                                    </tr>
                                    <tr>
                                        <th>IPK</th>
                                        <td>: {{ $pendaftar->ipk }}</td>
                                    </tr>
                                    <tr>
                                        <th>Matkul Pilihan</th>
                                        <td>: <a href="{{ route('pilmatkul', $pendaftar->id) }}" class="btn btn-primary text-white btn-sm">Lihat</a></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <hr>

                    <!-- Tombol Lihat Detail -->
                    <div class="row">
                        <div class="col-md-4 text-center">
                            <a href="{{ asset('file/surat_pernyataan/' . $pendaftar->surat_pernyataan) }}" target="_blank"
                                class="btn btn-outline-primary w-100 mb-2">
                                <i class="fa fa-file-alt me-1"></i> Lihat Surat Pernyataan
                            </a>
                        </div>
                        <div class="col-md-4 text-center">
                            <a href="{{ asset('file/surat_rekomendasi/' . $pendaftar->surat_rekomendasi) }}" target="_blank"
                                class="btn btn-outline-success w-100 mb-2">
                                <i class="fa fa-file-alt me-1"></i> Lihat Surat Rekomendasi
                            </a>
                        </div>
                        <div class="col-md-4 text-center">
                            <a href="{{ asset('file/transkip/' . $pendaftar->transkip) }}" target="_blank"
                                class="btn btn-outline-warning w-100 mb-2">
                                <i class="fa fa-file-alt me-1"></i> Lihat Transkrip
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            {{-- <div class="card shadow-sm mt-4">
                <div class="card-header bg-secondary text-white">
                    <h5 class="mb-0">Mata Kuliah Pilihan</h5>
                </div>
                <div class="card-body">
                    @if($matkulPilihan->isNotEmpty())
                        <ul class="list-group">
                            @foreach($matkulPilihan as $matkul)
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    {{ $matkul->nama_matkul }}
                                    <span class="badge bg-primary">{{ $matkul->kode_matkul }}</span>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <p class="text-muted">Belum ada mata kuliah yang dipilih.</p>
                    @endif

                    <div class="text-center mt-3">
                        <a href="{{ route('pilihmatkul') }}" class="btn btn-outline-primary">
                            <i class="fa fa-book me-1"></i> Pilih Mata Kuliah
                        </a>
                    </div>
                </div>
            </div> --}}
        @else
            <div class="text-center mt-5">
                <h4 class="text-danger">Data Pendaftar Tidak Ditemukan</h4>
                <p>Silakan melakukan pendaftaran terlebih dahulu.</p>
                <a href="{{ route('tambahpendaftar') }}" class="btn btn-primary">
                    <i class="fa fa-user-plus me-1"></i> Daftar Sekarang
                </a>
            </div>
        @endif
    </div>
</div>
@endsection