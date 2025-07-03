@extends('admin.layout.master')

@section('konten')
    <div class="page-wrapper">
        <div class="container-fluid">
            <!-- Header -->
            <div class="row page-titles my-2">
                <div class="col-md-5 align-self-center">
                    <h4 class="text-themecolor fw-bold my-2">
                        <i class="fas fa-percentage me-2"></i> Pengaturan Pajak & Pendapatan
                    </h4>
                </div>
            </div>

            <!-- Content -->
            <div class="row">
                <div class="col-12">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body">
                            {{-- Alert sukses / error --}}
                            @if(session('success'))
                                <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm mb-4">
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-check-circle me-3 fs-4"></i>
                                        <div>
                                            <h6 class="mb-1">Berhasil!</h6>
                                            <p class="mb-0">{{ session('success') }}</p>
                                        </div>
                                        <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"
                                            aria-label="Close"></button>
                                    </div>
                                </div>
                            @endif
                            @if(session('error'))
                                <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm mb-4">
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-exclamation-circle me-3 fs-4"></i>
                                        <div>
                                            <h6 class="mb-1">Terjadi Kesalahan!</h6>
                                            <p class="mb-0">{{ session('error') }}</p>
                                        </div>
                                        <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"
                                            aria-label="Close"></button>
                                    </div>
                                </div>
                            @endif

                            <!-- Cards in Single Row -->
                            <div class="row g-4">
                                <!-- Card Pendapatan Asdos -->
                                <div class="col-md-6">
                                    <div class="card bg-gradient-income h-100 border-0 shadow-sm">
                                        <div class="card-body p-4">
                                            <div class="d-flex justify-content-between align-items-center h-100">
                                                <div class="me-3">
                                                    <h4 class="fw-bold mb-1 text-white">
                                                        <i class="fas fa-money-bill-wave me-2"></i> Honor Asdos
                                                    </h4>
                                                    <p class="mb-0 text-white-75">Tarif per Pertemuan untuk asisten dosen</p>
                                                </div>
                                                <div class="text-end">
                                                    <span
                                                        class="display-5 fw-bold text-white">Rp{{ number_format($pajak->honor, 0, ',', '.') }}</span>
                                                    <p class="mb-0 text-white-75">Per Jam</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-footer bg-white-10 text-end py-2 border-0">
                                            <button class="btn btn-sm btn-light rounded-pill px-3" data-bs-toggle="modal"
                                                data-bs-target="#editIncomeModal" data-value="{{ $pajak->honor }}">
                                                <i class="fas fa-pencil-alt me-1 text-primary"></i> Ubah
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                <!-- Card Pajak -->
                                <div class="col-md-6">
                                    <div class="card bg-gradient-tax h-100 border-0 shadow-sm">
                                        <div class="card-body p-4">
                                            <div class="d-flex justify-content-between align-items-center h-100">
                                                <div class="me-3">
                                                    <h4 class="fw-bold mb-1 text-white">
                                                        <i class="fas fa-receipt me-2"></i> Tarif Pajak
                                                    </h4>
                                                    <p class="mb-0 text-white-75">Persentase potongan gaji bersih</p>
                                                </div>
                                                <div class="text-end">
                                                    <span class="display-5 fw-bold text-white">{{ $pajak->pajak }}%</span>
                                                    <p class="mb-0 text-white-75">Potongan</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-footer bg-white-10 text-end py-2 border-0">
                                            <button class="btn btn-sm btn-light rounded-pill px-3" data-bs-toggle="modal"
                                                data-bs-target="#editTaxModal" data-value="{{ $pajak->pajak }}">
                                                <i class="fas fa-pencil-alt me-1 text-warning"></i> Ubah
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div><!-- /.card-body -->
                    </div><!-- /.card -->
                </div>
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div><!-- /.page-wrapper -->

    <!-- Modal Edit Pendapatan -->
    <div class="modal fade" id="editIncomeModal" tabindex="-1" aria-labelledby="editIncomeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="editIncomeModalLabel">
                        <i class="fas fa-money-bill-wave me-2"></i> Ubah Tarif Pendapatan
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <form id="incomeForm" method="POST" action="{{ route('honor.update') }}">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="incomeValue" class="form-label fw-bold">Tarif Per Pertemuan</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light-primary border-primary">Rp</span>
                                <input type="number" class="form-control" id="incomeValue" name="honor"
                                    value="{{ old('honor', $pajak->honor) }}" min="0" required>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer border-0">
                        <button type="button" class="btn btn-outline-secondary rounded-pill px-4" data-bs-dismiss="modal">
                            <i class="fas fa-times me-1"></i> Batal
                        </button>
                        <button type="submit" class="btn btn-primary rounded-pill px-4">
                            <i class="fas fa-save me-1"></i> Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Edit Pajak -->
    <div class="modal fade" id="editTaxModal" tabindex="-1" aria-labelledby="editTaxModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg">
                <div class="modal-header bg-warning text-white">
                    <h5 class="modal-title" id="editTaxModalLabel">
                        <i class="fas fa-percentage me-2"></i> Ubah Tarif Pajak
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <form id="taxForm" method="POST" action="{{ route('pajak.update') }}">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="taxValue" class="form-label fw-bold">Persentase Potongan</label>
                            <div class="input-group">
                                <input type="number" class="form-control" id="taxValue" name="tax_percentage"
                                    value="{{ old('tax_percentage', $pajak->pajak) }}" min="0" max="100" step="0.01"
                                    required>
                                <span class="input-group-text bg-light-warning border-warning">%</span>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer border-0">
                        <button type="button" class="btn btn-outline-secondary rounded-pill px-4" data-bs-dismiss="modal">
                            <i class="fas fa-times me-1"></i> Batal
                        </button>
                        <button type="submit" class="btn btn-warning rounded-pill px-4 text-white">
                            <i class="fas fa-save me-1"></i> Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <style>
        /* ======= Card Gradient & Colors ======= */
        .bg-gradient-income {
            background: linear-gradient(135deg, #4e54c8 0%, #8f94fb 100%);
            border-radius: 10px;
            transition: all 0.3s ease;
        }

        .bg-gradient-tax {
            background: linear-gradient(135deg, #ff7300 0%, #ffa600 100%);
            border-radius: 10px;
            transition: all 0.3s ease;
        }

        .bg-gradient-income:hover,
        .bg-gradient-tax:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        }

        .bg-white-10 {
            background-color: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(5px);
        }

        .text-white-75 {
            color: rgba(255, 255, 255, 0.75);
        }

        .bg-light-primary {
            background: #f0f4ff;
        }

        .border-primary {
            border-color: #4e54c8 !important;
        }

        .bg-light-warning {
            background: #fff6e6;
        }

        .border-warning {
            border-color: #ff7300 !important;
        }

        /* ======= Misc ======= */
        .modal-content {
            border-radius: 12px;
            overflow: hidden;
        }

        .display-5 {
            font-size: 2.5rem;
        }

        .alert {
            border-radius: 10px;
        }

        .btn-close-white {
            filter: invert(1) grayscale(100%) brightness(200%);
        }
    </style>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // Isi nilai modal pendapatan
            const incomeModal = document.getElementById('editIncomeModal');
            if (incomeModal) {
                incomeModal.addEventListener('show.bs.modal', e => {
                    const btn = e.relatedTarget;
                    const value = btn.getAttribute('data-value');
                    document.getElementById('incomeValue').value = value;
                });
            }

            // Isi nilai modal pajak
            const taxModal = document.getElementById('editTaxModal');
            if (taxModal) {
                taxModal.addEventListener('show.bs.modal', e => {
                    const btn = e.relatedTarget;
                    const value = btn.getAttribute('data-value');
                    document.getElementById('taxValue').value = value;
                });
            }

            // Validasi pendapatan
            const incomeForm = document.getElementById('incomeForm');
            if (incomeForm) {
                incomeForm.addEventListener('submit', e => {
                    const val = parseFloat(document.getElementById('incomeValue').value);
                    if (isNaN(val) || val < 0) {
                        e.preventDefault();
                        alert('Tarif pendapatan tidak boleh negatif');
                    }
                });
            }

            // Validasi pajak
            const taxForm = document.getElementById('taxForm');
            if (taxForm) {
                taxForm.addEventListener('submit', e => {
                    const val = parseFloat(document.getElementById('taxValue').value);
                    if (isNaN(val) || val < 0 || val > 100) {
                        e.preventDefault();
                        alert('Persentase harus 0 – 100');
                    }
                });
            }
        });
    </script>
@endpush