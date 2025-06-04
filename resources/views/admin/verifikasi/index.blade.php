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
                        <form action="{{ route('postverifikasi') }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-success btn-lg px-4"><i class="fas fa-user-check"></i>
                                Verifikasi</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="errorModal" tabindex="-1" aria-labelledby="successModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-sm">
            <div class="modal-content border-0 rounded-4 overflow-hidden">
                <!-- Animated checkmark background -->
                <div class="position-absolute w-100 h-100 bg-danger bg-opacity-05" style="z-index: -1;">
                    <div class="error-checkmark">
                        <svg viewBox="0 0 52 52" class="animate-check">
                            <circle cx="26" cy="26" r="25" fill="none" class="circle" />
                            <path fill="none" d="M14.1 27.2l7.1 7.2 16.7-16.8" class="check" />
                        </svg>
                    </div>
                </div>

                <!-- Modal content -->
                <div class="modal-body p-4 text-center">
                    <!-- Animated icon -->
                    <div class="success-icon mb-3">
                        <div
                            class="icon-circle bg-success bg-opacity-10 d-inline-flex align-items-center justify-content-center">
                            <i class="bi bi-check2-circle text-success fs-1"></i>
                        </div>
                    </div>

                    <h5 class="modal-title fw-bold mb-3" id="successModalLabel">Verifikasi Gagal!</h5>

                    <p class="text-muted mb-3">{{ session('error') }}</p>

                </div>

                <div class="modal-footer border-0 pt-0 pb-4 px-4 justify-content-center">
                    <button type="button" class="btn btn-danger rounded-3 px-4 hover-grow" data-bs-dismiss="modal">
                        <i class="bi bi-check-lg me-2"></i> Mengerti
                    </button>
                </div>
            </div>
        </div>
    </div>


    <style>
        /* Animations and styling */
        .modal-content {
            box-shadow: 0 10px 30px rgba(40, 167, 69, 0.2);
            border: none !important;
        }

        .success-checkmark {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            opacity: 0.1;
        }

        .success-checkmark svg {
            width: 100px;
            height: 100px;
        }

        .icon-circle {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            transition: all 0.3s ease;
        }

        .hover-grow {
            transition: all 0.2s ease;
        }

        .hover-grow:hover {
            transform: scale(1.05);
            box-shadow: 0 5px 15px rgba(40, 167, 69, 0.3);
        }

        /* Checkmark animation */
        .animate-check .circle {
            stroke: #28a745;
            stroke-dasharray: 166;
            stroke-dashoffset: 166;
            stroke-width: 2;
            stroke-miterlimit: 10;
            fill: none;
            animation: stroke 0.6s cubic-bezier(0.65, 0, 0.45, 1) forwards;
        }

        .animate-check .check {
            transform-origin: 50% 50%;
            stroke: #28a745;
            stroke-dasharray: 48;
            stroke-dashoffset: 48;
            stroke-width: 3;
            stroke-miterlimit: 10;
            animation: stroke 0.3s cubic-bezier(0.65, 0, 0.45, 1) 0.4s forwards;
        }

        @keyframes stroke {
            100% {
                stroke-dashoffset: 0;
            }
        }

        /* Icon animation */
        .success-icon {
            animation: bounceIn 0.6s ease-out;
        }

        @keyframes bounceIn {
            0% {
                transform: scale(0.8);
                opacity: 0;
            }

            50% {
                transform: scale(1.1);
            }

            100% {
                transform: scale(1);
                opacity: 1;
            }
        }
    </style>

    <script>
        @if(session('error'))
            document.addEventListener('DOMContentLoaded', function () {
                // Add slight delay for better UX
                setTimeout(function () {
                    const successModal = new bootstrap.Modal(document.getElementById('errorModal'));
                    successModal.show();

                    // Optional: Add confetti effect
                    if (typeof confetti === 'function') {
                        confetti({
                            particleCount: 100,
                            spread: 70,
                            origin: { y: 0.6 },
                            colors: ['#28a745', '#5cb85c']
                        });
                    }
                }, 300);
            });
        @endif
    </script>
@endsection
