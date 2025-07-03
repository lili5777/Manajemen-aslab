@extends('admin.layout.master')
@section('konten')
    <div class="page-wrapper">
        <div class="container-fluid">
            <!-- Header with Breadcrumb -->
            <div class="row page-titles my-2">
                <div class="col-md-5 align-self-center">
                    <h4 class="text-themecolor">
                        <i class="fas fa-user-cog me-2"></i> Pengaturan Batasan Sistem
                    </h4>
                    {{-- <div class="d-flex align-items-center">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('admin') }}"><i class="fas fa-home"></i></a></li>
                            <li class="breadcrumb-item active text-primary">Batas Sistem</li>
                        </ol>
                    </div> --}}
                </div>
            </div>

            <!-- Main Content -->
            <div class="row">
                <div class="col-12">
                    <div class="card border-0 shadow-lg">
                        <div class="card-body">
                            <!-- Additional Information -->
                            <div class="mt-2">
                                <div class="alert alert-info border-0 bg-light-info shadow-sm">
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-info-circle me-3 fs-4 text-info"></i>
                                        <div>
                                            <h6 class="text-info mb-1">Informasi Penting</h6>
                                            <p class="mb-0">
                                                Pengaturan ini akan mempengaruhi:
                                            <ul class="mb-0 ps-3">
                                                <li>Validasi kualifikasi asisten dosen</li>
                                                <li>Proses sertifikasi</li>
                                            </ul>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Notification Alerts -->
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

                            <!-- Settings Cards Row -->
                            <div class="row">
                                <!-- Schedule Limit Card -->
                                <div class="col-md-6 mb-4">
                                    <div class="card bg-gradient-primary h-100 overflow-hidden">
                                        <div class="card-body p-4">
                                            <div class="d-flex justify-content-between align-items-center h-100">
                                                <div class="me-3">
                                                    <h4 class="fw-bold mb-1">
                                                        <i class="fas fa-calendar-alt me-2"></i> Batas Jadwal
                                                    </h4>
                                                    <p class="mb-0 opacity-75">Maksimal jadwal per asisten dosen</p>
                                                </div>
                                                <div class="text-end">
                                                    <span class="display-5 fw-bold">{{ $setting->batasan_asdos }}</span>
                                                    <p class="mb-0 opacity-75">Jadwal/Asdos</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-footer bg-white text-end py-2">
                                            <button class="btn btn-sm btn-warning rounded-pill px-3 text-white"
                                                data-bs-toggle="modal" data-bs-target="#editScheduleModal"
                                                data-value="{{ $setting->batasan_asdos }}">
                                                <i class="fas fa-pencil-alt me-1"></i> Ubah
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                <!-- Certificate Limit Card -->
                                <div class="col-md-6 mb-4">
                                    <div class="card bg-gradient-success h-100 overflow-hidden">
                                        <div class="card-body p-4">
                                            <div class="d-flex justify-content-between align-items-center h-100">
                                                <div class="me-3">
                                                    <h4 class="fw-bold mb-1">
                                                        <i class="fas fa-certificate me-2"></i> Batas Sertifikat
                                                    </h4>
                                                    <p class="mb-0 opacity-75">Minimal Aslab hadir untuk dapat sertifikat</p>
                                                </div>
                                                <div class="text-end">
                                                    <span
                                                        class="display-5 fw-bold">{{ $setting->minimal_sertifikat }}</span>
                                                    <p class="mb-0 opacity-75">Kehadiran</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-footer bg-white text-end py-2">
                                            <button class="btn btn-sm btn-warning rounded-pill px-3 text-white"
                                                data-bs-toggle="modal" data-bs-target="#editCertModal"
                                                data-value="{{ $setting->minimal_sertifikat }}">
                                                <i class="fas fa-pencil-alt me-1"></i> Ubah
                                            </button>
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

    <!-- Edit Schedule Limit Modal -->
    <div class="modal fade" id="editScheduleModal" tabindex="-1" aria-labelledby="editScheduleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="editScheduleModalLabel">
                        <i class="fas fa-calendar-edit me-2"></i> Ubah Batas Jadwal
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <form id="scheduleForm" method="POST" action="{{ route('setting.batasan.update') }}">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="setting_type" value="schedule">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="scheduleValue" class="form-label fw-bold">Maksimal Jadwal per Asdos</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light-primary border-primary">
                                    <i class="fas fa-calendar-check text-primary"></i>
                                </span>
                                <input type="number" class="form-control" id="scheduleValue" name="batasan_asdos"
                                    value="{{ old('batasan_asdos', $setting->batasan_asdos) }}" min="1" max="20" required>
                                <span class="input-group-text bg-light-primary border-primary">Jadwal</span>
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

    <!-- Edit Certificate Limit Modal -->
    <div class="modal fade" id="editCertModal" tabindex="-1" aria-labelledby="editCertModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg">
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title" id="editCertModalLabel">
                        <i class="fas fa-certificate me-2"></i> Ubah Batas Sertifikat
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <form id="certForm" method="POST" action="{{ route('setting.batasan.update') }}">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="setting_type" value="certificate">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="certValue" class="form-label fw-bold">Minimal Sertifikat</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light-success border-success">
                                    <i class="fas fa-award text-success"></i>
                                </span>
                                <input type="number" class="form-control" id="certValue" name="minimal_sertifikat"
                                    value="{{ old('minimal_sertifikat', $setting->minimal_sertifikat) }}" min="0" max="10" required>
                                <span class="input-group-text bg-light-success border-success">Sertifikat</span>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer border-0">
                        <button type="button" class="btn btn-outline-secondary rounded-pill px-4" data-bs-dismiss="modal">
                            <i class="fas fa-times me-1"></i> Batal
                        </button>
                        <button type="submit" class="btn btn-success rounded-pill px-4">
                            <i class="fas fa-save me-1"></i> Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        .card.bg-gradient-primary {
            background: linear-gradient(135deg, #3a7bd5 0%, #00d2ff 100%);
            border: none;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(58, 123, 213, 0.3);
        }

        .card.bg-gradient-success {
            background: linear-gradient(135deg, #00b09b 0%, #96c93d 100%);
            border: none;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0, 176, 155, 0.3);
        }

        .modal-content {
            border-radius: 12px;
            overflow: hidden;
        }

        .input-group-text {
            transition: all 0.3s ease;
        }

        .form-control:focus+.input-group-text,
        .form-control:focus~.input-group-text {
            background-color: #e3f2fd;
        }

        .btn-outline-secondary:hover {
            background-color: #f8f9fa;
        }

        .alert {
            border-radius: 10px;
        }

        .display-5 {
            font-size: 2.5rem;
        }
    </style>
@endpush

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Debugging - cek apakah script terload
            console.log('Script loaded');

            // Fungsi untuk menampilkan toast
            function showToast(message) {
                const toastEl = document.getElementById('validationToast');
                const toastBody = toastEl.querySelector('.toast-body');
                toastBody.innerHTML = `<i class="fas fa-exclamation-circle me-2"></i>${message}`;
                const toast = new bootstrap.Toast(toastEl);
                toast.show();
            }

            // Modal Batas Jadwal
            const scheduleModal = document.getElementById('editScheduleModal');
            if (scheduleModal) {
                scheduleModal.addEventListener('show.bs.modal', function (event) {
                    const button = event.relatedTarget;
                    const value = button.getAttribute('data-value');
                    console.log('Schedule value:', value); // Debugging
                    document.getElementById('scheduleValue').value = value;
                });
            }

            // Modal Sertifikat
            const certModal = document.getElementById('editCertModal');
            if (certModal) {
                certModal.addEventListener('show.bs.modal', function (event) {
                    const button = event.relatedTarget;
                    const value = button.getAttribute('data-value');
                    console.log('Certificate value:', value); // Debugging
                    document.getElementById('certValue').value = value;
                });
            }

            // Validasi Form
            const scheduleForm = document.getElementById('scheduleForm');
            if (scheduleForm) {
                scheduleForm.addEventListener('submit', function (e) {
                    const val = parseInt(document.getElementById('scheduleValue').value);
                    if (isNaN(val) || val < 1 || val > 20) {
                        e.preventDefault();
                        showToast('Nilai jadwal harus antara 1-20');
                    }
                });
            }

            const certForm = document.getElementById('certForm');
            if (certForm) {
                certForm.addEventListener('submit', function (e) {
                    const val = parseInt(document.getElementById('certValue').value);
                    if (isNaN(val) || val < 0 || val > 10) {
                        e.preventDefault();
                        showToast('Nilai sertifikat harus antara 0-10');
                    }
                });
            }
        });
    </script>
@endpush