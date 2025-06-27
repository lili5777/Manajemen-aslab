@extends('admin.layout.master')
@section('konten')
    <div class="page-wrapper">
        <div class="content">
            <div class="page-header">
                <div class="page-title">
                    <h4>Data Pendaftar</h4>
                    <h6>Kelola Pendaftar</h6>
                </div>
                {{-- @if (auth()->user()->role == 'admin')
                <div class="page-btn">
                    <a href="{{ route('tambahpendaftar') }}" class="btn btn-added"><img src="{{ asset('img/icons/plus.svg') }}"
                            alt="img" class="me-1">Tambah Pendaftar</a>
                </div>
                @endif --}}
            </div>

            <div class="card">
                <div class="card-body">
                    <div class="table-top">
                        <div class="search-set">
                            <div class="search-path">
                                <a class="btn btn-filter" id="filter_search">
                                    <img src="{{ asset('img/icons/filter.svg') }}" alt="img">
                                    <span><img src="{{ asset('img/icons/closes.svg') }}" alt="img"></span>
                                </a>
                            </div>
                            <div class="search-input">
                                <a class="btn btn-searchset"><img src="{{ asset('img/icons/search-white.svg') }}"
                                        alt="img"></a>
                            </div>
                        </div>
                        <div class="wordset">
                            <ul>
                                <li>
                                    <a data-bs-toggle="tooltip" data-bs-placement="top" title="pdf"><img
                                            src="{{ asset('img/icons/pdf.svg') }}" alt="img"></a>
                                </li>
                                <li>
                                    <a data-bs-toggle="tooltip" data-bs-placement="top" title="excel"><img
                                            src="{{ asset('img/icons/excel.svg') }}" alt="img"></a>
                                </li>
                                <li>
                                    <a data-bs-toggle="tooltip" data-bs-placement="top" title="print"><img
                                            src="{{ asset('img/icons/printer.svg') }}" alt="img"></a>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <div class="card mb-0" id="filter_inputs">
                        <div class="card-body pb-0">
                            <div class="row">
                                <div class="col-lg-12 col-sm-12">
                                    <div class="row">
                                        <div class="col-lg col-sm-6 col-12">
                                            <div class="form-group">
                                                <select class="select">
                                                    <option>Choose Product</option>
                                                    <option>Macbook pro</option>
                                                    <option>Orange</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg col-sm-6 col-12">
                                            <div class="form-group">
                                                <select class="select">
                                                    <option>Choose Category</option>
                                                    <option>Computers</option>
                                                    <option>Fruits</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg col-sm-6 col-12">
                                            <div class="form-group">
                                                <select class="select">
                                                    <option>Choose Sub Category</option>
                                                    <option>Computer</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg col-sm-6 col-12">
                                            <div class="form-group">
                                                <select class="select">
                                                    <option>Brand</option>
                                                    <option>N/D</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg col-sm-6 col-12 ">
                                            <div class="form-group">
                                                <select class="select">
                                                    <option>Price</option>
                                                    <option>150.00</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-1 col-sm-6 col-12">
                                            <div class="form-group">
                                                <a class="btn btn-filters ms-auto"><img
                                                        src="assets/img/icons/search-whites.svg" alt="img"></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table  datanew">
                            <thead>
                                <tr>
                                    <th>
                                        <label class="checkboxs">
                                            <input type="checkbox" id="select-all">
                                            <span class="checkmarks"></span>
                                        </label>
                                    </th>
                                    <th>Foto</th>
                                    <th>Nama</th>
                                    <th>Stambuk </th>
                                    <th>Jurusan</th>
                                    <th>WA</th>
                                    <th>Skor</th>
                                    <th>Rank</th>
                                    <th>periode</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($asdos as $p)
                                    <tr>
                                        <td>
                                            <label class="checkboxs">
                                                <input type="checkbox">
                                                <span class="checkmarks"></span>
                                            </label>
                                        </td>
                                        <td class="productimgname">
                                            <a href="javascript:void(0);" class="product-img">
                                                <img src="{{ asset('img/asdos/' . $p->foto) }}" alt="asdos">
                                            </a>
                                        </td>
                                        <td>{{ $p->nama }}</td>
                                        <td>{{ $p->stb }}</td>
                                        <td>{{ $p->jurusan }}</td>
                                        <td>{{ $p->no_wa }}</td>
                                        <td>{{ $p->skor }}</td>
                                        <td>{{ $p->rank }}</td>
                                        <td>{{$periode->where('id', $p->periode)->first()->semester}} <br>{{ $periode->where('id', $p->periode)->first()->tahun }}</td>
                                        <td>
                                            {{-- <a class="me-3" href="{{ route('detailasdos', $p->id) }}">
                                                <img src="{{ asset('img/icons/eye.svg') }}" alt="img">
                                            </a> --}}
                                            @if (auth()->user()->role == 'admin')
                                                <a href="{{ route('idcard.show', $p->id) }}"><img src="{{ asset('img/icons/download.svg') }}" alt="img"></a>
                                                <a class="confirm-text" href="javascript:void(0);"
                                                    data-url="{{ route('hapusasdos', $p->id) }}">
                                                    <img src="{{ asset('img/icons/delete.svg') }}" alt="img">
                                                </a>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>


    <div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="successModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-sm">
            <div class="modal-content border-0 rounded-4 overflow-hidden">
                <!-- Animated checkmark background -->
                <div class="position-absolute w-100 h-100 bg-success bg-opacity-05" style="z-index: -1;">
                    <div class="success-checkmark">
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

                    <h5 class="modal-title fw-bold mb-3" id="successModalLabel">Verifikasi Berhasil!</h5>

                    <p class="text-muted mb-3">{{ session('success') }}</p>

                    <div class="d-inline-block bg-success bg-opacity-10 px-3 py-2 rounded-3 mb-3">
                        <span class="text-success fw-medium">
                            <i class="bi bi-people-fill me-2"></i>
                            <span>Total Lulus: {{ session('jumlah_lulus') }}</span>
                        </span>
                    </div>
                </div>

                <div class="modal-footer border-0 pt-0 pb-4 px-4 justify-content-center">
                    <button type="button" class="btn btn-success rounded-3 px-4 hover-grow" data-bs-dismiss="modal">
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
        @if(session('success') && session('jumlah_lulus'))
            document.addEventListener('DOMContentLoaded', function () {
                // Add slight delay for better UX
                setTimeout(function () {
                    const successModal = new bootstrap.Modal(document.getElementById('successModal'));
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
