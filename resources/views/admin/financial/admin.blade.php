@extends('admin.layout.master')
@section('konten')
    <div class="page-wrapper">
        <div class="content">
            <!-- Header -->
            <div class="page-header mb-4">
                <div class="row align-items-center">
                    <div class="col">
                        <h4 class="fw-bold mb-1">Laporan Keuangan Asisten Dosen</h4>
                        <p class="text-muted mb-0">Detail pendapatan berdasarkan kehadiran</p>
                    </div>
                </div>
            </div>

            <div class="row g-4 mb-4">
                <!-- Attendance Card -->
                <div class="col-md-6 col-lg-4">
                    <div class="card border-0 shadow-sm h-100 hover-scale">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <span class="text-muted">Total Asdos</span>
                                    <h2 class="mt-2 mb-0 fw-bold fs-5">{{$asdos->count()}}</h2>
                                </div>
                                <div class="bg-primary bg-opacity-10 p-2 rounded">
                                    <i class="fas fa-calendar-check text-primary fs-4"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Gross Income Card -->
                <div class="col-md-6 col-lg-4">
                    <div class="card border-0 shadow-sm h-100 hover-scale">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <span class="text-muted">Total Kehadiran</span>
                                    <h2 class="mt-2 mb-0 fw-bold fs-5">{{$absen->count()}}</h2>
                                </div>
                                <div class="bg-success bg-opacity-10 p-2 rounded">
                                    <i class="fas fa-wallet text-success fs-4"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Net Income Card -->
                <div class="col-md-6 col-lg-4">
                    <div class="card border-0 shadow-sm h-100 hover-scale">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <span class="text-muted">Pengeluaran</span>
                                    <h2 class="mt-2 mb-0 fw-bold text-success fs-5">Rp.{{$pengeluaran}}</h2>
                                </div>
                                <div class="bg-info bg-opacity-10 p-2 rounded">
                                    <i class="fas fa-hand-holding-usd text-info fs-4"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
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
                                <a class="btn btn-searchset"><img src="{{ asset('img/icons/search-white.svg') }}" alt="img"></a>
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
                                    <th>STB/NIDN</th>
                                    <th>Nama</th>
                                    <th>Jurusan</th>
                                    <th>Kehadiran</th>
                                    <th>Pendapatan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($asdos as $a)
                                    <tr><td>
                                        <label class="checkboxs">
                                            <input type="checkbox">
                                            <span class="checkmarks"></span>
                                        </label>
                                    </td>
                                    <td>{{$a->stb}}</td>
                                    <td>{{$a->nama}}</td>
                                    <td>{{$a->jurusan}}</td>
                                    <td>{{$a->kehadiran}}</td>
                                    <td>Rp.{{$a->pendapatan}}</td>
                                    </tr>
                                @empty
                                    <p>Tidak ada data</p>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>


        </div>
    </div>

    <style>
        /* Modern Card Styles */
        .card {
            border-radius: 12px;
            transition: all 0.3s ease;
            overflow: hidden;
            border: none;
        }

        .hover-scale:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1) !important;
        }

        /* Modern Timeline */
        .timeline-vertical {
            position: relative;
            padding-left: 50px;
        }

        .timeline-item {
            position: relative;
            padding-bottom: 30px;
        }

        .timeline-badge {
            position: absolute;
            left: -50px;
            top: 0;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            box-shadow: 0 0 0 5px rgba(40, 167, 69, 0.1);
            z-index: 2;
        }

        .timeline-panel {
            position: relative;
            background: white;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            border: 1px solid rgba(0, 0, 0, 0.05);
        }

        .timeline-panel:before {
            content: '';
            position: absolute;
            top: 20px;
            left: -15px;
            width: 0;
            height: 0;
            border-style: solid;
            border-width: 15px 15px 15px 0;
            border-color: transparent #fff transparent transparent;
        }

        .timeline-header {
            padding-bottom: 15px;
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
            margin-bottom: 15px;
        }

        .timeline-body {
            margin-bottom: 15px;
        }

        .timeline-footer {
            padding-top: 15px;
            border-top: 1px solid rgba(0, 0, 0, 0.05);
        }

        /* Custom Badges */
        .badge {
            padding: 5px 10px;
            font-weight: 500;
            letter-spacing: 0.3px;
            border-radius: 6px;
        }

        /* Responsive adjustments */
        @media (max-width: 767.98px) {
            .timeline-vertical {
                padding-left: 30px;
            }

            .timeline-badge {
                left: -30px;
                width: 30px;
                height: 30px;
                font-size: 0.8rem;
            }
        }
    </style>
@endsection