@extends('admin.layout.master')
@section('konten')
    <div class="page-wrapper">
        <div class="content">
            <div class="page-header">
                <div class="page-title">
                    <h4>Data Jadwal</h4>
                    <h6>Kelola Jadwal</h6>
                </div>
                @if (auth()->user()->role == 'admin')
                    <div class="page-btn">
                        <a href="{{ route('tambahjadwal') }}" class="btn btn-added"><img src="{{ asset('img/icons/plus.svg') }}"
                                alt="img" class="me-1">Tambah Jadwal</a>
                    </div>
                @endif
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
                                                        src="{{ asset('img/icons/search-whites.svg') }}" alt="img"></a>
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
                                    <th>Hari</th>
                                    <th>Pukul</th>
                                    <th>Ruang</th>
                                    <th>Kelas</th>
                                    <th>Prodi</th>
                                    <th>Semester</th>
                                    <th>Matkul</th>
                                    <th>Dosen</th>
                                    <th>Asdos 1</th>
                                    <th>Asdos 2</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($jadwal as $a)
                                    <tr>
                                        <td>
                                            <label class="checkboxs">
                                                <input type="checkbox">
                                                <span class="checkmarks"></span>
                                            </label>
                                        </td>
                                        <td>{{ $a->hari }}</td>
                                        <td>{{ substr($a->pukul, 0, 5) }} -
                                            {{ \Carbon\Carbon::createFromFormat('H:i', substr($a->pukul, 0, 5))->addMinutes(100)->format('H:i') }}
                                        </td>
                                        <td>{{ $a->ruang }}</td>
                                        <td>{{ $a->kode_kelas }}</td>
                                        <td>{{ $a->prodi }}</td>
                                        <td>{{ $a->semester }}</td>
                                        <td>{{ $a->nama_matkul }}</td>
                                        <td>{{ $a->nama_dosen }}</td>
                                        <td>
                                            @if ($a->asdos1)
                                                {{ $a->asdos1 }}
                                            @else
                                                @if (auth()->user()->role == 'admin' || auth()->user()->role == 'dosen')
                                                    Belum ada
                                                @else
                                                    <a href="{{route('ambilkelas', $a->id)}}"
                                                        class="btn btn-primary text-white btn-sm">Ambil Kelas</a>
                                                @endif
                                            @endif
                                        </td>
                                        <td>
                                            @if ($a->asdos2)
                                                {{ $a->asdos2 }}
                                            @else
                                                @if (auth()->user()->role == 'admin' || auth()->user()->role == 'dosen')
                                                    Belum ada
                                                @else
                                                    @if ($asdos)
                                                        <a href="{{route('ambilkelas2', $a->id)}}"
                                                            class="btn btn-primary text-white btn-sm">Ambil Kelas</a>
                                                    @else
                                                        Belum bisa ambil kelas
                                                    @endif

                                                @endif
                                            @endif
                                        </td>
                                        <td>
                                            @if (auth()->user()->role == 'admin')
                                                <a class="me-3" href="{{ route('editjadwal', $a->id) }}">
                                                    <img src="{{ asset('img/icons/edit.svg') }}" alt="img">
                                                </a>
                                                <a class="confirm-text" href="javascript:void(0);"
                                                    data-url="{{ route('hapusjadwal', $a->id) }}">
                                                    <img src="{{ asset('img/icons/delete.svg') }}" alt="img">
                                                </a>
                                            @endif

                                        </td>
                                    </tr>
                                @empty
                                @endforelse

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>



    <!-- Success Modal -->
    <div class="modal fade" id="successModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 rounded-4 overflow-hidden">
                <!-- Animated background -->
                <div class="position-absolute w-100 h-100 bg-success bg-opacity-05" style="z-index: -1;"></div>

                <div class="modal-body p-4 text-center">
                    <!-- Animated icon -->
                    <div class="success-icon mb-3">
                        <div
                            class="icon-circle bg-success bg-opacity-10 d-inline-flex align-items-center justify-content-center">
                            <i class="bi bi-check2-all text-success fs-1"></i>
                        </div>
                    </div>

                    <h5 class="modal-title fw-bold mb-3">Berhasil Mengambil Kelas!</h5>

                    <p class="text-muted mb-3">Anda berhasil mengambil kelas ini</p>

                    <div class="d-inline-block bg-success bg-opacity-10 px-3 py-2 rounded-3 mb-3">
                        <span class="text-success fw-medium">
                            <i class="bi bi-calendar-check me-2"></i>
                            <span>Kelas: {{ session('jadwal') }}</span>
                        </span>
                    </div>
                </div>

                <div class="modal-footer border-0 pt-0 pb-4 px-4 justify-content-center">
                    <button type="button" class="btn btn-success rounded-3 px-4 hover-grow" data-bs-dismiss="modal">
                        <i class="bi bi-arrow-left-circle me-2"></i> Kembali ke Jadwal
                    </button>
                </div>
            </div>
        </div>
    </div>


    <!-- Error Modal -->
    <div class="modal fade" id="errorModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 rounded-4 overflow-hidden">
                <div class="modal-body p-4 text-center">
                    <div class="error-icon mb-3">
                        <div
                            class="icon-circle bg-danger bg-opacity-10 d-inline-flex align-items-center justify-content-center">
                            <i class="bi bi-x-circle text-danger fs-1"></i>
                        </div>
                    </div>

                    <h5 class="modal-title fw-bold mb-3 text-danger">Gagal Mengambil Kelas</h5>

                    <p class="text-muted mb-3">{{ session('error') }}</p>


                </div>

                <div class="modal-footer border-0 pt-0 pb-4 px-4 justify-content-center">
                    <button type="button" class="btn btn-danger rounded-3 px-4 hover-grow" data-bs-dismiss="modal">
                        <i class="bi bi-arrow-left-circle me-2"></i> Mengerti
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

        .error-icon {
            animation: shake 0.6s ease-out;
        }

        @keyframes shake {

            0%,
            100% {
                transform: translateX(0);
            }

            20%,
            60% {
                transform: translateX(-5px);
            }

            40%,
            80% {
                transform: translateX(5px);
            }
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
            box-shadow: 0 5px 15px rgba(220, 53, 69, 0.3);
        }
    </style>

    <script>
        @if(session('success') && session('jadwal'))
            document.addEventListener('DOMContentLoaded', function () {
                setTimeout(function () {
                    const successModal = new bootstrap.Modal(document.getElementById('successModal'));
                    successModal.show();
                }, 300);
            });
        @endif
        @if(session('error'))
            document.addEventListener('DOMContentLoaded', function () {
                setTimeout(function () {
                    const errorModal = new bootstrap.Modal(document.getElementById('errorModal'));
                    errorModal.show();
                }, 300);
            });
        @endif
    </script>
@endsection