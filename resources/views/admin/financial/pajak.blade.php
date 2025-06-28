@extends('admin.layout.master')

@section('konten')
    <div class="page-wrapper">
        <div class="container-fluid">
            <!-- Header -->
            <div class="row page-titles my-2">
                <div class="col-md-5 align-self-center">
                    <h4 class="text-themecolor fw-bold my-2">
                        <i class="fas fa-percentage me-2"></i> Pengaturan Pajak / Potongan Gaji
                    </h4>
                </div>
            </div>

            <!-- Content -->
            <div class="row">
                <div class="col-12">
                    <div class="card border-0 shadow-lg">
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

                            <!-- Card Pajak -->
                            <div class="row">
                                <div class="col-12 mb-4">
                                    <div class="card bg-gradient-tax h-100 overflow-hidden">
                                        <div class="card-body p-4">
                                            <div class="d-flex justify-content-between align-items-center h-100">
                                                <div class="me-3">
                                                    <h4 class="fw-bold mb-1">
                                                        <i class="fas fa-receipt me-2"></i> Tarif Pajak
                                                    </h4>
                                                    <p class="mb-0 opacity-75">Persentase potongan gaji bersih</p>
                                                </div>
                                                <div class="text-end">
                                                    <span class="display-5 fw-bold">{{ $pajak->pajak }}%</span>
                                                    <p class="mb-0 opacity-75">Potongan</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-footer bg-white text-end py-2">
                                            <button class="btn btn-sm btn-warning rounded-pill px-3 text-white"
                                                data-bs-toggle="modal" data-bs-target="#editTaxModal"
                                                data-value="{{ $pajak->pajak }}">
                                                <i class="fas fa-pencil-alt me-1"></i> Ubah
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div><!-- /.row -->
                        </div><!-- /.card-body -->
                    </div><!-- /.card -->
                </div>
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div><!-- /.page-wrapper -->

    <!-- Modal Edit Pajak -->
    <div class="modal fade" id="editTaxModal" tabindex="-1" aria-labelledby="editTaxModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg">
                <div class="modal-header bg-taxx ">
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
                                    value="{{ old('tax_percentage', $pajak->pajak) }}" min="0" max="100"
                                    step="0.01" required>
                                <span class="input-group-text bg-light-tax border-tax">%</span>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer border-0">
                        <button type="button" class="btn btn-outline-secondary rounded-pill px-4" data-bs-dismiss="modal">
                            <i class="fas fa-times me-1"></i> Batal
                        </button>
                        <button type="submit" class="btn btn-tax rounded-pill px-4">
                            <i class="fas fa-save me-1"></i> Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <style>
        /* ======= Card Gradient & Colors ======= */
        /* .bg-gradient-tax {
            background: linear-gradient(135deg, #ff7300 0%, #ef32d9 100%);
            border: none;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(255, 115, 0, .35);
        } */

        /* .bg-taxx {
            background: #ff7300;
        } */

        .btn-tax {
            background: #ff7300;
            color: #fff;
            border: none;
        }

        .btn-tax:hover {
            background: #e86100;
            color: #fff;
        }

        .border-tax {
            border-color: #ff7300;
        }

        .bg-light-tax {
            background: #fff6f0;
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
    </style>
@endsection



@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // Isi nilai saat modal muncul
            const taxModal = document.getElementById('editTaxModal');
            if (taxModal) {
                taxModal.addEventListener('show.bs.modal', e => {
                    const btn = e.relatedTarget;
                    const value = btn.getAttribute('data-value');
                    document.getElementById('taxValue').value = value;
                });
            }

            // Validasi sederhana
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