@extends('admin.layout.master')
@section('konten')
    <div class="page-wrapper">
        <div class="content">
            <div class="page-header">
                <div class="page-title">
                    <h4>Riwayat Absensi</h4>
                    <h6>Detail kehadiran per pertemuan</h6>
                </div>
                <div class="page-btn">
                    <a href="#" class="btn btn-added" data-bs-toggle="modal" data-bs-target="#tambahKehadiranModal">
                        <img src="{{ asset('img/icons/plus.svg') }}" alt="img" class="me-1">Tambah Kehadiran
                    </a>
                </div>
            </div>

            <div class="card">
                {{-- <div class="card-header bg-primary text-white">
                    <h5 class="card-title mb-0">Daftar Pertemuan</h5>
                </div> --}}
                <div class="card-body">
                    @if($absensi->isEmpty())
                        <!-- Empty State -->
                        <div class="text-center py-5">
                            <h4 class="text-muted">Belum Ada Data Absensi</h4>
                            <p class="text-muted mb-4">Tidak ada riwayat kehadiran yang tercatat saat ini</p>
                            @if (auth()->user()->role == 'admin' || auth()->user()->role == 'dosen')
                                <a href="{{ route('tambahriwayatabsensi', ['id_jadwal' => $id, 'asdos' => $asdos]) }}" 
                                   class="btn btn-primary">
                                    <i class="fas fa-plus me-2"></i>Tambah Absensi Pertama
                                </a>
                            @endif
                        </div>
                    @else
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead class="table-light">
                                    <tr>
                                        <th>#</th>
                                        <th>Pertemuan Ke</th>
                                        <th>Tanggal</th>
                                        <th>Status</th>
                                        <th>Verifikasi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($absensi as $key => $item)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>
                                                <span class="badge bg-info">Pertemuan {{ $item->pertemuan }}</span>
                                            </td>
                                            <td>{{ \Carbon\Carbon::parse($item->tanggal)->format('d M Y') }}</td>
                                            <td>
                                                @if($item->status == 'hadir')
                                                    <span class="badge bg-success">Hadir</span>
                                                @elseif($item->status == 'izin')
                                                    <span class="badge bg-warning text-dark">Izin</span>
                                                @else
                                                    <span class="badge bg-danger">Alpa</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($item->verifikasi == 'terima')
                                                    <span class="badge bg-success">Diterima</span>
                                                @elseif($item->verifikasi == 'tolak')
                                                    <span class="badge bg-danger">Ditolak</span>
                                                @else
                                                    <span class="badge bg-secondary">Pending</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Summary Card -->
                        <div class="row mt-4">
                            <div class="col-md-3">
                                <div class="card stat-card bg-success bg-opacity-10 border-success">
                                    <div class="card-body">
                                        <h5 class="card-title">Hadir</h5>
                                        <h2 class="text-success">{{ $summary['hadir'] }}</h2>
                                        <p class="text-muted mb-0">
                                            {{ $summary['total'] > 0 ? number_format(($summary['hadir'] / $summary['total']) * 100, 1) : 0 }}% dari total</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="card stat-card bg-warning bg-opacity-10 border-warning">
                                    <div class="card-body">
                                        <h5 class="card-title">Izin</h5>
                                        <h2 class="text-warning">{{ $summary['izin'] }}</h2>
                                        <p class="text-muted mb-0">
                                            {{ $summary['total'] > 0 ? number_format(($summary['izin'] / $summary['total']) * 100, 1) : 0 }}% dari total</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="card stat-card bg-danger bg-opacity-10 border-danger">
                                    <div class="card-body">
                                        <h5 class="card-title">Alpa</h5>
                                        <h2 class="text-danger">{{ $summary['alpa'] }}</h2>
                                        <p class="text-muted mb-0">
                                            {{ $summary['total'] > 0 ? number_format(($summary['alpa'] / $summary['total']) * 100, 1) : 0 }}% dari total</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="card stat-card bg-primary bg-opacity-10 border-primary">
                                    <div class="card-body">
                                        <h5 class="card-title">Total Pertemuan</h5>
                                        <h2 class="text-primary">{{ $summary['total'] }}</h2>
                                        <p class="text-muted mb-0">100% kehadiran</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                    @endif
                </div>
            </div>
        </div>
    </div>

    @include('admin.absensi.tambah')

    <style>
        .stat-card {
            transition: transform 0.3s;
            height: 100%;
        }

        .stat-card:hover {
            transform: translateY(-5px);
        }

        .badge {
            padding: 6px 10px;
            font-weight: 500;
        }

        .table-hover tbody tr:hover {
            background-color: rgba(0, 0, 0, 0.02);
        }
    </style>
@endsection