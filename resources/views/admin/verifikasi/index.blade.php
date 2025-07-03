@extends('admin.layout.master')
@section('konten')
    <div class="page-wrapper">
        <div class="content">
            <!-- Simple Header -->
            <div class="page-header mb-4">
                <h4 class="fw-bold text-dark">Verifikasi Pendaftar</h4>
                <p class="text-muted">Penentuan Penerimaan Asisten Laboratorium</p>
            </div>

            <!-- Clean Card Design -->
            <div class="card border-0 shadow-sm rounded-3">
                <div class="card-header bg-white border-bottom py-3">
                    <h5 class="mb-0 fw-bold">
                        <i class="fas fa-clipboard-check text-success me-2"></i>
                        Ketentuan Verifikasi
                    </h5>
                </div>

                <div class="card-body p-4">
                    <!-- Simplified List -->
                    <div class="list-group list-group-flush border-0">
                        <div class="list-group-item border-0 px-0 py-2 d-flex align-items-center">
                            <span class="badge bg-success bg-opacity-10 text-success rounded-circle me-3 p-2">
                                <i class="fas fa-check"></i>
                            </span>
                            <div>
                                <p class="mb-0">Pastikan semua dokumen yang disyaratkan telah diterima</p>
                            </div>
                        </div>

                        <div class="list-group-item border-0 px-0 py-2 d-flex align-items-center">
                            <span class="badge bg-success bg-opacity-10 text-success rounded-circle me-3 p-2">
                                <i class="fas fa-check"></i>
                            </span>
                            <div>
                                <p class="mb-0">Periksa kelengkapan data pendaftar</p>
                            </div>
                        </div>

                        <div class="list-group-item border-0 px-0 py-2 d-flex align-items-center">
                            <span class="badge bg-success bg-opacity-10 text-success rounded-circle me-3 p-2">
                                <i class="fas fa-check"></i>
                            </span>
                            <div>
                                <p class="mb-0">Verifikasi bersifat final dan tidak dapat dibatalkan</p>
                            </div>
                        </div>
                    </div>

                    <!-- Simple Button -->
                    <div class="text-center mt-4">
                        <form action="{{ route('postverifikasi') }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-success px-4 py-2">
                                <i class="fas fa-user-check me-2"></i>
                                Verifikasi
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Minimal Error Modal -->
    <div class="modal fade" id="errorModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 rounded-3 overflow-hidden">
                <div class="modal-body p-4 text-center">
                    <div class="mb-3">
                        <i class="fas fa-times-circle text-danger" style="font-size: 3rem;"></i>
                    </div>
                    <h5 class="fw-bold mb-3">Verifikasi Gagal!</h5>
                    <p class="text-muted mb-4">{{ session('error') }}</p>
                    <button type="button" class="btn btn-outline-danger px-4" data-bs-dismiss="modal">
                        Tutup
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        @if(session('error'))
            document.addEventListener('DOMContentLoaded', function () {
                new bootstrap.Modal(document.getElementById('errorModal')).show();
            });
        @endif
    </script>
@endsection